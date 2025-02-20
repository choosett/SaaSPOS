<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Business;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'business_name' => 'required|string|max:255',
            'business_contact' => 'required|string|unique:businesses',
            'district' => 'required|string',
            'business_address' => 'required|string',
            'zip_code' => 'required|string',
            'financial_year_start_month' => 'required|string',
            'stock_method' => 'required|string',
            'first_name' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create Business with Auto-generated Business ID
        $business = Business::create([
            'business_name' => $validatedData['business_name'],
            'business_contact' => $validatedData['business_contact'],
            'district' => $validatedData['district'],
            'business_address' => $validatedData['business_address'],
            'zip_code' => $validatedData['zip_code'],
            'financial_year_start_month' => $validatedData['financial_year_start_month'],
            'stock_method' => $validatedData['stock_method'],
        ]);

        // Create User (Owner)
        $user = User::create([
            'business_id' => $business->id,
            'first_name' => $validatedData['first_name'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('login')->with('success', 'Business registered successfully! Your Business ID: ' . $business->business_id);
    }
}
