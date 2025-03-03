        <!-- SIDEBAR CONTAINER -->
        <div id="sidebar" class="w-64 bg-[#f4f4f5] border-r border-[#cbd5e1] shadow-md overflow-y-auto z-50 transition-all duration-300 ease-in-out md:translate-x-0 -translate-x-full">
            
            <!-- USER INFO SECTION -->
            <div class="p-4 text-center border-b border-[#cbd5e1]">
                <div class="flex flex-col items-center bg-gray-100 p-4 rounded-lg">
                <img src="{{ $authUser && $authUser->avatar ? asset('storage/' . $authUser->avatar) : 'https://cdn-icons-png.flaticon.com/512/147/147144.png' }}" 
            alt="User Avatar" class="rounded-full w-16 h-16">
        <h2 class="mt-2 font-bold text-gray-800 text-sm">{{ $authUser ? $authUser->first_name . ' ' . ($authUser->last_name ?? '') : 'Guest User' }}</h2>
        <p class="text-gray-500 text-xs">{{ $authUser ? $authUser->email : 'Not Logged In' }}</p>
        <p class="text-gray-700 text-sm font-bold bg-gray-200 px-3 py-1 rounded-md mt-2">
            Business ID: {{ $authUser->business_id ?? 'N/A' }}
        </p>


            <!-- Business ID (More Visible) -->
    
        </div>

        <!-- Buttons -->
        <div class="mt-3 flex justify-center space-x-2">
            <a href="{{ route('profile.show', ['view' => 'profile.index']) }}" class="flex items-center px-3 py-1.5 text-sm font-semibold text-gray-700 border border-gray-300 rounded-md hover:bg-gray-200 transition">
                <span class="material-icons text-gray-500 text-sm mr-1">person</span> Profile
            </a>
            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="flex items-center px-3 py-1.5 text-sm font-semibold text-red-600 border border-red-300 rounded-md hover:bg-red-100 transition w-full text-left">
                    <span class="material-icons text-red-500 text-sm mr-1">logout</span>
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- SIDEBAR MENU -->
    <nav class="mt-4">
        <ul id="sidebar-menu" class="space-y-1">
            @php
                $menus = [
                    ["name" => "Dashboard", "icon" => "dashboard", "link" => route('dashboard')],
                            ["name" => "User Management", "icon" => "group", "submenu" => [
                                ["name" => "Users", "link" => route('users.index')], // ✅ Correct route
                                ["name" => "ALL Roles", "link" => route('roles.index')]  // ✅ Correct route
                                            ]],

                    ["name" => "Contacts", "icon" => "contacts", "submenu" => [
                        ["name" => "Suppliers", "link" => "#"],
                        ["name" => "Customers", "link" => "#"],
                        ["name" => "Membership", "link" => "#"],
                        ["name" => "Import Contacts", "link" => "#"]
                    ]],
                    ["name" => "Products", "icon" => "inventory_2", "submenu" => [
                        ["name" => "List Products", "link" => "#"],
                        ["name" => "Add Products", "link" => "#"],
                        ["name" => "Update Price", "link" => "#"],
                        ["name" => "Print Labels", "link" => "#"],
                        ["name" => "Variation", "link" => "#"],
                        ["name" => "Import Products", "link" => "#"],
                        ["name" => "Import Opening Stock", "link" => "#"],
                        ["name" => "Selling Price Group", "link" => "#"],
                        ["name" => "Units", "link" => "#"],
                        ["name" => "Categories", "link" => "#"],
                        ["name" => "Brands", "link" => "#"],
                        ["name" => "Warranties", "link" => "#"]
                        
                    ]],
                    ["name" => "Purchase", "icon" => "shopping_cart", "submenu" => [
                        ["name" => "List Purchase", "link" => "#"],
                        ["name" => "Add Purchase", "link" => "#"],
                        ["name" => "List Return Purchase", "link" => "#"]
                    ]],
                    ["name" => "Stock Management", "icon" => "store", "submenu" => [
                        ["name" => "Stock Report", "link" => "#"],
                        ["name" => "Update Stock", "link" => "#"],
                        ["name" => "Stock Expiry Report", "link" => "#"],
                        ["name" => "Stock Transfer", "link" => "#"],
                        ["name" => "List Transfer", "link" => "#"]
                    ]],
                    ["name" => "Sell", "icon" => "point_of_sale", "submenu" => [
                        ["name" => "All Sales", "link" => "#"],
                        ["name" => "Add Sale", "link" => "#"],
                        ["name" => "POS", "link" => "#"],
                        ["name" => "Discounts", "link" => "#"],
                        ["name" => "Import Sales", "link" => "#"]
                    ]],
                    ["name" => "Courier", "icon" => "local_shipping", "submenu" => [
                        ["name" => "List Parcel", "link" => "#"],
                        ["name" => "Add Parcel", "link" => "#"],
                        ["name" => "Courier Setting", "link" => "#"]
                    ]],
                    ["name" => "Expense", "icon" => "receipt_long", "submenu" => [
                        ["name" => "List Expense", "link" => "#"],
                        ["name" => "Add Expense", "link" => "#"],
                        ["name" => "Expense Category", "link" => "#"]
                    ]],
                    ["name" => "Payment Accounts", "icon" => "account_balance_wallet", "submenu" => [
                        ["name" => "All Accounts", "link" => "#"],
                        ["name" => "Balance Sheet", "link" => "#"],
                        ["name" => "Trial Balance", "link" => "#"],
                        ["name" => "Cash Flow", "link" => "#"],
                        ["name" => "Payment Account Report", "link" => "#"]
                    ]],
                    ["name" => "Reports", "icon" => "bar_chart", "submenu" => [
                        ["name" => "Profit/Loss Report", "link" => "#"],
                        ["name" => "Purchase & Sale", "link" => "#"],
                        ["name" => "Tax Report", "link" => "#"],
                        ["name" => "Suppliers & Customer Report", "link" => "#"]
                    ]],
                    ["name" => "Notification Templates", "icon" => "notifications", "link" => "#"],
                    ["name" => "Settings", "icon" => "settings", "submenu" => [
                        ["name" => "Business Settings", "link" => "#"],
                        ["name" => "Business Locations", "link" => "#"],
                        ["name" => "Invoice Settings", "link" => "#"],
                        ["name" => "Barcode Settings", "link" => "#"],
                        ["name" => "Receipt Printers", "link" => "#"],
                        ["name" => "Tax Rates", "link" => "#"]
                    ]]
                ];
            @endphp
            @foreach ($menus as $menu)
                <li>
                    <a href="{{ $menu['link'] ?? '#' }}" class="flex items-center text-gray-600 font-semibold text-sm px-3 py-2 rounded-md hover:bg-gray-200 transition @if(isset($menu['submenu'])) has-arrow @endif">
                        <span class="material-icons mr-3">{{ $menu['icon'] }}</span> {{ $menu['name'] }}
                    </a>
                    @if(isset($menu['submenu']))
                        <ul class="submenu hidden ml-6 border-l border-[#cbd5e1]">
                            @foreach ($menu['submenu'] as $submenu)
                                <li><a href="{{ $submenu['link'] }}" class="block px-3 py-2 text-gray-600 hover:bg-gray-100">{{ $submenu['name'] }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>
</div>