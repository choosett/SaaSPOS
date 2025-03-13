


<!-- ✅ Header: Customer List (Left) & Add Customer Button (Right) -->
    <div class="flex justify-between items-center mb-3">
        <h2 class="text-lg font-semibold text-gray-800">@lang('Customer List')</h2>
        <button class="bg-[#017e84] text-white px-4 py-2 rounded-md text-sm shadow-md flex items-center gap-2">
            ➕ @lang('Add Customer')
        </button>
    </div>

    <!-- ✅ Bottom Controls & Filters -->
    <div class="flex justify-between items-center mb-3">
        <!-- ✅ Show Entries Dropdown (Left) -->
        <div class="flex items-center gap-2">
            <label class="text-sm text-gray-700">@lang('Show')</label>
            <select class="border border-gray-300 rounded-md px-2 py-1 text-sm w-20 focus:ring-2 focus:ring-[#017e84]">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
            <span class="text-sm text-gray-700">@lang('entries')</span>
        </div>

       <!-- ✅ Filter & Action Buttons -->
            <div class="flex gap-2">
            <!-- ✅ Columns Dropdown (Compact) -->
            <div class="relative">
                <button onclick="toggleColumnDropdown()" class="bg-[#017e84] text-white px-2 py-1.5 rounded-md text-sm flex items-center gap-1 shadow">
                    📊 @lang('Columns')
                </button>
                <div id="columnDropdown" class="hidden absolute bg-white border border-gray-300 shadow-lg rounded-md w-44 mt-1 z-50 p-1">
                    <p class="text-xs font-semibold text-gray-700 mb-1 px-2">@lang('Columns')</p>
                    <div class="flex flex-col gap-0.5 text-xs text-gray-700">
                        @foreach(['ID', 'Contact', 'Name', 'Location', 'Orders', 'Sell Due', 'Created At', 'Last Order Date'] as $column)
                            <label class="flex items-center gap-1 px-2 py-1 rounded transition-all duration-200 hover:bg-[#017e84] hover:text-white cursor-pointer">
                                <input type="checkbox" class="custom-checkbox" checked> @lang($column)
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>




            <!-- Preferences -->
            <button onclick="togglePreferencePopup()" class="bg-[#017e84] text-white px-3 py-1.5 rounded-md text-sm shadow-md flex items-center gap-1">
                ⚙️ @lang('Preferences')
            </button>

            <!-- Advanced Filter -->
            <button onclick="toggleFilterPopup()" class="bg-[#017e84] text-white px-3 py-1.5 rounded-md text-sm shadow-md flex items-center gap-1">
                🎛️ @lang('Advanced Filter')
            </button>

                <!-- Action Menu -->
                <div class="relative">
                    <button onclick="toggleActionDropdown()" class="bg-[#017e84] text-white px-3 py-1.5 rounded-md text-sm shadow-md flex items-center gap-1">
                        ⚡ @lang('Action')
                    </button>
                    <div id="actionDropdown" class="hidden absolute bg-white border border-gray-300 shadow-lg rounded-md w-48 mt-1 z-50 p-2 right-0">
                        <button class="flex items-center gap-1 w-full text-sm text-gray-700 px-2 py-1 rounded-md transition-all duration-200 hover:bg-[#017e84] hover:text-white">
                            ➕ @lang('Add Customer Tag')
                        </button>
                        <button class="flex items-center gap-1 w-full text-sm text-gray-700 px-2 py-1 rounded-md transition-all duration-200 hover:bg-[#017e84] hover:text-white">
                            📂 @lang('Upload Customers')
                        </button>
                        <button class="flex items-center gap-1 w-full text-sm text-gray-700 px-2 py-1 rounded-md transition-all duration-200 hover:bg-[#017e84] hover:text-white">
                            📄 @lang('Export As Excel')
                        </button>
                        <button class="flex items-center gap-1 w-full text-sm text-gray-700 px-2 py-1 rounded-md transition-all duration-200 hover:bg-[#017e84] hover:text-white">
                            📄 @lang('Export As Excel')
                        </button>
                        <button class="flex items-center gap-1 w-full text-sm text-gray-700 px-2 py-1 rounded-md transition-all duration-200 hover:bg-[#017e84] hover:text-white">
                            📄 @lang('Export PDF')
                        </button>
                    </div>
                </div>


        </div>

        <!-- ✅ Search Bar -->
        <div class="relative w-56">
            <input type="text" placeholder="@lang('Search...')" class="border border-gray-300 rounded-md px-2 py-1 text-sm w-full focus:ring-2 focus:ring-[#017e84]">
            <span class="absolute right-2 top-1 text-gray-500">🔍</span>
        </div>
    </div>
</div>

