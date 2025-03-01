<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Display all users and roles for admins.
     */
    public function index()
    {
        // ✅ Fetch all users with their roles
        $users = User::with('roles')->paginate(10);

        // ✅ Fetch all available roles (to view and manage roles)
        $roles = Role::all();

        return view('Admin.users', compact('users', 'roles'));
    }
}
