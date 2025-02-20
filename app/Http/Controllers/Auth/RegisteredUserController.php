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
    /**
     * Show the registration form.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        // Validate input fields
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'currency' => 'required|string|max:10',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'website' => 'nullable|url|max:255',
            'business_contact' => 'required|string|max:20',
            'alternate_contact' => 'nullable|string|max:20',
            'district' => 'required|string|max:50',
            'business_address' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'bin_number' => 'nullable|string|max:50',
            'dbid_number' => 'nullable|string|max:50',
            'financial_year' => 'required|string|max:20',
            'stock_method' => 'required|in:FIFO,LIFO',
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            // Generate a unique 8-digit Business ID
            do {
                $business_id = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
            } while (Business::where('business_id', $business_id)->exists());

            // Handle logo upload if provided
            $logoPath = $request->hasFile('logo') ? $request->file('logo')->store('logos', 'public') : null;

            // Create new Business
            $business = Business::create([
                'business_id' => $business_id,
                'business_name' => $validated['business_name'],
                'start_date' => $validated['start_date'],
                'currency' => $validated['currency'],
                'logo' => $logoPath,
                'website' => $validated['website'],
                'business_contact' => $validated['business_contact'],
                'alternate_contact' => $validated['alternate_contact'],
                'district' => $validated['district'],
                'business_address' => $validated['business_address'],
                'zip_code' => $validated['zip_code'],
                'bin_number' => $validated['bin_number'],
                'dbid_number' => $validated['dbid_number'],
                'financial_year' => $validated['financial_year'],
                'stock_method' => $validated['stock_method'],
            ]);

            // Create new User (Owner)
            $user = User::create([
                'business_id' => $business->business_id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Assign role to user (Ensure Spatie Roles are used)
            $user->assignRole('admin');

            // Log the user in
            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Business registered successfully!');

        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Registration failed. Please try again.');
        }
    }
}
