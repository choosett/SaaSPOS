<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;

// ✅ Ensure the route is defined
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ✅ Home Page
Route::get('/', function () {
    return view('welcome');
});

// ✅ Authentication Routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

// ✅ Dashboard (Requires Authentication)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// ✅ Profile Routes (Requires Authentication)
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile.profile');
    })->name('profile.show'); // View profile
    
    Route::get('/profile/edit', function () {
        return view('profile.profile-edit');
    })->name('profile.edit'); // Edit profile
    
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Update profile
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Delete profile
});

// ✅ User Management (Admin Access)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');

    // 🔹 User Management Routes
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
});

// ✅ Manager Routes
Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/sales', [SalesController::class, 'index'])->name('sales');
});

// ✅ Cashier Routes
Route::middleware(['auth', 'role:cashier'])->group(function () {
    Route::get('/pos', function () {
        return view('pos');
    })->name('pos');
});

// ✅ Role Management Route (FIXED)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('roles', RoleController::class); // ✅ Generates all CRUD routes correctly
});


// ✅ Include Additional Authentication Routes
require __DIR__.'/auth.php';

Route::get('/roles', function () {
    return view('UserManagement.roles');
})->name('roles.index');

Route::get('/users', function () {
    return view('UserManagement.users');
})->name('users.index');
