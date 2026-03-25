<?php
// config/places-autocomplete.php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Maps API Key
    |--------------------------------------------------------------------------
    */
    'api_key' => env('GOOGLE_MAPS_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Default Options
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'placeholder' => 'Enter a location...',
        'debounce' => 300,
        'language' => 'en-US',
        'components' => 'country:us',
        'types' => ['address', 'establishment'],
    ],
];