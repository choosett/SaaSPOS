<?php

use App\Models\User;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PosController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ✅ Home Page
Route::get('/', function () {
    return view('welcome');
});

// ✅ Username & Email Availability Check API
Route::get('/users/check-username', [UserController::class, 'checkUsername'])->name('users.checkUsername');
Route::get('/users/check-email', [UserController::class, 'checkEmail'])->name('users.checkEmail');

// ✅ Authentication Routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

// ✅ Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice'); 
    
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

// ✅ Dashboard (Requires Authentication & Permission)
Route::middleware(['auth', 'permission:dashboard.view'])->group(function () {
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

// ✅ POS System (Requires Cashier Role)
Route::middleware(['auth', 'role:cashier'])->group(function () {
    Route::get('/pos', [PosController::class, 'index'])->name('pos');
});

// ✅ User Management (With Permissions)
Route::middleware(['auth', 'permission:users.view'])->group(function () {
    Route::resource('/users', UserController::class);
});

// ✅ Role Management (With Permissions)
Route::middleware(['auth', 'permission:roles.view'])->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
});

// ✅ Admin Panel
Route::middleware(['auth', 'permission:admin.access'])->group(function () {
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

// ✅ Test Permission Middleware
Route::middleware(['auth', 'permission:admin.access'])->get('/test-permission', function () {
    return "✅ You have permission access!";
});

// ✅ Include Additional Authentication Routes
require __DIR__.'/auth.php';

// ✅ Debug Check for `DemoRoles`
Route::get('/check-demo-roles', [RoleController::class, 'checkDemoRolesPermissions']);


Route::middleware(['auth', 'permission:users.edit'])->group(function () {
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
});



Route::middleware(['auth', 'permission:users.create'])->group(function () {
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
});

Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy')
    ->middleware(['auth', 'permission:users.delete']);




