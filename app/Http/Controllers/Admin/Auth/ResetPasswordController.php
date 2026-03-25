<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Admin;

class ResetPasswordController extends Controller
{
    public function showResetForm($token = null, Request $request)
    {
        return view('admin.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $reset = DB::table('admin_password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$reset || !Hash::check($request->token, $reset->token)) {
            return back()->withErrors(['email' => 'Invalid token or email.']);
        }

        // Check if token expired (60 minutes)
        if (now()->diffInMinutes($reset->created_at) > 60) {
            return back()->withErrors(['email' => 'Password reset link expired.']);
        }

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        // Delete the reset record
        DB::table('admin_password_resets')->where('email', $request->email)->delete();

        return redirect()->route('admin.login')
            ->with('status', 'Password has been reset successfully!');
    }
}