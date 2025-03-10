<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UpdateUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->update([
                'last_activity' => now(),
                'status' => 'active' // Ensure status is updated when active
            ]);
        }

        return $next($request);
    }
}
