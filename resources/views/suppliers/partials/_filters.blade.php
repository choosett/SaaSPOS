<!-- ✅ Filter Section with Smooth Toggle -->
<div class="bg-[#FFFFFF] shadow-md rounded-lg p-4 mb-4">
    <!-- ✅ Toggle Button -->
    <button onclick="toggleFilters()" 
        class="flex items-center gap-2 text-[#017e84] font-semibold text-lg focus:outline-none transition-all duration-200 hover:text-[#015a5e]">
        <span class="material-icons">filter_alt</span> @lang('Filters')
    </button>

    <!-- ✅ Filter Section (Initially Hidden with Transition) -->
    <div id="filterSection" class="overflow-hidden max-h-0 transition-all duration-300 ease-in-out mt-4 opacity-0">
        
        <!-- ✅ First Row: Additional Filters -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="flex items-center gap-2">
                <input type="checkbox" id="purchase_due" class="form-checkbox text-[#017e84]">
                <label for="purchase_due" class="text-gray-800 text-sm">@lang('Purchase Due')</label>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="purchase_return" class="form-checkbox text-[#017e84]">
                <label for="purchase_return" class="text-gray-800 text-sm">@lang('Purchase Return')</label>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="advance_balance" class="form-checkbox text-[#017e84]">
                <label for="advance_balance" class="text-gray-800 text-sm">@lang('Advance Balance')</label>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="opening_balance" class="form-checkbox text-[#017e84]">
                <label for="opening_balance" class="text-gray-800 text-sm">@lang('Opening Balance')</label>
            </div>
        </div>
        
        <!-- ✅ Second Row: Assigned To & Status -->
        <div class="grid grid-cols-2 md:grid-cols-2 gap-4 mt-4">
            <div>
                <label class="text-sm font-semibold text-gray-800">@lang('Assigned to:')</label>
                <select id="assignedToFilter" class="border border-gray-400 rounded-md px-4 py-2 text-sm w-full focus:ring-2 focus:ring-[#017e84]">
                    <option value="">@lang('All Users')</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->username }}">{{ $user->username }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-800">@lang('Status:')</label>
                <select id="statusFilter" class="border border-gray-400 rounded-md px-4 py-2 text-sm w-full focus:ring-2 focus:ring-[#017e84]">
                    <option value="">@lang('None')</option>
                    <option value="active">@lang('Active')</option>
                    <option value="inactive">@lang('Inactive')</option>
                </select>
            </div>
        </div>

        <!-- ✅ Third Row: Entries Dropdown, Export Buttons, Search -->
        <div class="flex flex-wrap justify-between items-center mt-6 gap-4">
            
            <!-- ✅ Show Entries Dropdown -->
            <div class="flex items-center gap-2">
                <label for="entriesSelect" class="text-sm font-semibold text-gray-800">@lang('Show')</label>
                <select id="entriesSelect" class="border border-gray-400 rounded-md px-4 py-1 text-sm w-24 focus:ring-2 focus:ring-[#017e84]">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span class="text-sm text-gray-800">@lang('entries')</span>
            </div>

            <!-- ✅ Export Buttons -->
            <div class="flex gap-2">
                <button id="exportExcel" class="border border-green-500 text-green-600 rounded-md px-3 py-1 text-xs flex items-center gap-2 hover:bg-green-50 transition">
                    <span class="material-icons text-xs">table_chart</span> Excel
                </button>
                <button id="exportPrint" class="border border-[#017e84] text-[#017e84] rounded-md px-3 py-1 text-xs flex items-center gap-2 hover:bg-[#017e84] hover:text-white transition">
                    <span class="material-icons text-xs">print</span> Print
                </button>
                <button id="exportPDF" class="border border-red-500 text-red-600 rounded-md px-3 py-1 text-xs flex items-center gap-2 hover:bg-red-50 transition">
                    <span class="material-icons text-xs">picture_as_pdf</span> PDF
                </button>
            </div>

            <!-- ✅ Search Bar -->
            <div class="relative w-64">
                <input type="text" id="searchInput" class="border border-gray-400 rounded-md px-4 py-2 text-sm w-full focus:ring-[#017e84]" placeholder="@lang('Search suppliers...')">
                <span class="absolute right-3 top-2 text-[#017e84] material-icons">search</span>
            </div>
        </div>
    </div>
</div>
