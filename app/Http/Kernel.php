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
use App\Http\Middleware\StoreUserIdInSession; // ✅ Ensure user_id is stored in session
use Illuminate\Console\Scheduling\Schedule; // ✅ Fixed missing import

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
        StartSession::class, // ✅ Ensures Laravel session is started globally
        \Illuminate\Session\Middleware\AuthenticateSession::class, // ✅ Ensures session-based authentication
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
            StoreUserIdInSession::class, // ✅ Ensure user_id is stored in session
            \Illuminate\Session\Middleware\AuthenticateSession::class, // ✅ Ensure persistent authentication
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
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
}
