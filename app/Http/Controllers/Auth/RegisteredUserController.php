<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Database\QueryException;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'currency' => 'required|string|max:10',
            'business_contact' => 'required|string|max:20',
            'district' => 'required|string|max:50',
            'business_address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'financial_year' => 'required|string|max:20',
            'stock_method' => 'required|in:FIFO,LIFO',
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            \DB::beginTransaction(); // ✅ Start Transaction

            // ✅ Generate a unique 8-character Business ID
            do {
                $business_id = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
            } while (Business::where('business_id', $business_id)->exists());

            // ✅ Create new Business
            $business = Business::create([
                'business_id' => $business_id,
                'business_name' => $validated['business_name'],
                'start_date' => $validated['start_date'],
                'currency' => $validated['currency'],
                'business_contact' => $validated['business_contact'],
                'district' => $validated['district'],
                'business_address' => $validated['business_address'],
                'zip_code' => $validated['zip_code'],
                'financial_year' => $validated['financial_year'],
                'stock_method' => $validated['stock_method'],
            ]);

            if (!$business || !$business->exists) {
                throw new \Exception('Business creation failed!');
            }

            // ✅ Create new User
            $user = User::create([
                'business_id' => $business->business_id, // Assign correct business_id
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            if (!$user || !$user->exists) {
                throw new \Exception('User creation failed!');
            }

            // ✅ Assign business-specific roles
            $adminRole = Role::firstOrCreate([
                'name' => 'admin',
                'guard_name' => 'web',
                'business_id' => $business->business_id, // Assign to correct business
            ]);

            $user->assignRole($adminRole);

            \DB::commit(); // ✅ Commit Transaction

            Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'Business registered successfully!');
        } catch (QueryException $e) {
            \DB::rollBack(); // ✅ Rollback Transaction on Failure
            \Log::error('Registration failed:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Registration failed. Please try again.');
        }
    }
}
