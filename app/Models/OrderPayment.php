<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderPayment extends Model
{
    use HasFactory;

    public const METHOD_CASH  = 'cash';
    public const METHOD_CARD  = 'card';
    public const METHOD_OTHER = 'other';

    public const STATUS_CAPTURED = 'captured';
    public const STATUS_VOIDED   = 'voided';
    public const STATUS_REFUNDED = 'refunded';
    public const STATUS_FAILED   = 'failed';

    protected $guarded = [];

    protected $casts = [
        'amount'       => 'decimal:2',
        'amount_given' => 'decimal:2',
        'change_due'   => 'decimal:2',
        'paid_at'      => 'datetime',
        'meta'         => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Optional: after a successful capture, auto-close order if fully paid
    public static function booted(): void
    {
        static::created(function (OrderPayment $payment) {
            $order = $payment->order()->with('payments', 'items')->first();
            if (!$order) return;

            $paid = (float) $order->payments()->where('status', self::STATUS_CAPTURED)->sum('amount');
            if ($paid >= (float) $order->total && $order->status !== Order::STATUS_PAID) {
                $order->markPaid();
            }
        });
    }
}