<!-- Advanced Filters -->
<div id="filterPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white shadow-lg rounded-lg p-6 w-[90%] md:w-[600px] max-h-[80vh] overflow-y-auto relative">
        <button onclick="toggleFilterPopup()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">✖</button>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">@lang('Advanced Filters')</h2>
        
        <!-- Sources Filter -->
        <p class="text-sm font-semibold text-gray-700">@lang('Sources')</p>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-sm text-gray-700 mt-2">
            <label><input type="checkbox" class="custom-checkbox"> @lang('Phone Call')</label>
            <label><input type="checkbox" class="custom-checkbox"> @lang('Facebook')</label>
            <label><input type="checkbox" class="custom-checkbox"> @lang('Messenger')</label>
            <label><input type="checkbox" class="custom-checkbox"> @lang('WhatsApp')</label>
            <label><input type="checkbox" class="custom-checkbox"> @lang('Instagram')</label>
            <label><input type="checkbox" class="custom-checkbox"> @lang('TikTok')</label>
            <label><input type="checkbox" class="custom-checkbox"> @lang('Offline')</label>
            <label><input type="checkbox" class="custom-checkbox"> @lang('Up Sell')</label>
            <label><input type="checkbox" class="custom-checkbox"> @lang('Website')</label>
            <label><input type="checkbox" class="custom-checkbox"> @lang('Live Chat')</label>
            <label><input type="checkbox" class="custom-checkbox"> @lang('Telesales')</label>
            <label><input type="checkbox" class="custom-checkbox"> @lang('Other')</label>
        </div>

        <!-- Product Filter -->
        <p class="text-sm font-semibold text-gray-700 mt-4">@lang('Product')</p>
        <input type="text" id="productSearch" placeholder="@lang('Search Product Name / SKU')" 
            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#017e84] mt-2">
                <!-- ✅ Creation Date Range -->
                <p class="text-sm font-semibold text-gray-700 mt-4">@lang('Creation Date Range')</p>
                <div class="flex gap-2">
                    <input type="text" id="creationStart" class="pikaday-input w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#017e84]" placeholder="Start Date">
                    <input type="text" id="creationEnd" class="pikaday-input w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#017e84]" placeholder="End Date">
                </div>

                <!-- ✅ Last Order Date Range -->
                <p class="text-sm font-semibold text-gray-700 mt-4">@lang('Last Order Date Range')</p>
                <div class="flex gap-2">
                    <input type="text" id="lastOrderStart" class="pikaday-input w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#017e84]" placeholder="Start Date">
                    <input type="text" id="lastOrderEnd" class="pikaday-input w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#017e84]" placeholder="End Date">
                </div>

                <!-- ✅ No Order Since -->
                <p class="text-sm font-semibold text-gray-700 mt-4">@lang('No Order Since')</p>
                <input type="text" id="noOrderSince" class="pikaday-input w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#017e84]" placeholder="Select Date">

                <!-- ✅ Include Pikaday Calendar Component -->
                <div id="calendar-container">
                    @include('components.pikaday-calendar.index')
                </div>

                <!-- Sales Amount -->
                <p class="text-sm font-semibold text-gray-700 mt-4">@lang('Sales Amount (Min - Max)')</p>
                        <div class="flex gap-2">
                            <input type="number" placeholder="@lang('Min')" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#017e84]">
                            <input type="number" placeholder="@lang('Max')" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#017e84]">
                        </div>




        <!-- Apply Button -->
        <div class="flex justify-center mt-4">
            <button onclick="toggleFilterPopup()" class="bg-[#017e84] text-white px-5 py-2 rounded-md text-sm shadow-md">@lang('Apply Filter')</button>
        </div>
    </div>
</div>


<!-- ✅ Preferences Popup -->
<div id="preferencePopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white shadow-lg rounded-lg p-6 w-[90%] md:w-[400px] max-h-[80vh] overflow-y-auto relative">
        <button onclick="togglePreferencePopup()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">✖</button>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">@lang('Preferences')</h2>
        <div class="flex flex-col gap-2 text-sm text-gray-700">
            <label class="flex items-center gap-2"><input type="checkbox" class="custom-checkbox" checked> @lang('Store Customer Email')</label>
            <label class="flex items-center gap-2"><input type="checkbox" class="custom-checkbox" checked> @lang('Show Customer Tag')</label>
            <label class="flex items-center gap-2"><input type="checkbox" class="custom-checkbox" checked> @lang('Show Customer Source')</label>
        </div>
        <div class="flex justify-center mt-4">
            <button onclick="togglePreferencePopup()" class="bg-[#017e84] text-white px-5 py-2 rounded-md text-sm shadow-md">@lang('Save Preferences')</button>
        </div>
    </div>
</div>
<!-- ✅ JavaScript for Dropdowns & Popups -->
<script>
    function toggleColumnDropdown() { document.getElementById('columnDropdown').classList.toggle('hidden'); }
    function togglePreferencePopup() { document.getElementById('preferencePopup').classList.toggle('hidden'); }
    function toggleFilterPopup() { document.getElementById('filterPopup').classList.toggle('hidden'); }
    function toggleActionDropdown() { document.getElementById('actionDropdown').classList.toggle('hidden'); }
</script>
