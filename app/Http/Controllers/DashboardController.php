<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $dashboardData = [
            'total_sales' => 120000, 
            'net_sales' => 110000, 
            'invoice_due' => 5000, 
            'total_sell_return' => 2000,
            'total_purchase' => 80000,
            'purchase_due' => 7000,
            'total_purchase_return' => 3000,
            'expense' => 15000,
        ];

        return view('dashboard', ['dashboardData' => $dashboardData]); // ✅ Pass data correctly
    }
}
