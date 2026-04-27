<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreOwnerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->isStoreOwner()) {
                return $next($request);
            }
            
            if (Auth::user()->user_type === 'client') {
                return redirect()->route('client.dashboard')
                    ->with('error', 'Access denied. This area is for store owners only.');
            } elseif (Auth::user()->user_type === 'professional') {
                return redirect()->route('professional.dashboard')
                    ->with('error', 'Access denied. This area is for store owners only.');
            } elseif (Auth::user()->user_type === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Access denied. This area is for store owners only.');
            }
        }
        
        return redirect()->route('login')->with('error', 'Please login first.');
    }
}