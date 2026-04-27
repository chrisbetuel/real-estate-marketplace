<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PosSale extends Model
{
    protected $table = 'pos_sales';

    protected $fillable = [
        'user_id',
        'pos_shop_id',
        'sale_number',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'payment_method',
        'amount_paid',
        'change_due',
        'customer_name',
        'customer_phone',
        'notes',
        'status',
        'sale_date',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'change_due' => 'decimal:2',
        'sale_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PosSaleItem::class, 'pos_sale_id');
    }

    public function posShop(): BelongsTo
    {
        return $this->belongsTo(PosShop::class, 'pos_shop_id');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($sale) {
            if (empty($sale->sale_number)) {
                $sale->sale_number = 'POS-' . strtoupper(uniqid());
            }
        });
    }
}

