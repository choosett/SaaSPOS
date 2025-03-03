<?php

namespace App\Http\Controllers;

use App\Models\User;

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
            // ✅ Create Role
            $role = Role::create([
                'business_id' => $user->business_id,
                'name' => $request->name,
                'guard_name' => 'web',
            ]);
    
            // ✅ Assign Permissions if Provided
            if (!empty($request->permissions)) {
                $role->syncPermissions($request->permissions);
            }
    
            Log::info("✅ Role '{$role->name}' created by User ID: {$user->id}");
    
            // ✅ Return JSON Response (For AJAX Requests)
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Role created successfully.']);
            }
    
            // ✅ Redirect with Success Message (For Non-AJAX Requests)
            return redirect()->route('roles.index')->with('success', 'New Role Created Successfully.');
        } catch (\Exception $e) {
            Log::error("❌ Role creation failed: " . $e->getMessage());
    
            // ✅ Return JSON Error Response (For AJAX)
            if ($request->ajax()) {
                return response()->json(['error' => 'Failed to create role. Please try again.'], 500);
            }
    
            // ✅ Redirect with Error Message (For Non-AJAX)
            return redirect()->back()->with('error', 'Failed to create role. Please try again.');
        }
    }
    

    /**
     * Show the form for editing the specified role.
     */
    public function edit($id)
    {
        $authUser = Auth::user();
    
        // ✅ Fetch the correct role by ID
        $role = Role::where('id', $id)
                    ->where('business_id', $authUser->business_id)
                    ->first();
    
        if (!$role) {
            return redirect()->route('roles.index')->with('error', 'Role not found.');
        }
    
        // ✅ Fetch all available permissions
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
    
        \Log::info("✅ Sending Role Data to Blade", [
            'Role' => $role->toArray(),
            'Permissions' => $rolePermissions
        ]);
    
        // ✅ Pass data correctly to the view
        return view('UserManagement.roles-edit', compact('role', 'permissions', 'rolePermissions'));
    }
    
    

    /**
     * Update the specified role.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:roles,name,' . $id,
        'permissions' => 'nullable|array',
    ]);

    $authUser = Auth::user();

    // ✅ Fetch the role
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

        // ✅ Redirect to roles index page with success message
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
    
        // ✅ Find the role
        $role = Role::where('id', $id)
                    ->where('business_id', $authUser->business_id)
                    ->first();
    
        if (!$role) {
            return redirect()->route('roles.index')->with('error', 'Role not found.');
        }
    
        try {
            // ✅ Delete role
            $role->delete();
    
            Log::info("✅ Role '{$role->name}' deleted by User ID: {$authUser->id}");
    
            // ✅ Redirect back with success message
            return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            Log::error("❌ Role deletion failed: " . $e->getMessage());
    
            return redirect()->route('roles.index')->with('error', 'Failed to delete role. Please try again.');
        }
    }
    
}
