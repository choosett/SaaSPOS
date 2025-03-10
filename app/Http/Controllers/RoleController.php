<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class RoleController extends Controller
{
    /**
     * Display a listing of roles with AJAX & pagination.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $query = Role::where('business_id', $user->business_id)->withCount('users');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $roles = $query->paginate($request->per_page ?? 10)->appends(['search' => $request->search]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('UserManagement.partials.roles-table', compact('roles'))->render()
            ]);
        }

        return view('UserManagement.allroles', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('UserManagement.create-role', compact('permissions'));
    }

    /**
     * Store a newly created role (Merged with `createRole` method).
     */
    public function store(Request $request)
    {
        Log::info("🔍 Role Creation Request Data:", $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'guard_name' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
        ]);

        $user = Auth::user();
        if (!$user) {
            Log::error("❌ Role Creation Failed: No authenticated user.");
            return redirect()->back()->with('error', 'Unauthorized. Please log in.');
        }

        try {
            // ✅ Create role only if it doesn't exist within the same business
            $role = Role::firstOrCreate([
                'name' => $request->name,
                'guard_name' => $request->guard_name ?? 'web',
                'business_id' => $user->business_id,
            ]);

            // ✅ Assign permissions if provided
            if (!empty($request->permissions)) {
                $role->syncPermissions($request->permissions);
            }

            Log::info("✅ Role Created Successfully:", $role->toArray());
            return redirect()->back()->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            Log::error("❌ Role Creation Failed: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create role. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit($id)
    {
        $authUser = Auth::user();
        $role = Role::where('id', $id)
                    ->where('business_id', $authUser->business_id)
                    ->first();

        if (!$role) {
            return redirect()->route('roles.index')->with('error', 'Role not found.');
        }

        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        Log::info("✅ Sending Role Data to Blade", [
            'Role' => $role->toArray(),
            'Permissions' => $rolePermissions
        ]);

        return view('UserManagement.roles-edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id . ',id,business_id,' . Auth::user()->business_id,
            'permissions' => 'nullable|array',
        ]);

        $authUser = Auth::user();
        $role = Role::where('id', $id)
                    ->where('business_id', $authUser->business_id)
                    ->first();

        if (!$role) {
            return redirect()->route('roles.index')->with('error', 'Role not found.');
        }

        try {
            // ✅ Update role name
            $role->update(['name' => $request->name]);

            // ✅ Update role permissions
            $role->syncPermissions($request->permissions ?? []);

            Log::info("✅ Role '{$role->name}' updated by User ID: {$authUser->id}");

            return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            Log::error("❌ Role update failed: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update role. Please try again.');
        }
    }

    /**
     * Remove the specified role.
     */
    public function destroy($id)
    {
        $authUser = Auth::user();
        $role = Role::where('id', $id)
                    ->where('business_id', $authUser->business_id)
                    ->first();

        if (!$role) {
            return redirect()->route('roles.index')->with('error', 'Role not found.');
        }

        try {
            $role->delete();
            Log::info("✅ Role '{$role->name}' deleted by User ID: {$authUser->id}");

            return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            Log::error("❌ Role deletion failed: " . $e->getMessage());
            return redirect()->route('roles.index')->with('error', 'Failed to delete role. Please try again.');
        }
    }
}
