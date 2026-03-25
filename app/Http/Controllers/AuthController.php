<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProfessionalProfile;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|in:client,professional,store_owner',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile-images', 'public');
            $userData['profile_image'] = $path;
        }

        $user = User::create($userData);


        // Create profile based on user type
        if ($request->user_type === 'professional') {
            ProfessionalProfile::create([
                'user_id' => $user->id,
                'profession' => 'Not specified',
            ]);
        }

        if ($request->user_type === 'store_owner') {
            Store::create([
                'name' => $request->name . "'s Store",
                'owner_id' => $user->id,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => '',
                'state' => '',
                'zip_code' => '',
            ]);
        }

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registration successful!');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return redirect()->back()
            ->with('error', 'Invalid login credentials')
            ->withInput($request->only('email'));
    }
}