<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\ProfessionalProfile;

class ProfessionalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = \App\Models\User::with(['professionalProfile'])
            ->where('user_type', 'professional');

        if ($request->filled('keyword') || $request->filled('search')) {
            $searchTerm = trim($request->filled('keyword') ? $request->keyword : $request->search);
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('professionalProfile', function($q2) use ($searchTerm) {
                      $q2->where('profession', 'like', '%' . $searchTerm . '%')
                         ->orWhere('bio', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('professionalProfile', function($q) use ($request) {
                $q->where('profession', $request->category);
            });
        }

        // Geo filtering
        if ($request->filled(['lat', 'lng'])) {
            $lat = $request->lat;
            $lng = $request->lng;
            $radius = $request->radius ?? 50;
            
            $query->whereHas('professionalProfile', function ($q) use ($lat, $lng, $radius) {
                $q->nearby($lat, $lng, $radius);
            });
        }

        $professionals = $query->latest()->paginate(12);

        return view('professionals.index', compact('professionals'));
    }

    public function show(ProfessionalProfile $professional)
    {
        $professional->load('user');
        $user = $professional->user;
        $hasPaidUnlock = false;
        return view('professionals.show', [
            'professional' => $user,
            'hasPaidUnlock' => $hasPaidUnlock
        ]);
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);
        
        // Update user basic info
        $user->name = $validated['name'];
        $user->phone = $validated['phone'];
        $user->address = $validated['address'];
        
        // Update password if provided
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $user->password = Hash::make($request->new_password);
        }
        
        $user->save();
        
        // Update professional profile if user is a professional
        if ($user->user_type == 'professional') {
            $professionalData = $request->validate([
                'profession' => 'nullable|string',
                'years_experience' => 'nullable|integer|min:0',
                'hourly_rate' => 'nullable|numeric|min:0',
                'bio' => 'nullable|string',
            ]);
            
            $profile = ProfessionalProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'profession' => $professionalData['profession'],
                    'years_experience' => $professionalData['years_experience'],
                    'hourly_rate' => $professionalData['hourly_rate'],
                    'bio' => $professionalData['bio'],
                ]
            );
        }
        
        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $user = Auth::user();
        
        // Delete old image
        if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
            Storage::disk('public')->delete($user->profile_image);
        }
        
        $path = $request->file('profile_image')->store('profile_images', 'public');
        $user->profile_image = $path;
        $user->save();
        
        return redirect()->back()->with('success', 'Profile picture updated!');
    }
}