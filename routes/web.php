<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ✅ Home Page
Route::get('/', function () {
    return view('welcome');
});

// ✅ Authentication Routes (Login & Register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// ✅ Protected Routes (Require Authentication)
Route::middleware(['auth'])->group(function () {

    // ✅ Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // ✅ Dashboard (Requires Permission)
    Route::middleware(['permission:dashboard.view'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ✅ Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/', fn() => view('profile.profile'))->name('profile.show');
        Route::get('/edit', fn() => view('profile.profile-edit'))->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // ✅ User Management Routes
    Route::middleware(['permission:users.view'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
    });

    Route::middleware(['permission:users.create'])->group(function () {
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
    });

    Route::middleware(['permission:users.edit'])->group(function () {
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    });

    Route::middleware(['permission:users.delete'])->group(function () {
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // ✅ User Status Management
    Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::get('/users/active-users', [UserController::class, 'getActiveUsers'])->name('users.getActiveUsers');

    // ✅ Username & Email Availability Check API
    Route::get('/users/check-username', [UserController::class, 'checkUsername'])->name('users.checkUsername');
    Route::get('/users/check-email', [UserController::class, 'checkEmail'])->name('users.checkEmail');

    // ✅ Assign Permissions to Users
    Route::post('/assign-permission/{user}', [PermissionController::class, 'assignPermissionToUser']);

    // ✅ Role Management (With Permissions)
    Route::middleware(['permission:roles.view'])->prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });

    // ✅ POS System (Requires Cashier Role)
    Route::middleware(['role:cashier'])->get('/pos', [PosController::class, 'index'])->name('pos');

    // ✅ Admin Panel (With Permissions)
    Route::middleware(['permission:admin.access'])->group(function () {
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    });

    // ✅ Debugging Routes
    Route::get('/debug-auth', function () {
        return response()->json([
            'user' => Auth::user(),
            'authenticated' => Auth::check(),
            'session_driver' => config('session.driver'),
            'session_id' => session()->getId(),
        ]);
    });

    // ✅ Check Permissions (Test Route)
    Route::middleware(['permission:admin.access'])->get('/test-permission', fn() => "✅ You have permission access!");
});

// ✅ Include Authentication & Email Verification Routes
require __DIR__.'/auth.php';

// ✅ Debug Check for `DemoRoles`
Route::get('/check-demo-roles', [RoleController::class, 'checkDemoRolesPermissions']);

Route::post('/update-activity', [AuthenticatedSessionController::class, 'updateActivity'])
    ->middleware('auth')
    ->name('update.activity');
