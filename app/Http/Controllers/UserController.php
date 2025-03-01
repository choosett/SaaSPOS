<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of users with search & pagination.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        // ✅ Only get users for the authenticated user's business
        $query = User::where('business_id', $user->business_id);

        // ✅ Handle Search Query
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('username', 'LIKE', "%{$search}%")
                  ->orWhere('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // ✅ Handle Entries Per Page Selection
        $perPage = $request->input('per_page', 10);
        $users = $query->paginate($perPage)->appends([
            'search' => $request->search,
            'per_page' => $perPage
        ]);

        // ✅ Return AJAX Response If Requested
        if ($request->ajax()) {
            return response()->json([
                'html' => view('UserManagement.partials._users-table', compact('users'))->render()
            ]);
        }

        return view('UserManagement.users', compact('users'));
    }

    /**
     * Check if a username is available (AJAX Request).
     */
    public function checkUsername(Request $request)
    {
        $request->validate(['username' => 'required|string|min:3|max:255']);

        $username = $request->username;
        $exists = User::where('username', $username)->exists();

        return response()->json(['available' => !$exists]);
    }

    /**
     * Check if an email is available (AJAX Request).
     */
    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|max:255']);

        $email = $request->email;
        $exists = User::where('email', $email)->exists();

        return response()->json(['available' => !$exists]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        // ✅ Get roles only for the authenticated user's business
        $roles = Role::where('business_id', $user->business_id)->get();

        return view('UserManagement.adduser', compact('roles'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        // ✅ Create User
        $newUser = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'business_id' => $user->business_id,
        ]);

        // ✅ Assign Role
        $newUser->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('UserManagement.showuser', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $authUser = Auth::user();
        if (!$authUser || $user->business_id !== $authUser->business_id) {
            return redirect()->route('users.index')->with('error', 'Unauthorized access.');
        }

        $roles = Role::where('business_id', $authUser->business_id)->get();

        return view('UserManagement.edituser', compact('user', 'roles'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $authUser = Auth::user();
        if (!$authUser || $user->business_id !== $authUser->business_id) {
            return redirect()->route('users.index')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
        ]);

        // ✅ Update Password (If Provided)
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // ✅ Update Role
        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        $authUser = Auth::user();
        if (!$authUser || $user->business_id !== $authUser->business_id) {
            return redirect()->route('users.index')->with('error', 'Unauthorized access.');
        }

        // ✅ Prevent Self-Deletion
        if ($user->id === $authUser->id) {
            return redirect()->route('users.index')->with('error', 'You cannot delete your own account.');
        }

        // ✅ Prevent Admin Deletion
        if ($user->hasRole('admin')) {
            return redirect()->route('users.index')->with('error', 'You cannot delete an admin account.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
