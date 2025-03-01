<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RolePageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ✅ Home Page
Route::get('/', function () {
    return view('welcome');
});

// ✅ Username Availability Check API (For Live Search)
Route::get('/users/check-username', [UserController::class, 'checkUsername'])->name('users.checkUsername');
Route::get('/users/check-email', [UserController::class, 'checkEmail'])->name('users.checkEmail');


// ✅ Authentication Routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

// ✅ Dashboard (Requires Authentication)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ✅ Profile Routes (Requires Authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile.profile');
    })->name('profile.show');

    Route::get('/profile/edit', function () {
        return view('profile.profile-edit');
    })->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ User Management (Admin Only)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // ✅ Username Availability Check API (For Live Search)
    Route::get('/users/check-username', [UserController::class, 'checkUsername'])->name('users.checkUsername');
});

// ✅ Role Management (Admin Only)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/allroles', [RolePageController::class, 'index'])->name('allroles.index'); // List roles
    Route::get('/roles/create', [RolePageController::class, 'create'])->name('roles.create'); // Create role form
    Route::post('/roles', [RolePageController::class, 'store'])->name('roles.store'); // Store new role
    Route::get('/roles/{role}', [RolePageController::class, 'show'])->name('roles.show'); // Show role details
    Route::get('/roles/{role}/edit', [RolePageController::class, 'edit'])->name('roles.edit'); // Edit role form
    Route::put('/roles/{role}', [RolePageController::class, 'update'])->name('roles.update'); // Update role
    Route::delete('/roles/{role}', [RolePageController::class, 'destroy'])->name('roles.destroy'); // Delete role
});

// ✅ Admin Panel
Route::middleware(['auth', 'role:admin'])->group(function () {
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

// ✅ Test Role Middleware
Route::middleware(['auth', 'role:admin'])->get('/test-role', function () {
    return "✅ You have admin access!";
});

// ✅ Include Additional Authentication Routes
require __DIR__.'/auth.php';
