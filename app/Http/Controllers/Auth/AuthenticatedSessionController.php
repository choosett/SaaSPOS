<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\View\View;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        if ($user) {
            Log::info("✅ User Logged In - ID: {$user->id}, BEFORE Status: {$user->status}");

            // ✅ Update user status to active & last_activity timestamp
            $user->update([
                'status' => 'active',
                'last_activity' => now()
            ]);

            Log::info("✅ AFTER Login Status: {$user->status} for User ID: {$user->id}");
        } else {
            Log::error("❌ Login Attempt Failed: User not found in Auth session.");
        }

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            Log::info("🔴 User Logging Out - ID: {$user->id}, BEFORE Status: {$user->status}");

            // ✅ Update user status to inactive
            $user->update(['status' => 'inactive']);

            Log::info("🔴 AFTER Logout Status: {$user->status} for User ID: {$user->id}");
        } else {
            Log::error("❌ Logout Attempt Failed: No user found in Auth session.");
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * ✅ Update user activity on every request.
     * Call this function in Middleware or Ajax Ping Requests.
     */
    public function updateActivity(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->update([
                'status' => 'active',
                'last_activity' => now()
            ]);
        }

        return response()->json(['success' => true]);
    }
}
