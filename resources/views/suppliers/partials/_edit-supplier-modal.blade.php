<!-- ✅ Edit Supplier Modal -->
<div x-data="{ open: false }">
    <!-- Edit Button -->
    <button @click="open = true"
        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md flex items-center gap-1 shadow-md">
        <span class="material-icons">edit</span> @lang('Edit')
    </button>

    <!-- Modal Overlay -->
    <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        x-transition:enter="transition ease-out duration-300" 
        x-transition:enter-start="opacity-0" 
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        
        <!-- Modal Content -->
        <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 relative">
            <!-- Close Button -->
            <button @click="open = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">
                <span class="material-icons">close</span>
            </button>

            <h2 class="text-lg font-semibold text-gray-800 mb-4">@lang('Edit Supplier')</h2>

            <!-- Supplier Form -->
            <form action="{{ route('suppliers.update', $editingSupplier->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- ✅ Left Section -->
                    <div>
                        <!-- Contact ID -->
                        <div class="mb-4">
                            <label class="text-sm font-semibold text-gray-700">@lang('Contact ID')</label>
                            <input type="text" name="contact_id" value="{{ $editingSupplier->contact_id }}"
                                class="border border-gray-300 rounded-md px-4 py-2 text-sm w-full">
                        </div>

                        <!-- Name -->
                        <div class="mb-4">
                            <label class="text-sm font-semibold text-gray-700">@lang('Name') *</label>
                            <input type="text" name="supplier_name" value="{{ $editingSupplier->name }}" required
                                class="border border-gray-300 rounded-md px-4 py-2 text-sm w-full">
                        </div>

                        <!-- Mobile -->
                        <div class="mb-4">
                            <label class="text-sm font-semibold text-gray-700">@lang('Mobile') *</label>
                            <input type="text" name="phone" value="{{ $editingSupplier->phone }}" required
                                class="border border-gray-300 rounded-md px-4 py-2 text-sm w-full">
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="text-sm font-semibold text-gray-700">@lang('Email')</label>
                            <input type="email" name="email" value="{{ $editingSupplier->email }}"
                                class="border border-gray-300 rounded-md px-4 py-2 text-sm w-full">
                        </div>
                    </div>

                    <!-- ✅ Right Section -->
                    <div>
                        <!-- Assigned to -->
                        <div class="mb-4">
                            <label class="text-sm font-semibold text-gray-700">@lang('Assigned to:')</label>
                            <select name="assigned_to"
                                class="border border-gray-300 rounded-md px-4 py-2 text-sm w-full">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" 
                                        {{ $editingSupplier->assigned_to == $user->id ? 'selected' : '' }}>
                                        {{ $user->username }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Opening Balance -->
                        <div class="mb-4">
                            <label class="text-sm font-semibold text-gray-700">@lang('Opening Balance')</label>
                            <input type="number" name="opening_balance" step="0.01"
                                value="{{ $editingSupplier->opening_balance }}"
                                class="border border-gray-300 rounded-md px-4 py-2 text-sm w-full">
                        </div>

                        <!-- Advance Balance -->
                        <div class="mb-4">
                            <label class="text-sm font-semibold text-gray-700">@lang('Advance Balance')</label>
                            <input type="number" name="advance_balance" step="0.01"
                                value="{{ $editingSupplier->advance_balance }}"
                                class="border border-gray-300 rounded-md px-4 py-2 text-sm w-full">
                        </div>

                        <!-- Address -->
                        <div class="mb-4">
                            <label class="text-sm font-semibold text-gray-700">@lang('Address')</label>
                            <textarea name="address" rows="2"
                                class="border border-gray-300 rounded-md px-4 py-2 text-sm w-full">{{ $editingSupplier->address }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="open = false"
                        class="border border-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-100">
                        @lang('Cancel')
                    </button>
                    <button type="submit"
                        class="bg-[#213183] hover:bg-blue-900 text-white px-4 py-2 rounded-md text-sm shadow-md">
                        @lang('Update Supplier')
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
