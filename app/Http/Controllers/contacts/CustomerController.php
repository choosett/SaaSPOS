<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display the customer list page.
     */
    public function index()
    {
        return view('customers.index');
    }
}
