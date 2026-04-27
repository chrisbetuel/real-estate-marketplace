<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'logo',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'latitude',
        'longitude',
        'website',
        'owner_id',
        'is_active',
        'is_verified',
        'business_hours',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'business_hours' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'images' => 'array',
    ];

    /**
     * Get the owner of the store
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the products for the store
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the reviews for the store through its products
     */
    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Product::class);
    }

    /**
     * Scope for active stores
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for verified stores
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function escrowHolds()
    {
        return $this->hasMany(EscrowHold::class);
    }

    /**
     * Drivers registered with this store
     */
    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }
}

