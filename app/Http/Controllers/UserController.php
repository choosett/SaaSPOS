<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of users with search & pagination.
     */
    public function index(Request $request)
    {
        $authUser = Auth::user();
        if (!$authUser) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }
    
        $query = User::where('business_id', $authUser->business_id);
    
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('username', 'LIKE', "%{$search}%")
                  ->orWhere('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
    
        $perPage = $request->input('per_page', 5); // ✅ Default to 5
        $users = $query->paginate($perPage)->appends([
            'search' => $request->search,
            'per_page' => $perPage
        ]);
    
        if ($request->ajax()) {
            return response()->json([
                'html' => view('UserManagement.partials._users-table', compact('users'))->render(),
            ]);
        }
    
        return view('UserManagement.users', compact('users'))
                ->with('success', session('success'))
                ->with('error', session('error'));
    }
    
    

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $authUser = Auth::user();

        // ✅ Fetch roles for the dropdown
        $roles = Role::where('business_id', $authUser->business_id)->get();

        \Log::info("✅ Sending User & Roles to Blade:", [
            'User' => $user->toArray(),
            'Roles' => $roles->pluck('name')->toArray()
        ]);

        return view('UserManagement.edituser', [
            'editingUser' => $user,
            'authUser' => $authUser,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, $id)
{
    \Log::info("🔄 Update Request Received for User ID: {$id}");

    $authUser = Auth::user();

    // ✅ Fetch the correct user
    $user = User::where('id', $id)
                ->where('business_id', $authUser->business_id)
                ->first();

    if (!$user) {
        return redirect()->route('users.index')->with('error', 'Unauthorized access.');
    }

    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'password' => 'nullable|min:6|confirmed',
        'role' => 'required|string',
    ]);

    $role = Role::where('name', $request->role)
                ->where('business_id', $authUser->business_id)
                ->first();

    if (!$role) {
        return redirect()->back()->with('error', 'Invalid role selection.');
    }

    $user->update($request->except('password', 'role'));

    if ($request->filled('password')) {
        $user->update(['password' => Hash::make($request->password)]);
    }

    $user->syncRoles([$role->name]);

    \Log::info("✅ User {$user->id} updated successfully.");

    // ✅ Redirect to "All Users" page with success message
    return redirect()->route('users.index')->with('success', 'User updated successfully.');
}


    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $authUser = Auth::user();
        if (!$authUser) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|string',
        ]);

        $role = Role::where('name', $request->role)
                    ->where('business_id', $authUser->business_id)
                    ->first();

        if (!$role) {
            return redirect()->back()->with('error', 'Invalid role selection.');
        }

        $newUser = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'business_id' => $authUser->business_id,
        ]);

        $newUser->assignRole($role);
        Log::info("User {$newUser->id} assigned role: {$role->name} by {$authUser->id}");

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Remove the specified user.
     */
   /**
 * Remove the specified user.
 */
public function destroy($id)
{
    $authUser = Auth::user();

    // ✅ Fetch the user to delete
    $user = User::where('id', $id)
                ->where('business_id', $authUser->business_id)
                ->first();

    if (!$user) {
        return response()->json(['error' => 'User not found or unauthorized access.'], 404);
    }

    // ❌ Prevent self-delete
    if ($user->id === $authUser->id) {
        return response()->json(['error' => 'You cannot delete your own account.'], 403);
    }

    // ❌ Prevent admin delete
    if ($user->hasRole('admin')) {
        return response()->json(['error' => 'You cannot delete an admin user.'], 403);
    }

    \Log::warning("⚠️ User {$user->id} deleted by {$authUser->id}");

    $user->delete();

    // ✅ Return JSON success message
    return response()->json(['success' => 'User deleted successfully.']);
}


    /**
     * Check if a username is available (AJAX Request).
     */
    public function checkUsername(Request $request)
    {
        $request->validate(['username' => 'required|string|min:3|max:255']);
        $exists = User::where('username', $request->username)->exists();
        return response()->json(['available' => !$exists]);
    }

    /**
     * Check if an email is available (AJAX Request).
     */
    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|max:255']);
        $exists = User::where('email', $request->email)->exists();
        return response()->json(['available' => !$exists]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $authUser = Auth::user();

        // Fetch roles for the authenticated user's business
        $roles = Role::where('business_id', $authUser->business_id)->get();

        return view('UserManagement.adduser', compact('roles'));
    }


    
    public function toggleStatus($id, Request $request)
    {
        $user = User::findOrFail($id);
    
        // Ensure request contains 'status'
        if (!$request->has('status')) {
            return response()->json(['success' => false, 'message' => 'Status missing'], 400);
        }
    
        $user->status = $request->status;
        $user->save();
    
        return response()->json(['success' => true, 'status' => $user->status]);
    }
    
    
    
}
