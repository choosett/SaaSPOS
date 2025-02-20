<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index()
    {
        return view('dashboard'); // Ensure `resources/views/dashboard.blade.php` exists
    }
}
