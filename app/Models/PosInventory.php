<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PosInventory extends Model
{
    protected $fillable = [
        'pos_shop_id',
        'product_id',
        'quantity',
        'low_stock_threshold',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'low_stock_threshold' => 'integer',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(PosShop::class, 'pos_shop_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getIsLowStockAttribute(): bool
    {
        return $this->quantity > 0 && $this->quantity <= $this->low_stock_threshold;
    }

    public function getIsOutOfStockAttribute(): bool
    {
        return $this->quantity <= 0;
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->quantity <= 0) return 'out_of_stock';
        if ($this->quantity <= $this->low_stock_threshold) return 'low_stock';
        return 'in_stock';
    }
}

