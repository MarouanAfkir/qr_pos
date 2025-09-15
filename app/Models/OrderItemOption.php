<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItemOption extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'price_adjustment' => 'decimal:2',
        'sort_order'       => 'integer',
    ];

    public function item()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }

    // Keep parent line totals in sync when options change
    public static function booted(): void
    {
        $touchParent = function (OrderItemOption $opt) {
            $item = $opt->item()->with('options', 'order')->first();
            if ($item) {
                $item->recalculateAndSave();
            }
        };

        static::created($touchParent);
        static::updated($touchParent);
        static::deleted($touchParent);
    }
}
