<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PosShop extends Model
{
    protected $fillable = [
        'owner_id',
        'name',
        'location',
        'phone',
        'email',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function staff(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'pos_shop_user')
            ->withPivot('role', 'is_active')
            ->withTimestamps();
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(PosInventory::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(PosSale::class);
    }

    public function transfersFrom(): HasMany
    {
        return $this->hasMany(PosStockTransfer::class, 'from_shop_id');
    }

    public function transfersTo(): HasMany
    {
        return $this->hasMany(PosStockTransfer::class, 'to_shop_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get total revenue for this shop
     */
    public function getTotalRevenueAttribute(): float
    {
        return $this->sales()
            ->where('status', 'completed')
            ->sum('total_amount') ?? 0;
    }

    /**
     * Get today's revenue for this shop
     */
    public function getTodayRevenueAttribute(): float
    {
        return $this->sales()
            ->where('status', 'completed')
            ->whereDate('sale_date', today())
            ->sum('total_amount') ?? 0;
    }

    /**
     * Get today's sales count
     */
    public function getTodaySalesCountAttribute(): int
    {
        return $this->sales()
            ->where('status', 'completed')
            ->whereDate('sale_date', today())
            ->count();
    }

    /**
     * Get low stock items count
     */
    public function getLowStockCountAttribute(): int
    {
        return $this->inventories()
            ->whereColumn('quantity', '<=', 'low_stock_threshold')
            ->where('quantity', '>', 0)
            ->count();
    }

    /**
     * Get out of stock items count
     */
    public function getOutOfStockCountAttribute(): int
    {
        return $this->inventories()
            ->where('quantity', '<=', 0)
            ->count();
    }
}

