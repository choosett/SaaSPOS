<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Router;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // ✅ Pass authenticated user data to all views
        View::composer('*', function ($view) {
            $view->with('user', Auth::check() ? Auth::user() : null);
        });

        // ✅ Register Spatie Middleware Manually
        $this->app->booted(function () {
            $router = app(Router::class);
            $router->aliasMiddleware('role', RoleMiddleware::class);
            $router->aliasMiddleware('permission', PermissionMiddleware::class);
            $router->aliasMiddleware('role_or_permission', RoleOrPermissionMiddleware::class);
        });
    }
}
