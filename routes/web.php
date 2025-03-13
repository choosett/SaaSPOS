<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Contacts\SupplierController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Api\CourierCheckController; // ✅ Correct Namespace!
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Contacts\CustomerController;

Route::prefix('customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::post('/store', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/edit/{customer}', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/update/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/delete/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
});




// 🚀 Show input form for courier check
Route::get('/courier-check', function () {
    return view('courier-check-form'); 
});

// 🚀 Process input and fetch results from API
Route::post('/courier-check', [CourierCheckController::class, 'showCourierCheck']);


// ✅ Home Page
Route::get('/', fn() => view('welcome'));

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

    // ✅ Dashboard
    Route::middleware(['permission:dashboard.view'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ✅ Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/', fn() => view('profile.profile'))->name('profile.show');
        Route::get('/edit', fn() => view('profile.profile-edit'))->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // ✅ User Management
    Route::prefix('users')->name('users.')->middleware(['permission:users.view'])->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->middleware('permission:users.create')->name('create');
        Route::post('/', [UserController::class, 'store'])->middleware('permission:users.create')->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->middleware('permission:users.edit')->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->middleware('permission:users.edit')->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->middleware('permission:users.delete')->name('destroy');
        Route::post('/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggleStatus');
        Route::get('/active-users', [UserController::class, 'getActiveUsers'])->name('getActiveUsers');
        Route::get('/check-username', [UserController::class, 'checkUsername'])->name('checkUsername');
        Route::get('/check-email', [UserController::class, 'checkEmail'])->name('checkEmail');
    });

    // ✅ Assign Permissions to Users
    Route::post('/assign-permission/{user}', [PermissionController::class, 'assignPermissionToUser']);

    // ✅ Role Management
    Route::prefix('roles')->name('roles.')->middleware(['permission:roles.view'])->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
    });

    // ✅ POS System (Requires Cashier Role)
    Route::middleware(['role:cashier'])->get('/pos', [PosController::class, 'index'])->name('pos');

    // ✅ Admin Panel
    Route::middleware(['permission:admin.access'])->group(function () {
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    });

    // ✅ Suppliers Management
    Route::prefix('suppliers')->name('suppliers.')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('index');
        Route::get('/create', [SupplierController::class, 'create'])->name('create');
        Route::post('/store', [SupplierController::class, 'store'])->name('store');

        Route::get('/{id}', [SupplierController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [SupplierController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SupplierController::class, 'update'])->name('update');
        Route::delete('/{id}', [SupplierController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/toggle-status', [SupplierController::class, 'toggleStatus'])->name('toggleStatus');
        Route::get('/suppliers/filter-by-user', [SupplierController::class, 'filterByUser'])->name('suppliers.filter');
        Route::get('/suppliers/{id}', [SupplierController::class, 'show'])->name('suppliers.show');




    


    });

    // ✅ Update Activity
    Route::post('/update-activity', [AuthenticatedSessionController::class, 'updateActivity'])->name('update.activity');

});

// ✅ API: Get Users by Business ID
Route::get('/api/get-users', function (Request $request) {
    $businessId = $request->query('business_id');
    $users = User::where('business_id', $businessId)->select('id', 'username')->get();
    return response()->json(['users' => $users]);
});

require __DIR__.'/auth.php';
