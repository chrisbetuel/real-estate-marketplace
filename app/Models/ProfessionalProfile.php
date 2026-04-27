<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profession',
        'years_experience',
        'hourly_rate',
        'bio',
        'skills',
        'stage',
        'subcategory',
        'certifications'
    ];

    protected $casts = [
        'years_experience' => 'integer',
        'hourly_rate' => 'decimal:2',
        'skills' => 'array',
        'certifications' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeNearby($query, $lat, $lng, $radius = 50)
    {
        return $query->selectRaw("
            *,
            ( 3959 * acos( cos( radians(" . $lat . ") ) * 
            cos( radians( latitude ) ) * 
            cos( radians( longitude ) - radians(" . $lng . ") ) + 
            sin( radians(" . $lat . ") ) * sin( radians( latitude ) ) ) 
            ) AS distance_km
        ")
        ->whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->having('distance_km', '<', $radius)
        ->orderBy('distance_km');
    }
}
