<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Driver;
use App\Models\User;
use App\Models\Store;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('store_owner');
    }

    /**
     * Display store's drivers
     */
    public function index()
    {
        $store = Auth::user()->store;
        $drivers = $store->drivers()->with('user')->latest()->paginate(10);

        return view('store.drivers', compact('store', 'drivers'));
    }

    /**
     * Show create driver form
     */
    public function create()
    {
        $store = Auth::user()->store;
        return view('store.drivers-create', compact('store'));
    }

    /**
     * Register new driver (create User + Driver)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'vehicle_type' => 'required|in:bajaji,three_wheel,car,motorcycle',
            'price_per_km' => 'required|numeric|min:0',
        ]);

        $store = Auth::user()->store;

        DB::transaction(function () use ($request, $store) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'user_type' => 'driver',
                'password' => bcrypt(str($request->phone . '123')), // Temp password
            ]);

            Driver::create([
                'user_id' => $user->id,
                'store_id' => $store->id,
                'vehicle_type' => $request->vehicle_type,
                'price_per_km' => $request->price_per_km,
                'status' => 'offline',
            ]);
        });

        return redirect()->route('store-owner.drivers')
            ->with('success', 'Driver registered successfully! Temp password: phone + 123');
    }

    /**
     * Toggle driver availability
     */
    public function toggleAvailability(Driver $driver)
    {
        $this->authorizeStoreOwnership($driver->store);

        $driver->update([
            'is_available' => !$driver->is_available,
            'status' => $driver->is_available ? 'offline' : 'online',
        ]);

        return response()->json(['success' => true, 'available' => $driver->fresh()->is_available]);
    }

    /**
     * Update driver location (API for real-time)
     */
    public function updateLocation(Request $request, Driver $driver)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $this->authorizeDriverOwnership($driver);

        $driver->update([
            'current_lat' => $request->lat,
            'current_lng' => $request->lng,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Get nearby drivers
     */
    public function nearby(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'radius' => 'numeric|min:1|max:50',
        ]);

        $store = Auth::user()->store;
        $drivers = Driver::nearby($request->lat, $request->lng, $request->radius ?? 10)
            ->where('store_id', $store->id)
            ->with('user')
            ->get();

        return response()->json($drivers);
    }

    private function authorizeStoreOwnership($store)
    {
        if ($store->owner_id !== Auth::id()) {
            abort(403);
        }
    }

    private function authorizeDriverOwnership($driver)
    {
        if (!$driver->user->isDriver()) {
            abort(403);
        }
    }
}

