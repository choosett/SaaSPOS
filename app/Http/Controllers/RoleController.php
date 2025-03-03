<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

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
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $role = Role::create([
                'business_id' => $user->business_id,
                'name' => $request->name,
                'guard_name' => 'web',
            ]);

            if (!empty($request->permissions)) {
                $role->syncPermissions($request->permissions);
            }

            Log::info("Role '{$role->name}' created by user ID: {$user->id}");
            return response()->json(['success' => true, 'message' => 'Role created successfully.']);
        } catch (\Exception $e) {
            Log::error("Role creation failed: " . $e->getMessage());
            return response()->json(['error' => 'Failed to create role.'], 500);
        }
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(User $user)
    {
        $authUser = Auth::user();
    
        \Log::info("✅ Sending User to Blade:", ['User' => $user->toArray()]);
    
        return view('UserManagement.edituser', compact('user'));
    }
    
    

    /**
     * Update the specified role.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        $user = Auth::user();
        if (!$user || $role->business_id !== $user->business_id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $role->update(['name' => $request->name]);
            $role->syncPermissions($request->permissions ?? []);

            Log::info("Role '{$role->name}' updated by user ID: {$user->id}");
            return response()->json(['success' => true, 'message' => 'Role updated successfully.']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to update role.'], 500);
        }
    }

    /**
     * Remove the specified role.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $role = Role::where('business_id', $user->business_id)->findOrFail($id);

        if (strtolower($role->name) === 'admin') {
            return response()->json(['error' => 'Admin role cannot be deleted.'], 403);
        }

        if ($role->users()->count() > 0) {
            return response()->json(['error' => 'Cannot delete role with assigned users.'], 403);
        }

        try {
            $role->delete();
            Log::warning("Role '{$role->name}' deleted by user ID: {$user->id}");
            return response()->json(['success' => true, 'message' => 'Role deleted successfully.']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to delete role.'], 500);
        }
    }
}
