<!-- ✅ Table Container with Scrollable Body & Fixed Header -->
<div class="relative w-full overflow-x-auto max-h-[700px]" id="table-container">
    <div class="relative min-w-[1000px]">
        <table class="w-full border-collapse text-xs relative" id="suppliers-table">
            <thead class="bg-[#017e84] text-white uppercase text-xs sticky top-0 z-20"
                style="font-family: 'Inter', sans-serif;">
                <tr>
                    <th class="px-2 py-2 text-left sticky left-0 bg-[#017e84] z-30 w-24">@lang('Action')</th>
                    <th class="px-2 py-2 text-left">@lang('Contact ID')</th>
                    <th class="px-2 py-2 text-left">@lang('Business Name')</th>
                    <th class="px-2 py-2 text-left">@lang('Mobile')</th>
                    <th class="px-2 py-2 text-left">@lang('Opening Balance')</th>
                    <th class="px-2 py-2 text-left">@lang('Advance Balance')</th>
                    <th class="px-2 py-2 text-left">@lang('Address')</th>
                    <th class="px-2 py-2 text-left">@lang('Assigned To')</th>
                    <th class="px-2 py-2 text-left">@lang('Total Purchase Due')</th>
                    <th class="px-2 py-2 text-left">@lang('Total Purchase Return Due')</th>
                </tr>
            </thead>
            <tbody class="text-gray-800 text-xs" style="font-family: 'Roboto', sans-serif;">
                @foreach ($suppliers as $supplier)
                    <tr class="border-b hover:bg-[#017e84]/10 transition">
                        <td class="px-2 py-2 sticky left-0 bg-white z-10">
                            <!-- ✅ Updated Action Button -->
                            <button onclick="toggleDropdown(this, event)" 
                                class="border border-[#017e84] text-[#017e84] bg-white px-3 py-1 rounded-md flex items-center gap-1 shadow-md text-xs hover:bg-[#017e84] hover:text-white transition">
                                Actions ▼
                            </button>
                        </td>
                        <td class="px-2 py-2">{{ $supplier->contact_id }}</td>
                        <td class="px-2 py-2">{{ $supplier->supplier_name }}</td>
                        <td class="px-2 py-2">{{ $supplier->phone }}</td>
                        <td class="px-2 py-2">৳ {{ number_format($supplier->opening_balance, 2) }}</td>
                        <td class="px-2 py-2">৳ {{ number_format($supplier->advance_balance, 2) }}</td>
                        <td class="px-2 py-2">{{ $supplier->address }}</td>
                        <td class="px-2 py-2 assigned-user">
                            {{ $supplier->assignedUser->username ?? 'Unassigned' }}
                        </td>
                        <td class="px-2 py-2">৳ 0.00</td>
                        <td class="px-2 py-2">৳ 0.00</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- ✅ Pagination with Improved Design -->
<div class="bg-[#F8F8F8] text-xs text-gray-800 p-3 rounded-md flex justify-between items-center mt-2">
    <p>
        Showing <span id="current-entries">1</span> to <span id="max-entries">10</span> of 
        <span id="total-entries">10</span> entries
    </p>

    <div class="flex items-center gap-2">
        <!-- Previous Button -->
        <button id="prevPage" class="px-4 py-2 bg-gray-300 text-gray-500 rounded-full cursor-not-allowed shadow-sm text-xs" disabled>
            ← Prev
        </button>

        <!-- Page Number -->
        <span class="text-[#017e84] font-semibold text-sm" id="currentPage">1</span>

        <!-- Next Button -->
        <button id="nextPage" class="px-4 py-2 bg-[#017e84] text-white rounded-full shadow-md hover:bg-[#015a5e] border border-[#017e84] transition">
            Next →
        </button>
    </div>
</div>

<!-- ✅ Updated Dropdown Menu -->
<div id="dropdown-menu" class="hidden absolute bg-white border border-[#017e84] shadow-lg rounded-md w-40 z-50 text-xs">
    <a href="#" class="flex items-center gap-2 px-2 py-1 text-[#017e84] hover:bg-[#017e84]/10">💰 @lang('Pay')</a>
    <a href="#" class="flex items-center gap-2 px-2 py-1 text-[#017e84] hover:bg-[#017e84]/10">👁 @lang('View')</a>
    <a href="#" class="flex items-center gap-2 px-2 py-1 text-yellow-600 hover:bg-[#017e84]/10">✏️ @lang('Edit')</a>
    <a href="#" class="flex items-center gap-2 px-2 py-1 text-red-600 hover:bg-[#017e84]/10">🗑 @lang('Delete')</a>
    <a href="#" class="flex items-center gap-2 px-2 py-1 text-gray-600 hover:bg-[#017e84]/10">🔄 @lang('Deactivate')</a>
    <div class="border-t border-gray-200 my-1"></div>
    <a href="#" class="flex items-center gap-2 px-2 py-1 text-[#017e84] hover:bg-[#017e84]/10">📜 @lang('Ledger')</a>
    <a href="#" class="flex items-center gap-2 px-2 py-1 text-[#017e84] hover:bg-[#017e84]/10">📦 @lang('Purchases')</a>
    <a href="#" class="flex items-center gap-2 px-2 py-1 text-[#017e84] hover:bg-[#017e84]/10">⏳ @lang('Stock Report')</a>
    <a href="#" class="flex items-center gap-2 px-2 py-1 text-[#017e84] hover:bg-[#017e84]/10">📎 @lang('Documents & Notes')</a>
</div>

<!-- ✅ Load External Script -->
<script src="supplier.js"></script>
