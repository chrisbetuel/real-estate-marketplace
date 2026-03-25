<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Property;
use Illuminate\Support\Facades\Http;

class HomeSearchController extends Controller
{
    public function index()
    {
        return view('home');
    }

    /**
     * Search for nearby locations
     */
    public function search(Request $request)
    {
        $request->validate([
            'location' => 'required|string',
            'type' => 'nullable|string|in:all,store,professional,agency',
            'radius' => 'nullable|integer|min:1|max:50',
            'lat' => 'required_with:lng|numeric',
            'lng' => 'required_with:lat|numeric',
        ]);

        $lat = $request->lat;
        $lng = $request->lng;
        $type = $request->type ?? 'all';
        $radius = $request->radius ?? 10; // miles

        // Query local database
        $query = Location::distance($lat, $lng, $radius);

        if ($type !== 'all') {
            $query->where('type', $type);
        }

        $localResults = $query->with('user')->get();

        // Optional: Add Google Places API if you want to include external results
        $googleResults = [];
        if ($request->filled('include_google') && config('services.google.maps_api_key')) {
            try {
                $response = Http::get('https://maps.googleapis.com/maps/api/place/nearbysearch/json', [
                    'location' => "{$lat},{$lng}",
                    'radius' => $radius * 1609.34, // Convert miles to meters
                    'type' => $this->mapTypeToGoogle($type),
                    'key' => config('services.google.maps_api_key')
                ]);
                
                if ($response->successful()) {
                    $googleResults = $response->json();
                }
            } catch (\Exception $e) {
                // Log error but don't break the search
                \Log::error('Google Places API error: ' . $e->getMessage());
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'local' => $localResults,
                'google' => $googleResults,
                'html' => view('partials.search-results', compact('localResults', 'googleResults'))->render()
            ]);
        }

        return view('search.results', compact('localResults', 'googleResults', 'lat', 'lng'));
    }

    /**
     * Get place details from Google
     */
    public function getPlaceDetails(Request $request)
    {
        $request->validate([
            'place_id' => 'required|string'
        ]);

        try {
            $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
                'place_id' => $request->place_id,
                'key' => config('services.google.maps_api_key')
            ]);
            
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch place details'], 500);
        }
    }

    /**
     * Map our types to Google Place types
     */
    private function mapTypeToGoogle($type)
    {
        $map = [
            'store' => 'store',
            'professional' => 'real_estate_agency',
            'agency' => 'real_estate_agency',
            'all' => 'establishment'
        ];

        return $map[$type] ?? 'establishment';
    }
}