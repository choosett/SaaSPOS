<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role; // ✅ Using Spatie's Role model
use Illuminate\Database\QueryException;

class RoleController extends Controller
{
    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        return view('UserManagement.roles-create');
    }

    /**
     * Store a newly created role in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        try {
            Role::create(['name' => $request->name]);
            return redirect()->route('roles.index')->with('success', 'Role created successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Failed to create role. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role) // ✅ Implicit route model binding
    {
        return view('UserManagement.roles-edit', compact('role'));
    }

    /**
     * Update the specified role in the database.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ]);

        try {
            $role->update(['name' => $request->name]);
            return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Failed to update role. Please try again.');
        }
    }

    /**
     * Remove the specified role from the database.
     */
    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Failed to delete role. Please try again.');
        }
    }
}
