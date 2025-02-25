<?php

namespace App\Http\Controllers; // ✅ Correct Namespace

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('UserManagement.users.index'); // ✅ Ensure this file exists
    }
}
