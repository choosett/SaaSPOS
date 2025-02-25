@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')


<!-- White background for the entire page -->
<div class="min-h-screen bg-white flex transition-all duration-500 ease-in-out">
    
    <!-- Sidebar Placeholder (Dynamic Width) -->
    <div id="sidebarPlaceholder" class="md:block hidden transition-all duration-500 ease-in-out"></div>

    <!-- Main Content -->
    <div id="dashboardContent" class="flex-1 p-6 transition-all duration-500 ease-in-out">
        
        <!-- Grid Background Wrapper -->
        <div class="max-w-7xl mx-auto bg-[#0F317D] text-white rounded-xl p-6 shadow-lg">

            <!-- Header -->
            <h1 class="text-3xl font-bold mb-6 flex items-center gap-2">
                Welcome Admin <span class="wave">👋</span>
            </h1>

            <!-- Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Total Sales -->
                <div class="bg-white text-gray-900 shadow-md rounded-lg p-4 flex flex-col">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-100 p-2 rounded-full">
                            <i class="text-blue-500 fas fa-shopping-cart"></i>
                        </div>
                        <h2 class="text-gray-600 font-medium">Total Sales</h2>
                    </div>
                    <p class="text-lg font-bold mt-2">${{ number_format($dashboardData['total_sales'] ?? 0, 2) }}</p>
                </div>

                <!-- Net Sales -->
                <div class="bg-white text-gray-900 shadow-md rounded-lg p-4 flex flex-col">
                    <div class="flex items-center gap-3">
                        <div class="bg-green-100 p-2 rounded-full">
                            <i class="text-green-500 fas fa-dollar-sign"></i>
                        </div>
                        <h2 class="text-gray-600 font-medium">Net</h2>
                    </div>
                    <p class="text-lg font-bold mt-2">${{ number_format($dashboardData['net_sales'] ?? 0, 2) }}</p>
                </div>

                <!-- Invoice Due -->
                <div class="bg-white text-gray-900 shadow-md rounded-lg p-4 flex flex-col">
                    <div class="flex items-center gap-3">
                        <div class="bg-yellow-100 p-2 rounded-full">
                            <i class="text-yellow-500 fas fa-file-invoice"></i>
                        </div>
                        <h2 class="text-gray-600 font-medium">Invoice Due</h2>
                    </div>
                    <p class="text-lg font-bold mt-2">${{ number_format($dashboardData['invoice_due'] ?? 0, 2) }}</p>
                </div>

                <!-- Total Sell Return -->
                <div class="bg-white text-gray-900 shadow-md rounded-lg p-4 flex flex-col">
                    <div class="flex items-center gap-3">
                        <div class="bg-red-100 p-2 rounded-full">
                            <i class="text-red-500 fas fa-undo-alt"></i>
                        </div>
                        <h2 class="text-gray-600 font-medium">Total Sell Return</h2>
                    </div>
                    <p class="text-lg font-bold mt-2">${{ number_format($dashboardData['total_sell_return'] ?? 0, 2) }}</p>
                </div>

                <!-- Total Purchase -->
                <div class="bg-white text-gray-900 shadow-md rounded-lg p-4 flex flex-col">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-100 p-2 rounded-full">
                            <i class="text-blue-500 fas fa-download"></i>
                        </div>
                        <h2 class="text-gray-600 font-medium">Total Purchase</h2>
                    </div>
                    <p class="text-lg font-bold mt-2">${{ number_format($dashboardData['total_purchase'] ?? 0, 2) }}</p>
                </div>

                <!-- Purchase Due -->
                <div class="bg-white text-gray-900 shadow-md rounded-lg p-4 flex flex-col">
                    <div class="flex items-center gap-3">
                        <div class="bg-orange-100 p-2 rounded-full">
                            <i class="text-orange-500 fas fa-exclamation-circle"></i>
                        </div>
                        <h2 class="text-gray-600 font-medium">Purchase Due</h2>
                    </div>
                    <p class="text-lg font-bold mt-2">${{ number_format($dashboardData['purchase_due'] ?? 0, 2) }}</p>
                </div>

                <!-- Total Purchase Return -->
                <div class="bg-white text-gray-900 shadow-md rounded-lg p-4 flex flex-col">
                    <div class="items-center gap-3">
                        <div class="bg-pink-100 p-2 rounded-full">
                            <i class="text-pink-500 fas fa-receipt"></i>
                        </div>
                        <h2 class="text-gray-600 font-medium">Total Purchase Return</h2>
                    </div>
                    <p class="text-lg font-bold mt-2">${{ number_format($dashboardData['total_purchase_return'] ?? 0, 2) }}</p>
                </div>

                <!-- Expense -->
                <div class="bg-white text-gray-900 shadow-md rounded-lg p-4 flex flex-col">
                    <div class="flex items-center gap-3">
                        <div class="bg-red-100 p-2 rounded-full">
                            <i class="text-red-500 fas fa-money-bill-wave"></i>
                        </div>
                        <h2 class="text-gray-600 font-medium">Expense</h2>
                    </div>
                    <p class="text-lg font-bold mt-2">${{ number_format($dashboardData['expense'] ?? 0, 2) }}</p>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.getElementById("sidebar");
        const sidebarPlaceholder = document.getElementById("sidebarPlaceholder");
        const dashboardContent = document.getElementById("dashboardContent");
        const toggleSidebar = document.getElementById("toggleSidebar");

        function toggleSidebarFunc() {
            sidebar.classList.toggle("-translate-x-full");
            sidebarPlaceholder.classList.toggle("hidden");
            dashboardContent.classList.toggle("w-full");
        }

        // Desktop Sidebar Toggle
        toggleSidebar.addEventListener("click", toggleSidebarFunc);

        // Hide Sidebar on Mobile by Default
        if (window.innerWidth < 768) {
            sidebar.classList.add("-translate-x-full");
            sidebarPlaceholder.classList.add("hidden");
            dashboardContent.classList.add("w-full");
        }
    });
</script>

@endsection
