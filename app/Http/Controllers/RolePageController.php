<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class RolePageController extends Controller
{
    /**
     * Display a listing of roles for the authenticated user's business.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        // ✅ Get only roles for the logged-in user's business
        $query = Role::where('business_id', $user->business_id)->withCount('users');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $roles = $query->paginate($request->per_page ?? 10)->appends(['search' => $request->search]);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('UserManagement.partials.roles-table', compact('roles'))->render(),
            ]);
        }

        return view('UserManagement.allroles', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        return view('UserManagement.create-role');
    }

    /**
     * Store a newly created role, ensuring it belongs to the logged-in user's business.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        try {
            // ✅ Assign business_id while creating the role
            $role = Role::create([
                'business_id' => $user->business_id,
                'name' => $request->name,
                'guard_name' => 'web',
            ]);

            if (!empty($request->permissions)) {
                $role->syncPermissions($request->permissions);
            }

            return redirect()->route('allroles.index')->with('success', 'Role created successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Failed to create role. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        $user = Auth::user();
        if (!$user || $role->business_id !== $user->business_id) {
            return redirect()->route('allroles.index')->with('error', 'Unauthorized access.');
        }

        return view('UserManagement.roles-edit', compact('role'));
    }

    /**
     * Update the specified role, ensuring it belongs to the logged-in user's business.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        $user = Auth::user();
        if (!$user || $role->business_id !== $user->business_id) {
            return redirect()->route('allroles.index')->with('error', 'Unauthorized access.');
        }

        try {
            $role->update(['name' => $request->name]);
            $role->syncPermissions($request->permissions);

            return redirect()->route('allroles.index')->with('success', 'Role updated successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Failed to update role. Please try again.');
        }
    }

    /**
     * Remove the specified role, ensuring it belongs to the logged-in user's business.
     */
    public function destroy(Role $role)
    {
        $user = Auth::user();
        if (!$user || $role->business_id !== $user->business_id) {
            return redirect()->route('allroles.index')->with('error', 'Unauthorized access.');
        }

        // ❌ Completely prevent deletion of the "admin" role (case insensitive)
        if (strtolower($role->name) === 'admin') {
            return redirect()->back()->with('error', 'Admin role cannot be deleted.');
        }

        // ✅ Prevent deleting roles that still have assigned users
        if ($role->users()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete role with assigned users.');
        }

        try {
            $role->delete();
            return redirect()->route('allroles.index')->with('success', 'Role deleted successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Failed to delete role. Please try again.');
        }
    }
}
