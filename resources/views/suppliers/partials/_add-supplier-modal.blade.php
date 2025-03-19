<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier</title>

    <!-- ✅ Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- ✅ FontAwesome Free Icons (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- ✅ Alpine.js (For Modal & Dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <style>
        body { font-family: 'Roboto', sans-serif; }

        /* Compact Input Box */
        .input-box {
            height: 42px;
            padding: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            outline: none;
            font-size: 14px;
            width: 100%;
            background-color: #f9f9f9;
            color: #333;
        }

        /* Input Focus */
        .input-box:focus {
            border-color: #017e84;
            background-color: white;
        }

        /* Modal */
        .modal {
            width: 100%;
            max-width: 40rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Label */
        .label {
            font-size: 14px;
            font-weight: 500;
            color: #6b7280;
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center p-6" x-data="{ open: false }">

    <!-- ✅ Open Modal Button -->
    <button @click="open = true" class="flex items-center gap-2 bg-[#017e84] text-white px-4 py-2 rounded-md">
        <i class="fas fa-user-plus"></i> Add Supplier
    </button>

    <!-- ✅ Modal Overlay -->
    <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50"
        x-transition:enter="transition ease-out duration-300"
        x-transition:leave="transition ease-in duration-200"
        @click.away="open = false">
        
        <div class="modal p-6 relative" x-show="open" x-transition>
            <button @click="open = false" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-lg">
                <i class="fas fa-times"></i>
            </button>
            
            <h3 class="text-lg font-semibold text-gray-800">Create Supplier</h3>
            
            <form action="{{ route('suppliers.store') }}" method="POST" class="space-y-4 mt-4">
                @csrf
                
                <!-- 🔹 Contact ID & Name -->
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="label">Contact ID</label>
                        <input type="text" name="contact_id" class="input-box w-full" placeholder="Leave empty to autogenerate">
                    </div>
                    <div>
                        <label class="label">Supplier Name *</label>
                        <input type="text" name="supplier_name" class="input-box w-full" required>
                    </div>
                </div>
                
                <!-- 🔹 Mobile & Email -->
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="label">Mobile *</label>
                        <input type="text" name="phone" class="input-box w-full" required>
                    </div>
                    <div>
                        <label class="label">Email (Optional)</label>
                        <input type="email" name="email" class="input-box w-full">
                    </div>
                </div>
                
                <!-- 🔹 Assigned To (Dropdown with Laravel Data) -->
                <div>
                    <label class="label">Assigned To *</label>
                    <select name="assigned_to" class="input-box" required>
                        <option disabled selected>Select a User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->username }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- 🔹 Opening Balance & Advance Balance -->
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="label">Opening Balance</label>
                        <input type="number" name="opening_balance" step="0.01" class="input-box w-full">
                    </div>
                    <div>
                        <label class="label">Advance Balance</label>
                        <input type="number" name="advance_balance" step="0.01" class="input-box w-full">
                    </div>
                </div>
                
                <!-- 🔹 Address -->
                <div>
                    <label class="label">Address</label>
                    <textarea name="address" class="input-box w-full" placeholder="Supplier Address"></textarea>
                </div>
                
                <!-- 🔹 Buttons -->
                <div class="flex justify-between mt-4 border-t pt-4">
                    <button type="button" @click="open = false" class="text-gray-700 flex items-center gap-2">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="flex items-center gap-2 bg-[#017e84] text-white px-4 py-2 rounded-md">
                        <i class="fas fa-save"></i> Save Supplier
                    </button>
                </div>
                
            </form>
        </div>
    </div>
</body>
</html>