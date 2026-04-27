<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_id',
        'vehicle_type',
        'is_available',
        'current_lat',
        'current_lng',
        'price_per_km',
        'status',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'current_lat' => 'decimal:8',
        'current_lng' => 'decimal:8',
        'price_per_km' => 'decimal:2',
    ];

    /**
     * Get the driver User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the store
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Orders assigned to this driver
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Scope for available drivers
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)
                     ->where('status', 'online');
    }

    /**
     * Scope for nearby drivers (within $radius km)
     */
    public function scopeNearby($query, $lat, $lng, $radius = 10)
    {
        $radius = max(1, (float) $radius); // Min 1km

        return $query->selectRaw("
                *,
                ( 6371 * acos( cos( radians(?) ) *
                               cos( radians( current_lat ) )
                               * cos( radians( current_lng ) - radians(?) )
                               + sin( radians(?) ) *
                               sin( radians( current_lat ) ) )
                ) AS distance",
                [$lat, $lng, $lat]
            )
            ->available()
            ->having('distance', '<=', $radius)
            ->orderBy('distance');
    }

    /**
     * Get vehicle type label
     */
    public function getVehicleLabelAttribute()
    {
        return match($this->vehicle_type) {
            'bajaji' => 'Bajaji',
            'three_wheel' => 'Three Wheel',
            'car' => 'Car',
            'motorcycle' => 'Motorcycle',
            default => ucfirst($this->vehicle_type),
        };
    }

    /**
     * Check if driver is online and available
     */
    public function getIsOnlineAttribute()
    {
        return $this->is_available && $this->status === 'online';
    }
}

