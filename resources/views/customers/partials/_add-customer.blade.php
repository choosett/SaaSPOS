<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>

    <!-- ✅ Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ✅ FontAwesome Free Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- ✅ Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        body { font-family: 'Roboto', sans-serif; }

        .input-box {
            height: 36px;
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            outline: none;
            font-size: 13px;
            width: 100%;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
        }

        .input-box:focus {
            border-color: #017e84;
            background-color: white;
        }

        /* ✅ Dropdown Menu Opens Upwards */
        .dropdown-menu {
            position: absolute;
            z-index: 50;
            width: 100%;
            background-color: white;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            max-height: 200px;
            overflow-y: auto;
            font-size: 13px;
            bottom: 100%; /* Opens upwards */
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 8px;
            cursor: pointer;
            font-size: 13px;
            color: #333;
        }

        /* ✅ White Icon on Hover */
        .dropdown-item:hover {
            background-color: #017e84;
            color: white;
        }

        .dropdown-item:hover i {
            color: white !important;
        }

        .modal {
            width: 100%;
            max-width: 38rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-height: 85vh;
            overflow-y: auto;
        }

        /* ✅ Mobile Optimization */
        @media (max-width: 768px) {
            .modal {
                max-width: 92%;
                padding: 14px;
            }
            .grid-cols-3 {
                grid-template-columns: 1fr !important;
                gap: 8px;
            }
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center p-6">

    <!-- ✅ Modal Overlay -->
    <div id="addCustomerModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50 p-4">
        <div class="modal relative">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-lg">
                <i class="fas fa-times"></i>
            </button>

            <h3 class="text-lg font-semibold text-gray-800">Create Customer</h3>

            <form action="#" method="POST" class="space-y-4 mt-4">

                <!-- 🔹 Full Name -->
                <div>
                    <label class="label">Full Name</label>
                    <input type="text" name="name" class="input-box w-full" placeholder="Enter Customer Name" required>
                </div>

                <!-- 🔹 Phone Number & Email -->
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="label">Phone Number</label>
                        <input type="tel" name="phone" maxlength="11" pattern="\d{11}" class="input-box w-full" placeholder="+880" required>
                    </div>
                    <div>
                        <label class="label">Email (Optional)</label>
                        <input type="email" name="email" class="input-box w-full" placeholder="Enter Email">
                    </div>
                </div>

                <!-- 🔹 Address -->
                <div>
                    <label class="label">Address</label>
                    <textarea name="address" class="input-box w-full" placeholder="Customer Address"></textarea>
                </div>

                <!-- 🔹 Map Location -->
                <div>
                    <label class="label">Map Location</label>
                    <input type="text" name="map_location" class="input-box w-full" placeholder="Map Location">
                </div>

                <!-- 🔹 Customer Type, Membership, Source -->
                <div class="grid grid-cols-3 gap-2 dropdown-wrapper">
                    
                    <!-- ✅ Customer Type Dropdown -->
                    <div x-data="{ open: false, selected: 'E-Commerce' }" class="relative w-full">
                        <label class="label">Customer Type</label>
                        <button @click="open = !open" class="input-box">
                            <i class="fas fa-shopping-cart text-blue-500"></i> <span x-text="selected"></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <ul x-show="open" x-transition @click.away="open = false" class="dropdown-menu mt-1 rounded shadow">
                            <li @click="selected = 'E-Commerce'; open = false" class="dropdown-item"><i class="fas fa-shopping-cart text-blue-500"></i> E-Commerce</li>
                            <li @click="selected = 'Walk-in Customer'; open = false" class="dropdown-item"><i class="fas fa-store text-green-500"></i> Walk-in Customer</li>
                            <li @click="selected = 'Wholesaler'; open = false" class="dropdown-item"><i class="fas fa-truck text-orange-500"></i> Wholesaler</li>
                            <li @click="selected = 'Distributor'; open = false" class="dropdown-item"><i class="fas fa-industry text-purple-500"></i> Distributor</li>
                        </ul>
                    </div>

                    <!-- ✅ Membership Dropdown -->
    <div x-data="{ open: false, selected: 'Regular' }" class="relative">
        <label class="label">Membership</label>
        <button @click="open = !open" class="input-box flex justify-between items-center">
            <i class="fas fa-user text-gray-500"></i> <span x-text="selected"></span>
            <i class="fas fa-chevron-down"></i>
        </button>
        
        <ul x-show="open" @click.away="open = false" class="dropdown-menu mt-1 rounded shadow">
            <li @click="selected = 'Regular'; open = false" class="dropdown-item">
                <i class="fas fa-user text-gray-500"></i> Regular
            </li>
            <li @click="selected = 'VIP'; open = false" class="dropdown-item">
                <i class="fas fa-crown text-yellow-500"></i> VIP
            </li>
            <li @click="selected = 'Premium'; open = false" class="dropdown-item">
                <i class="fas fa-gem text-blue-500"></i> Premium
            </li>
            <li @click="selected = 'Gold'; open = false" class="dropdown-item">
                <i class="fas fa-star text-yellow-400"></i> Gold
            </li>
        </ul>
    </div>

        <!-- ✅ Source Dropdown -->
        <div x-data="{ open: false, selected: 'Facebook' }" class="relative">
            <label class="label">Source</label>
            <button @click="open = !open" class="input-box flex justify-between items-center">
                <i class="fab fa-facebook text-blue-600"></i> <span x-text="selected"></span>
                <i class="fas fa-chevron-down"></i>
            </button>
            
            <ul x-show="open" @click.away="open = false" class="dropdown-menu mt-1 rounded shadow">
                <li @click="selected = 'Facebook'; open = false" class="dropdown-item">
                    <i class="fab fa-facebook text-blue-600"></i> Facebook
                </li>
                <li @click="selected = 'Phone'; open = false" class="dropdown-item">
                    <i class="fas fa-phone text-green-600"></i> Phone
                </li>
                <li @click="selected = 'Instagram'; open = false" class="dropdown-item">
                    <i class="fab fa-instagram text-pink-500"></i> Instagram
                </li>
                <li @click="selected = 'TikTok'; open = false" class="dropdown-item">
                    <i class="fab fa-tiktok text-black"></i> TikTok
                </li>
                <li @click="selected = 'Offline'; open = false" class="dropdown-item">
                    <i class="fas fa-store text-orange-500"></i> Offline
                </li>
                <li @click="selected = 'Website'; open = false" class="dropdown-item">
                    <i class="fas fa-globe text-blue-500"></i> Website
                </li>
                <li @click="selected = 'Live Chat'; open = false" class="dropdown-item">
                    <i class="fas fa-comments text-purple-500"></i> Live Chat
                </li>
                <li @click="selected = 'Telesales'; open = false" class="dropdown-item">
                    <i class="fas fa-headset text-teal-500"></i> Telesales
                </li>
                <li @click="selected = 'Whatsapp'; open = false" class="dropdown-item">
                    <i class="fab fa-whatsapp text-green-500"></i> Whatsapp
                </li>
                <li @click="selected = 'Others'; open = false" class="dropdown-item">
                    <i class="fas fa-ellipsis-h text-gray-500"></i> Others
                </li>
            </ul>
        </div>

                </div>

                <!-- 🔹 Buttons -->
                <div class="flex justify-between mt-4 border-t pt-4">
                    <button type="button" onclick="closeModal()" class="text-gray-700 flex items-center gap-2">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="flex items-center gap-2 bg-[#017e84] text-white px-4 py-2 rounded-md">
                        <i class="fas fa-save"></i> Save
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        function openModal() { document.getElementById("addCustomerModal").classList.remove("hidden"); }
        function closeModal() { document.getElementById("addCustomerModal").classList.add("hidden"); }
    </script>

</body>
</html>
