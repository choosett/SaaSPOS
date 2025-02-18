<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ✅ Home Page
Route::get('/', function () {
    return view('welcome');
});

// ✅ Dashboard (Requires Authentication)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ✅ Profile Routes (Requires Authentication)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Role-Based Routes (Admin, Manager, Cashier)
Route::middleware(['auth'])->group(function () {

    // Admin Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    });

    // Manager Routes
    Route::middleware(['role:manager'])->group(function () {
        Route::get('/sales', [SalesController::class, 'index'])->name('sales');
    });

    // Cashier Routes
    Route::middleware(['role:cashier'])->group(function () {
        Route::get('/pos', function () {
            return view('pos');
        })->name('pos');
    });

    // ✅ Logout (POST Request)
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});

// ✅ Authentication Routes
require __DIR__.'/auth.php';
