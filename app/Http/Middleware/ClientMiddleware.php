<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        if (Auth::user()->user_type != 'client' && Auth::user()->user_type != 'user') {
            abort(403, 'Unauthorized access. Client access required.');
        }
        
        return $next($request);
    }
}