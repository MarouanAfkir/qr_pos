<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'base_unit_price' => 'decimal:2',
        'unit_price'      => 'decimal:2',
        'line_total'      => 'decimal:2',
        'data'            => 'array',
    ];

    protected $with = ['options']; // eager load selected options

    // ---- Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function options()
    {
        return $this->hasMany(OrderItemOption::class);
    }

    // ---- Helpers
    public static function booted(): void
    {
        static::saving(function (OrderItem $item) {
            // If unit_price not provided, compute from base + options
            if (is_null($item->unit_price)) {
                $item->recalculatePrices();
            }

            // Always keep line_total consistent with quantity
            $qty = max(1, (int) ($item->quantity ?? 1));
            $item->line_total = (float) $item->unit_price * $qty;
        });

        // When options change, keep prices in sync
        static::saved(function (OrderItem $item) {
            if ($item->wasChanged('quantity') || $item->wasChanged('base_unit_price')) {
                $item->refresh()->recalculateAndSave();
            }
        });
    }

    public function recalculatePrices(): void
    {
        $base = (float) ($this->base_unit_price ?? 0);
        $optionsAdj = (float) ($this->options?->sum('price_adjustment') ?? 0);
        $this->unit_price = $base + $optionsAdj;
        $this->line_total = $this->unit_price * max(1, (int) $this->quantity);
    }

    public function recalculateAndSave(): void
    {
        $this->recalculatePrices();
        $this->saveQuietly(); // avoid recursion
        // After item changes, make sure order totals are fresh
        $this->order?->loadMissing('items')->recalculateTotals();
        $this->order?->saveQuietly();
    }
}
