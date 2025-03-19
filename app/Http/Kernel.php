<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Http\Middleware\TrustHosts;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Http\Middleware\ValidateSignature;
use Illuminate\Http\Middleware\HandleCors;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Foundation\Http\Middleware\TrimStrings;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;

// ✅ Spatie Permission Middleware
use Spatie\Permission\Middlewares\RoleMiddleware;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleOrPermissionMiddleware;

// ✅ Custom Middleware
use App\Http\Middleware\ScopeRolesToBusiness;
use App\Http\Middleware\UpdateUserActivity;

class Kernel extends HttpKernel
{
    /**
     * Global middleware applied to all requests.
     */
    protected $middleware = [
        TrustProxies::class,
        TrustHosts::class,
        HandleCors::class,
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        StartSession::class,
        ShareErrorsFromSession::class,
        ValidateCsrfToken::class,
        HandlePrecognitiveRequests::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,

        // ✅ Restrict roles to business_id
        ScopeRolesToBusiness::class,
    ];

    /**
     * Middleware groups for Web and API routes.
     */
    protected $middlewareGroups = [
        'web' => [
            StartSession::class,
            ShareErrorsFromSession::class,
            ValidateCsrfToken::class,
            HandlePrecognitiveRequests::class,
            SubstituteBindings::class,
            UpdateUserActivity::class, // ✅ Auto-update user activity
        ],

        'api' => [
            EnsureFrontendRequestsAreStateful::class,
            SubstituteBindings::class,
        ],
    ];

    /**
     * Middleware aliases.
     */
    protected $middlewareAliases = [
        'auth' => Authenticate::class,
        'auth.basic' => Authenticate::class . ':basic',
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'can' => Authorize::class,
        'verified' => EnsureEmailIsVerified::class,
        'cache.headers' => SetCacheHeaders::class,
        'signed' => ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'bindings' => SubstituteBindings::class,

        // ✅ Spatie Permissions Middleware
        'role' => RoleMiddleware::class,
        'permission' => PermissionMiddleware::class,
        'role_or_permission' => RoleOrPermissionMiddleware::class,

        // ✅ Custom Middleware for Business Role Scoping
        'scopeRoles' => ScopeRolesToBusiness::class,
    ];

    protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        $businesses = PathaoApiCredential::all();
        foreach ($businesses as $business) {
            app(PathaoController::class)->refreshAccessToken($business->business_id);
        }
    })->daily(); // ✅ Runs daily to refresh tokens automatically for pathao
}

}
