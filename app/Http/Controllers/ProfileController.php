<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\ProfessionalProfile;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
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
        
        // Update user basic info - email is NOT updated
        $user->name = $validated['name'];
        $user->phone = $validated['phone'] ?? $user->phone;
        $user->address = $validated['address'] ?? $user->address;
        
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