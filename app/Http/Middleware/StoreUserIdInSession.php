<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreUserIdInSession
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            session(['user_id' => Auth::id()]);
            session()->save();

            // ✅ Ensure session is stored in database with `user_id`
            DB::table('sessions')
                ->where('id', session()->getId())
                ->update(['user_id' => Auth::id()]);
        }

        return $next($request);
    }
}
