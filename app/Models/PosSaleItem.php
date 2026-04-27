<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PosSaleItem extends Model
{
    protected $table = 'pos_sale_items';

    protected $fillable = [
        'pos_sale_id',
        'product_name',
        'product_sku',
        'unit_price',
        'quantity',
        'discount',
        'tax_rate',
        'tax_amount',
        'total_price',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(PosSale::class, 'pos_sale_id');
    }
}

