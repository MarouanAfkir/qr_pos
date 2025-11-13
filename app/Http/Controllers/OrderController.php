<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemOption;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * GET /orders
     * Optional filters: status, type, q (order_code), date range (from,to)
     */
    public function index(Request $request)
    {

        $q = Order::query()->with(['items.options', 'payments']);

        if ($status = $request->string('status')->toString()) {
            $q->where('status', $status);
        }

        if ($orderType = ($request->string('order_type')->toString() ?: $request->string('type')->toString())) {
            $q->where('order_type', $orderType);
        }

        if ($search = $request->string('q')->toString()) {
            $q->where('order_code', 'like', "%{$search}%");
        }

        if ($from = $request->date('from')) {
            $q->where('created_at', '>=', $from->startOfDay());
        }

        if ($to = $request->date('to')) {
            $q->where('created_at', '<=', $to->endOfDay());
        }

        if ($createdBy = $request->integer('created_by')) {
            $q->where('created_by', $createdBy);
        }


        return $q->latest('id')->paginate($request->integer('per_page', 20));
    }

    /**
     * POST /orders
     * Payload shape (examples):
     *
     * {
     *   "restaurant_id": 3,
     *   "order_type": "dinein",        // dinein | takeaway | delivery
     *   "table_number": 12,            // optional for dinein
     *   "currency": "DH",
     *   "discount": { "type": "amount", "value": 0 }, // or {type:"percent", value:10}
     *   "hold": false,                 // true => status=held (no payment)
     *   "customer": { "name": "...", "phone": "..." }, // optional
     *   "notes": "no onions",
     *   "lines": [
     *     {
     *       "catalog_item_id": 2011,   // optional but recommended
     *       "catalog_category_id": 204,
     *       "item_name": "Tacos Marseille",
     *       "category_name": "Tacos Gratine",
     *       "image_url": "https://...",
     *       "base_unit_price": 45.00,  // required if unit_price not provided
     *       "unit_price": 52.00,       // optional (base + options); if absent, computed
     *       "quantity": 2,
     *       "preparation_time": 15,
     *       "min_qty": 1,
     *       "max_qty": null,
     *       "selections": [
     *         {
     *           "variation_name": "Frite",
     *           "catalog_variation_id": 307, // optional
     *           "options": [
     *             {
     *               "option_name": "Oui",
     *               "price_adjustment": 7.00,
     *               "catalog_option_id": 51,
     *               "sort_order": 0
     *             }
     *           ]
     *         }
     *       ]
     *     }
     *   ],
     *   "payment": {                    // optional; if present, payment is recorded
     *      "method": "cash",            // cash | card | other
     *      "amount": 104.00,            // if missing, will default to order total
     *      "amount_given": 120.00,      // for cash
     *      "paid_at": "2025-08-27T13:45:00Z"
     *   }
     * }
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'restaurant_id'   => ['nullable', 'integer'],
            'order_type'      => ['required', Rule::in([Order::TYPE_DINEIN, Order::TYPE_TAKEAWAY, Order::TYPE_DELIVERY])],
            'table_number'    => ['nullable', 'integer', 'min:1'],
            'currency'        => ['nullable', 'string', 'max:8'],
            'daily_order'        => ['nullable', 'numeric'],

            'discount.type'   => ['nullable', Rule::in([Order::DISC_AMOUNT, Order::DISC_PERCENT])],
            'discount.value'  => ['nullable', 'numeric', 'min:0'],

            'hold'            => ['sometimes', 'boolean'],

            'customer.name'   => ['nullable', 'string', 'max:120'],
            'customer.phone'  => ['nullable', 'string', 'max:40'],
            'notes'           => ['nullable', 'string'],

            'lines'           => ['required', 'array', 'min:1'],
            'lines.*.catalog_item_id'     => ['nullable', 'integer'],
            'lines.*.catalog_category_id' => ['nullable', 'integer'],
            'lines.*.item_name'           => ['required', 'string', 'max:180'],
            'lines.*.category_name'       => ['nullable', 'string', 'max:120'],
            'lines.*.image_url'           => ['nullable', 'string', 'max:1024'],
            'lines.*.base_unit_price'     => ['nullable', 'numeric', 'min:0'],
            'lines.*.unit_price'          => ['nullable', 'numeric', 'min:0'],
            'lines.*.quantity'            => ['required', 'integer', 'min:1'],

            'lines.*.selections'                  => ['nullable', 'array'],
            'lines.*.selections.*.variation_name' => ['required_with:lines.*.selections', 'string', 'max:160'],
            'lines.*.selections.*.catalog_variation_id' => ['nullable', 'integer'],
            'lines.*.selections.*.options'        => ['required_with:lines.*.selections', 'array', 'min:1'],
            'lines.*.selections.*.options.*.option_name'      => ['required', 'string', 'max:160'],
            'lines.*.selections.*.options.*.price_adjustment' => ['nullable', 'numeric'],
            'lines.*.selections.*.options.*.catalog_option_id' => ['nullable', 'integer'],
            'lines.*.selections.*.options.*.sort_order'       => ['nullable', 'integer', 'min:0'],

            'payment.method'       => ['nullable', Rule::in([OrderPayment::METHOD_CASH, OrderPayment::METHOD_CARD, OrderPayment::METHOD_OTHER])],
            'payment.amount'       => ['nullable', 'numeric', 'min:0'],
            'payment.amount_given' => ['nullable', 'numeric', 'min:0'],
            'payment.paid_at'      => ['nullable', 'date'],
        ]);

        $order = DB::transaction(function () use ($data) {
            // Header
            $order = new Order();
            $order->restaurant_id  = $data['restaurant_id'] ?? null;
            $order->order_type     = $data['order_type'];
            $order->daily_order     = $data['daily_order'];
            $order->table_number   = $data['table_number'] ?? null;
            $order->currency       = strtoupper(trim($data['currency'] ?? 'DH'));
            $order->customer_name  = data_get($data, 'customer.name');
            $order->customer_phone = data_get($data, 'customer.phone');
            $order->notes          = $data['notes'] ?? null;


            // Discount (raw input)
            $order->discount_type  = data_get($data, 'discount.type', Order::DISC_AMOUNT);
            $order->discount_value = (float) data_get($data, 'discount.value', 0);

            $order->status   = !empty($data['hold']) ? Order::STATUS_HELD : Order::STATUS_OPEN;
            $order->placed_at = now();
            $order->created_by = auth()->id() ?: null;
            $order->save();

            // Lines
            $subtotal = 0.0;

            foreach ($data['lines'] as $i => $line) {
                $quantity = max(1, (int) ($line['quantity'] ?? 1));

                // Sum options adj if unit_price is not provided
                $optionsAdj = 0.0;
                $selections = $line['selections'] ?? [];
                foreach ($selections as $sel) {
                    foreach (($sel['options'] ?? []) as $opt) {
                        $optionsAdj += (float) ($opt['price_adjustment'] ?? 0);
                    }
                }

                $base = (float) ($line['base_unit_price'] ?? 0);
                $unit = array_key_exists('unit_price', $line)
                    ? (float) $line['unit_price']
                    : (float) ($base + $optionsAdj);

                $orderItem = new OrderItem([
                    'catalog_item_id'     => $line['catalog_item_id']     ?? null,
                    'catalog_category_id' => $line['catalog_category_id'] ?? null,
                    'item_name'           => $line['item_name'],
                    'category_name'       => $line['category_name'] ?? null,
                    'image_url'           => $line['image_url']     ?? null,
                    'base_unit_price'     => $base,
                    'unit_price'          => $unit,
                    'quantity'            => $quantity,
                    'line_total'          => round($unit * $quantity, 2),

                ]);

                $order->items()->save($orderItem);
                $subtotal += (float) $orderItem->line_total;

                // Selected options snapshot
                foreach ($selections as $sortSel => $sel) {
                    $variationName = $sel['variation_name'] ?? 'Option';
                    $catalogVariationId = $sel['catalog_variation_id'] ?? null;

                    foreach (($sel['options'] ?? []) as $sortOpt => $opt) {
                        $optRow = new OrderItemOption([
                            'catalog_variation_id' => $catalogVariationId,
                            'catalog_option_id'    => $opt['catalog_option_id'] ?? null,
                            'variation_name'       => $variationName,
                            'option_name'          => $opt['option_name'],
                            'price_adjustment'     => (float) ($opt['price_adjustment'] ?? 0),
                            'sort_order'           => $opt['sort_order'] ?? ($sortSel * 100 + $sortOpt),
                        ]);
                        $orderItem->options()->save($optRow);
                    }
                }
            }

            // Totals (no service / tax)
            $order->subtotal = round($subtotal, 2);

            $discountAmount = 0.0;
            $raw = (float) ($order->discount_value ?? 0);
            if (($order->discount_type ?? Order::DISC_AMOUNT) === Order::DISC_PERCENT) {
                $discountAmount = max(0, min($order->subtotal, $order->subtotal * ($raw / 100)));
            } else {
                $discountAmount = max(0, min($order->subtotal, $raw));
            }
            $order->discount_amount = round($discountAmount, 2);
            $order->total = round(max(0, $order->subtotal - $order->discount_amount), 2);
            $order->save();

            // Optional payment
            if (!empty($data['payment']) && !empty($data['payment']['method'])) {
                $pay = $data['payment'];
                $amount = array_key_exists('amount', $pay)
                    ? (float) $pay['amount']
                    : (float) $order->total;

                $amountGiven = (float) ($pay['amount_given'] ?? 0);
                $changeDue   = max(0, round($amountGiven - $amount, 2));

                $payment = new OrderPayment([
                    'method'       => $pay['method'],
                    'amount'       => round($amount, 2),
                    'amount_given' => round($amountGiven, 2),
                    'change_due'   => $changeDue,
                    'status'       => OrderPayment::STATUS_CAPTURED,
                    'paid_at'      => data_get($pay, 'paid_at') ? now()->parse($pay['paid_at']) : now(),
                ]);

                $order->payments()->save($payment);

                // OrderPayment::booted() will auto markPaid if fully covered
                $order->refresh();
            }

            return $order->load(['items.options', 'payments']);
        });

        return response()->json($order, 201);
    }

    /**
     * GET /orders/{order}
     */
    public function show(Order $order)
    {
        return $order->load(['items.options', 'payments']);
    }

    /**
     * POST /orders/{order}/payments
     * { method: "cash|card|other", amount: 100, amount_given: 120, paid_at?: datetime }
     */
    public function addPayment(Request $request, Order $order)
    {
        $payload = $request->validate([
            'method'       => ['required', Rule::in([OrderPayment::METHOD_CASH, OrderPayment::METHOD_CARD, OrderPayment::METHOD_OTHER])],
            'amount'       => ['nullable', 'numeric', 'min:0'],
            'amount_given' => ['nullable', 'numeric', 'min:0'],
            'paid_at'      => ['nullable', 'date'],
            'reference'    => ['nullable', 'string', 'max:120'],
            'meta'         => ['nullable', 'array'],
        ]);

        $payment = DB::transaction(function () use ($payload, $order) {
            $amount = array_key_exists('amount', $payload)
                ? (float) $payload['amount']
                : (float) $order->total;

            $amountGiven = (float) ($payload['amount_given'] ?? 0);
            $changeDue   = max(0, round($amountGiven - $amount, 2));

            $p = new OrderPayment([
                'method'       => $payload['method'],
                'amount'       => round($amount, 2),
                'amount_given' => round($amountGiven, 2),
                'change_due'   => $changeDue,
                'status'       => OrderPayment::STATUS_CAPTURED,
                'reference'    => $payload['reference'] ?? null,
                'meta'         => $payload['meta'] ?? null,
                'paid_at'      => data_get($payload, 'paid_at') ? now()->parse($payload['paid_at']) : now(),
            ]);

            $order->payments()->save($p);

            // Auto mark paid if covered (handled in model boot), but ensure we return fresh data
            return $p->load('order');
        });

        return response()->json($payment->load('order'), 201);
    }

    /**
     * PATCH /orders/{order}/status
     * { status: "held|open|paid|voided|refunded" }
     */
    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in([
                Order::STATUS_HELD,
                Order::STATUS_OPEN,
                Order::STATUS_PAID,
                Order::STATUS_VOIDED,
                Order::STATUS_REFUNDED,
            ])],
        ]);

        $order->status = $data['status'];
        if ($order->status === Order::STATUS_PAID && !$order->closed_at) {
            $order->closed_at = now();
        }
        if (in_array($order->status, [Order::STATUS_VOIDED, Order::STATUS_REFUNDED], true)) {
            $order->closed_at = $order->closed_at ?: now();
        }
        $order->save();

        return $order->fresh()->load(['items.options', 'payments']);
    }

    /**
     * DELETE /orders/{order}
     * Soft delete
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json(['ok' => true]);
    }
}
