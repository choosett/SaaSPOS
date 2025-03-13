<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SupplierController extends Controller
{
    // ✅ Show Suppliers List Page
    public function index()
    {
        $businessId = Auth::user()->business_id;
    
        // ✅ Fetch suppliers belonging to the business
        $suppliers = Supplier::where('business_id', $businessId)
                            ->orderBy('contact_id', 'asc')
                            ->get();
    
        // ✅ Fetch users for actions dropdown
        $users = User::where('business_id', $businessId)
                    ->select('id', 'username')
                    ->get();
    
        return view('suppliers.index', compact('users', 'suppliers'));
    }
    

    // ✅ Show Add Supplier Form
    public function create()
    {
        $businessId = Auth::user()->business_id;

        // Fetch users for dropdown
        $users = User::where('business_id', $businessId)
                    ->select('id', 'username')
                    ->get();

        return view('suppliers.create', compact('users'));
    }

    // ✅ Store Supplier (Handles Contact ID)
// ✅ Store Supplier (Redirect Instead of JSON)
public function store(Request $request)
{
    $businessId = Auth::user()->business_id;

    // ✅ Validate Input
    $validatedData = $request->validate([
        'contact_id'      => 'nullable|string|max:255|unique:suppliers,contact_id,NULL,id,business_id,' . $businessId,
        'supplier_name'   => 'required|string|max:255',
        'phone'           => 'required|string|max:20',
        'email'           => 'nullable|email|max:255',
        'assigned_to'     => "required|exists:users,id",
        'opening_balance' => 'nullable|numeric|min:0',
        'advance_balance' => 'nullable|numeric|min:0',
        'address'         => 'nullable|string|max:500',
    ]);

    // ✅ Generate Unique Contact ID if Empty
    $contactId = $validatedData['contact_id'] ?? $this->generateContactId($businessId);

    // ✅ Create Supplier
    $supplier = Supplier::create([
        'business_id'     => $businessId,
        'contact_id'      => $contactId,
        'supplier_name'   => $validatedData['supplier_name'],
        'phone'           => $validatedData['phone'],
        'email'           => $validatedData['email'] ?? null,
        'assigned_to'     => $validatedData['assigned_to'],
        'opening_balance' => $validatedData['opening_balance'] ?? 0.00,
        'advance_balance' => $validatedData['advance_balance'] ?? 0.00,
        'address'         => $validatedData['address'] ?? null,
    ]);

    // ✅ Check if request is an AJAX request
    if ($request->ajax()) {
        return response()->json([
            'success'  => true,  // ✅ Ensure JS checks this
            'message'  => 'Supplier added successfully!',
            'supplier' => $supplier
        ]);
    }

    // ✅ Redirect only for normal form submissions (NO message in JSON)
    return redirect()->route('suppliers.index')->with('success', 'Supplier added successfully!');
}


    // ✅ Generate Contact ID for Business (Ensures Unique Per Business)
    private function generateContactId($businessId)
    {
        // Get the last `contact_id` for the given `business_id`, ordered numerically
        $lastSupplier = Supplier::where('business_id', $businessId)
                            ->where('contact_id', 'LIKE', 'SUP%')
                            ->orderByRaw("CAST(SUBSTRING(contact_id, 4) AS UNSIGNED) DESC")
                            ->first();

        if ($lastSupplier) {
            // Extract the numeric part from the last `contact_id` (e.g., SUP005 → 5)
            preg_match('/SUP(\d+)/', $lastSupplier->contact_id, $matches);
            $lastNumber = isset($matches[1]) ? (int) $matches[1] : 0;
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        // ✅ Generate the new `contact_id` (e.g., SUP001, SUP002, ...)
        $newContactId = 'SUP' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // ✅ Check if `contact_id` already exists (rare edge case)
        while (Supplier::where('business_id', $businessId)->where('contact_id', $newContactId)->exists()) {
            $newNumber++;
            $newContactId = 'SUP' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        }

        return $newContactId;
    }


    
}
