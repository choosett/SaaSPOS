<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return view('roles.index'); // Ensure the view exists in `resources/views/roles/index.blade.php`
    }
}
