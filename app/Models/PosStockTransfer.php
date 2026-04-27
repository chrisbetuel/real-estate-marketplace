<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PosStockTransfer extends Model
{
    protected $fillable = [
        'from_shop_id',
        'to_shop_id',
        'product_id',
        'quantity',
        'status',
        'notes',
        'created_by',
        'completed_at',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'completed_at' => 'datetime',
    ];

    public function fromShop(): BelongsTo
    {
        return $this->belongsTo(PosShop::class, 'from_shop_id');
    }

    public function toShop(): BelongsTo
    {
        return $this->belongsTo(PosShop::class, 'to_shop_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}

