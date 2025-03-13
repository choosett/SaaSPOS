<!-- ✅ Header: Customer List (Left) & Add Customer Button (Right) -->
<div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800">@lang('Customer List')</h2>
        <button class="bg-[#017e84] text-white px-4 py-2 rounded-md text-sm shadow-md flex items-center gap-2">
            ➕ @lang('Add Customer')
        </button>
    </div>

    <!-- ✅ Bottom Controls (Search & Show Entries) -->
    <div class="flex justify-between items-center mb-4">
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

        <!-- ✅ Search Bar (Right) -->
        <div class="relative w-56">
            <input type="text" placeholder="@lang('Search...')" class="border border-gray-300 rounded-md px-2 py-1 text-sm w-full focus:ring-2 focus:ring-[#017e84]">
            <span class="absolute right-2 top-1 text-gray-500">🔍</span>
        </div>
    </div>

    <!-- ✅ Compact Filter & Action Buttons -->
    <div class="flex justify-center gap-3 border-t border-gray-200 pt-3">
        <!-- Columns -->
        <div class="relative">
            <button onclick="toggleColumnDropdown()" class="bg-[#017e84] text-white px-3 py-1.5 rounded-md text-sm flex items-center gap-1 shadow">
                📊 @lang('Columns')
            </button>
            <div id="columnDropdown" class="hidden absolute bg-white border border-gray-300 shadow-lg rounded-md w-48 mt-1 z-50 p-2">
                <p class="text-xs font-semibold text-gray-700 mb-1">@lang('Columns')</p>
                <div class="flex flex-col gap-1 text-xs text-gray-700">
                    <label class="flex items-center gap-1"><input type="checkbox" class="custom-checkbox" checked> @lang('ID')</label>
                    <label class="flex items-center gap-1"><input type="checkbox" class="custom-checkbox" checked> @lang('Contact')</label>
                    <label class="flex items-center gap-1"><input type="checkbox" class="custom-checkbox" checked> @lang('Name')</label>
                    <label class="flex items-center gap-1"><input type="checkbox" class="custom-checkbox" checked> @lang('Location')</label>
                </div>
            </div>
        </div>

        <!-- Preferences -->
        <button onclick="togglePreferencePopup()" class="bg-[#017e84] text-white px-3 py-1.5 rounded-md text-sm flex items-center gap-1 shadow">
            ⚙️ @lang('Preferences')
        </button>

        <!-- Advanced Filter -->
        <button onclick="toggleFilterPopup()" class="bg-[#017e84] text-white px-3 py-1.5 rounded-md text-sm flex items-center gap-1 shadow">
            🎛️ @lang('Advanced Filter')
        </button>

        <!-- Action Menu -->
        <div class="relative">
            <button onclick="toggleActionDropdown()" class="bg-[#017e84] text-white px-3 py-1.5 rounded-md text-sm flex items-center gap-1 shadow">
                ⚡ @lang('Action')
            </button>
            <div id="actionDropdown" class="hidden absolute bg-white border border-gray-300 shadow-lg rounded-md w-44 mt-1 z-50 p-2">
                <button class="flex items-center gap-1 w-full text-sm text-gray-700 px-2 py-1 hover:bg-gray-100">➕ @lang('Add Customer Tag')</button>
                <button class="flex items-center gap-1 w-full text-sm text-gray-400 px-2 py-1 cursor-not-allowed">📂 @lang('Upload Customers')</button>
                <button class="flex items-center gap-1 w-full text-sm text-gray-700 px-2 py-1 hover:bg-gray-100">📄 @lang('Export As CSV')</button>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Advanced Filter Popup -->
<div id="filterPopup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white shadow-lg rounded-lg p-6 w-[90%] md:w-[600px] max-h-[80vh] overflow-y-auto relative">
        <button onclick="toggleFilterPopup()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">✖</button>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">@lang('Advanced Filters')</h2>
        <p class="text-sm font-semibold text-gray-700">@lang('Sources')</p>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-2 text-sm text-gray-700 mt-2">
            <label><input type="checkbox" class="custom-checkbox"> @lang('Phone Call')</label>
            <label><input type="checkbox" class="custom-checkbox"> @lang('Facebook')</label>
            <label><input type="checkbox" class="custom-checkbox"> @lang('Messenger')</label>
            <label><input type="checkbox" class="custom-checkbox"> @lang('WhatsApp')</label>
            <label><input type="checkbox" class="custom-checkbox"> @lang('Instagram')</label>
            <label><input type="checkbox" class="custom-checkbox"> @lang('Website')</label>
        </div>
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