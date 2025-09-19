<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Order;    // adjust namespace to your app

class PosController extends Controller
{
    /**
     * Return the authenticated cashier's orders for the given day
     * plus a summary (total + breakdown by payment method).
     *
     * GET /api/pos/orders/today?date=YYYY-MM-DD&tz=Europe/Paris
     */
    public function ordersToday(Request $request)
    {
        $user = $request->user();
        abort_unless($user, 401);

        $date = $request->input('date'); // YYYY-MM-DD (optional; defaults today in tz)
        $tz   = $request->input('tz', config('app.timezone'));

        // Resolve start/end of selected day in user's tz, then convert to UTC for DB filtering
        $base = $date ? Carbon::createFromFormat('Y-m-d', $date, $tz) : Carbon::now($tz);
        $start = $base->copy()->startOfDay()->timezone('UTC');
        $end   = $base->copy()->endOfDay()->timezone('UTC');

        // Pull orders for this cashier, today, newest first
        $orders = Order::query()
            ->where(function ($q) use ($user) {
                // support either created_by or user_id columns
                $q->where('created_by', $user->id);
            })
            ->whereBetween('created_at', [$start, $end])
            ->with(['payments' => function ($q) {
                // If you need: $q->select('id','order_id','method','amount','amount_given','change_due');
            }])
            ->orderByDesc('created_at')
            ->get();

        // Build response list (normalize payments even if not split)
        $list = $orders->map(function ($o) {
            $payments = collect($o->payments ?? [])->map(function ($p) {
                return [
                    'method'       => strtolower($p->method ?? 'other'),
                    'amount'       => (float) ($p->amount ?? 0),
                    'amount_given' => isset($p->amount_given) ? (float) $p->amount_given : null,
                    'change_due'   => isset($p->change_due) ? (float) $p->change_due : null,
                ];
            })->values();

            // Fallback: single payment fields on order (if you store them there)
            if ($payments->isEmpty() && !empty($o->payment_method)) {
                $payments = collect([[
                    'method' => strtolower($o->payment_method),
                    'amount' => (float) ($o->total ?? 0),
                ]]);
            }

            return [
                'id'           => $o->id,
                'order_code'   => $o->order_code ?? null,
                'daily_order'  => $o->daily_order ?? null,
                'order_type'   => $o->order_type ?? null,
                'table_number' => $o->table_number ?? null,
                'total'        => (float) ($o->total ?? 0),
                'created_at'   => optional($o->created_at)->toIso8601String(),
                'payments'     => $payments,
            ];
        });

        // Summary
        $summary = [
            'count'     => $list->count(),
            'total'     => round($list->sum('total'), 2),
            'by_method' => ['cash' => 0.0, 'card' => 0.0, 'other' => 0.0],
        ];

        foreach ($list as $o) {
            $pays = collect($o['payments']);
            if ($pays->isEmpty()) {
                // treat as 'other' if somehow missing
                $summary['by_method']['other'] += (float) $o['total'];
                continue;
            }
            foreach ($pays as $p) {
                $m = in_array($p['method'], ['cash', 'card', 'other']) ? $p['method'] : 'other';
                $summary['by_method'][$m] += (float) ($p['amount'] ?? 0);
            }
        }

        // Round to 2 decimals
        foreach ($summary['by_method'] as $k => $v) {
            $summary['by_method'][$k] = round($v, 2);
        }

        return response()->json([
            'orders'  => $list,
            'summary' => $summary,
        ]);
    }

   
}
