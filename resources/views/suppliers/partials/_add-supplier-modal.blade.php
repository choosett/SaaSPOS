<!-- ✅ Add Supplier Modal -->
<div x-data="{ open: false }" x-init="fetchUsers()">
    <!-- ✅ Add Supplier Button -->
    <button @click="open = true"
        class="bg-[#017e84] hover:bg-[#015a5e] text-white px-4 py-2 rounded-md flex items-center gap-2 shadow-md transition">
        <span class="material-icons">add</span> @lang('Add Supplier')
    </button>

    <!-- ✅ Modal Overlay -->
    <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click.away="open = false">

        <!-- ✅ Modal Content -->
        <div class="bg-white shadow-lg p-6 relative transition-all duration-300 ease-in-out rounded-lg"
             :class="{ 'max-w-3xl w-full': window.innerWidth > 768, 
                       'max-w-s w-[85%]': window.innerWidth <= 768 }"
             style="max-height: 90vh; overflow-y: auto;">

            <!-- ✅ Close Button -->
            <button @click="open = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">
                <span class="material-icons">close</span>
            </button>

            <!-- ✅ Modal Header -->
            <h2 class="text-lg font-semibold text-[#017e84] mb-4">@lang('Add Supplier')</h2>

            <!-- ✅ Supplier Form -->
            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf <!-- ✅ CSRF Token -->

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- ✅ Left Section -->
                    <div>
                        <!-- Contact ID -->
                        <div class="mb-3">
                            <label class="text-sm font-semibold text-gray-800">@lang('Contact ID')</label>
                            <input type="text" name="contact_id"
                                class="border border-gray-300 rounded-md px-3 h-9 text-sm w-full focus:ring-[#017e84]"
                                placeholder="@lang('Leave empty to autogenerate')">
                        </div>

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="text-sm font-semibold text-gray-800">@lang('Name') *</label>
                            <input type="text" name="supplier_name" required
                                class="border border-gray-300 rounded-md px-3 h-9 text-sm w-full focus:ring-[#017e84]">
                        </div>

                        <!-- Mobile -->
                        <div class="mb-3">
                            <label class="text-sm font-semibold text-gray-800">@lang('Mobile') *</label>
                            <input type="text" name="phone" required
                                class="border border-gray-300 rounded-md px-3 h-9 text-sm w-full focus:ring-[#017e84]">
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="text-sm font-semibold text-gray-800">@lang('Email')</label>
                            <input type="email" name="email"
                                class="border border-gray-300 rounded-md px-3 h-9 text-sm w-full focus:ring-[#017e84]">
                        </div>
                    </div>

                    <!-- ✅ Right Section -->
                    <div>
                        <!-- Assigned To -->
                        <div class="mb-3">
                            <label class="text-sm font-semibold text-gray-800">@lang('Assigned to') *</label>
                            <select name="assigned_to" id="assignedToForm" 
                                class="border border-gray-300 rounded-md px-3 h-9 text-sm w-full focus:ring-[#017e84]" required>
                                <option value="" disabled>@lang('Select a user')</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->username }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Opening Balance -->
                        <div class="mb-3">
                            <label class="text-sm font-semibold text-gray-800">@lang('Opening Balance')</label>
                            <input type="number" name="opening_balance" step="0.01"
                                class="border border-gray-300 rounded-md px-3 h-9 text-sm w-full focus:ring-[#017e84]">
                        </div>

                        <!-- Advance Balance -->
                        <div class="mb-3">
                            <label class="text-sm font-semibold text-gray-800">@lang('Advance Balance')</label>
                            <input type="number" name="advance_balance" step="0.01"
                                class="border border-gray-300 rounded-md px-3 h-9 text-sm w-full focus:ring-[#017e84]">
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label class="text-sm font-semibold text-gray-800">@lang('Address')</label>
                            <textarea name="address" rows="2"
                                class="border border-gray-300 rounded-md px-3 text-sm w-full focus:ring-[#017e84]"></textarea>
                        </div>
                    </div>
                </div>

                <!-- ✅ Buttons -->
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="open = false"
                        class="border border-gray-300 text-gray-700 px-3 py-1 rounded-md text-sm hover:bg-gray-100 transition">
                        @lang('Cancel')
                    </button>
                    <button type="submit"
                        class="bg-[#017e84] hover:bg-[#015a5e] text-white px-3 py-1 rounded-md text-sm shadow-md transition">
                        @lang('Save Supplier')
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
