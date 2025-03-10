<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function assignPermissionToUser(Request $request, User $user)
    {
        $request->validate([
            'permission' => 'required|string',
        ]);

        // Fetch permission only within the user's business
        $permission = Permission::where('name', $request->permission)
                                ->where('business_id', auth()->user()->business_id)
                                ->firstOrFail();

        // Assign permission to user
        $user->givePermissionTo($permission);

        return response()->json(['message' => 'Permission assigned successfully']);
    }
}
