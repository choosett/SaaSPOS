<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ScopeRolesToBusiness
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            Role::addGlobalScope('business', function ($query) {
                $query->where('business_id', auth()->user()->business_id);
            });
        }

        return $next($request);
    }
}
