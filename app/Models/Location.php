<?php
// app/Models/Location.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type', 'category', 'address', 'city', 'state', 
        'zip_code', 'latitude', 'longitude', 'phone', 'email', 
        'website', 'description', 'place_id', 'is_verified', 
        'business_hours', 'rating', 'review_count', 'user_id'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_verified' => 'boolean',
        'business_hours' => 'array',
        'rating' => 'decimal:2',
    ];

    // Calculate distance from given coordinates
    public function scopeDistance($query, $lat, $lng, $radius = 10)
    {
        return $query->selectRaw(
            "*, ( 3959 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance",
            [$lat, $lng, $lat]
        )->having('distance', '<', $radius)
         ->orderBy('distance');
    }

    // Scope for filtering by type
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Get formatted business hours
    public function getFormattedHoursAttribute()
    {
        if (!$this->business_hours) {
            return null;
        }
        
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $formatted = [];
        
        foreach ($days as $day) {
            if (isset($this->business_hours[$day])) {
                $hours = $this->business_hours[$day];
                $formatted[] = $day . ': ' . ($hours['open'] ?? 'Closed') . ' - ' . ($hours['close'] ?? 'Closed');
            }
        }
        
        return $formatted;
    }
}