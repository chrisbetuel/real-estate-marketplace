# TODO: Home Page Nearby Professionals Search Filter
Status: 🚀 In Progress (Step 1/7)

## Completed
- ✅ Plan approved & TODO created

## 1. Database Migration [Current Step]
```
php artisan make:migration add_location_to_professional_profiles_table --create=professional_profiles
```
**Fields:** `latitude decimal(10,8) nullable`, `longitude decimal(11,8) nullable`, `updated_at timestamp nullable`

## 2. Model Updates (ProfessionalProfile.php)
```
- Add fillable: 'latitude', 'longitude'
- Add casts: 'latitude' => 'decimal:8', 'longitude' => 'decimal:8'
- Add scopeNearby($lat, $lng, $radius = 50) { Haversine query }
```

## 3. Controller Logic (SearchController.php & ProfessionalController.php)
```
professionals() method:
if($request->filled(['lat','lng'])) {
  $query->whereHas('professionalProfile', fn($q)=>$q->nearby($lat,$lng));
  ->selectRaw('*, distance calc')
}
```

## 4. Home Page UI (home.blade.php)
```
Hero search:
- Keyword input (current)
+ Location autocomplete (Google Places)
+ Hidden: lat, lng, radius_km=50
JS: On place select → fill lat/lng
```

## 5. Results Views
```
professionals/_card.blade.php:
@if($distance) Distance: {{ number_format($distance,1) }}km @endif
```

## 6. Seeding Demo Data
```
ProfessionalDemoSeeder: Add lat/lng to samples
Dar: -6.792,39.208 | Nai: -1.292,36.822
```

## 7. Testing Commands
```
✅ migrate
✅ db:seed --class=ProfessionalDemoSeeder  
🧪 Test: /search/professionals?keyword=engineer&lat=-6.79&lng=39.20
```

**Next Action:** Create migration file → `execute artisan make:migration`

