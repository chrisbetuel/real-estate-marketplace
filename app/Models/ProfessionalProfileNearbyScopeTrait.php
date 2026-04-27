<?php
// Temporary trait for nearby scope (copy from Location model)

trait NearbyScopeTrait 
{
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

