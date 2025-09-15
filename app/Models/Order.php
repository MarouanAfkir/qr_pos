<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    // ---- Constants
    public const TYPE_DINEIN   = 'dinein';
    public const TYPE_TAKEAWAY = 'takeaway';
    public const TYPE_DELIVERY = 'delivery';

    public const STATUS_DRAFT    = 'draft';
    public const STATUS_HELD     = 'held';
    public const STATUS_OPEN     = 'open';
    public const STATUS_PAID     = 'paid';
    public const STATUS_VOIDED   = 'voided';
    public const STATUS_REFUNDED = 'refunded';

    public const DISC_AMOUNT  = 'amount';
    public const DISC_PERCENT = 'percent';

    // ---- Mass assign
    protected $guarded = [];

    // ---- Casts
    protected $casts = [
        'subtotal'         => 'decimal:2',
        'discount_value'   => 'decimal:2',
        'discount_amount'  => 'decimal:2',
        'total'            => 'decimal:2',
        'placed_at'        => 'datetime',
        'closed_at'        => 'datetime',
        'meta'             => 'array',
    ];

    // ---- Relationships
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(OrderPayment::class);
    }

    // ---- Scopes
    public function scopeOpenOrHeld($q)
    {
        return $q->whereIn('status', [self::STATUS_OPEN, self::STATUS_HELD]);
    }

    // ---- Helpers
    public static function booted(): void
    {
        static::creating(function (Order $order) {
            if (empty($order->order_code)) {
                // Example: ORD-20250827-173012-AB12
                $order->order_code = sprintf(
                    'ORD-%s-%s',
                    now()->format('Ymd-His'),
                    strtoupper(substr(bin2hex(random_bytes(2)), 0, 4))
                );
            }
        });

        // Keep totals consistent if items were touched before save
        static::saving(function (Order $order) {
            // Only auto-calc if not explicitly set by service layer
            if (is_null($order->subtotal) || is_null($order->total)) {
                $order->recalculateTotals();
            }
        });
    }

    public function recalculateTotals(): void
    {
        $subtotal = $this->items->sum('line_total');
        $this->subtotal = $subtotal;

        $discountAmount = 0.0;
        $raw = (float) ($this->discount_value ?? 0);

        if (($this->discount_type ?? self::DISC_AMOUNT) === self::DISC_PERCENT) {
            $discountAmount = max(0, min($subtotal, $subtotal * ($raw / 100)));
        } else {
            $discountAmount = max(0, min($subtotal, $raw));
        }

        $this->discount_amount = $discountAmount;
        $this->total = max(0, $subtotal - $discountAmount);
    }

    public function markPaid(?string $byUserId = null): void
    {
        $this->status = self::STATUS_PAID;
        $this->closed_at = now();
        if ($byUserId) {
            $this->closed_by = $byUserId;
        }
        $this->save();
    }
}
