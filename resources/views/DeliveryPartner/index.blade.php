@extends('layouts.app')

@section('title', __('Courier List'))

@section('content')

<!-- ✅ FontAwesome Free Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<div class="max-w-7xl mx-auto p-0">
    <!-- ✅ Page Header -->
    <div class="flex justify-between items-center mb-6 relative">
        <h2 class="text-2xl font-semibold text-gray-800">@lang('Courier List')</h2>

        <!-- ✅ Add Courier Button with Dropdown -->
        <div class="relative">
            <button id="btn-add-courier" class="btn-add-courier">
                <i class="fas fa-plus-circle"></i> @lang('Add Courier')
            </button>

            <!-- ✅ Dropdown Menu -->
            <div id="courierDropdown" class="dropdown-menu hidden">
                <ul>
                    <!-- 🔹 Pathao -->
                    <li onclick="openModal('pathaoApiModal')">
                        <img src="{{ asset('deliverypartner/pathao.svg') }}" alt="Pathao">
                        @lang('Pathao')
                    </li>
                    
                    <!-- 🔹 Steadfast -->
                    <li onclick="openModal('steadfastApiModal')">
                        <img src="{{ asset('deliverypartner/steadfast.svg') }}" alt="Steadfast">
                        @lang('Steadfast')
                    </li>
                    
                    <!-- 🔹 RedX -->
                    <li onclick="openModal('redxApiModal')">
                        <img src="{{ asset('deliverypartner/redx.svg') }}" alt="RedX">
                        @lang('RedX')
                    </li>
                    
                    <!-- 🔹 E-Courier -->
                    <li onclick="openModal('eCourierApiModal')">
                        <img src="{{ asset('deliverypartner/e-courier.svg') }}" alt="E-Courier">
                        @lang('E-Courier')
                    </li>

                    <!-- 🔹 New Courier (No Action) -->
                    <li class="disabled">
                        <img src="{{ asset('deliverypartner/new-courier.svg') }}" alt="New Courier">
                        @lang('New Courier')
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- ✅ Courier Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>@lang('Courier ID')</th>
                    <th>@lang('Name')</th>
                    <th>@lang('Warehouse')</th>
                    <th>@lang('Status')</th>
                    <th class="text-center">@lang('Actions')</th>
                </tr>
            </thead>
            <tbody>
                <!-- 🔹 Pathao -->
                <tr>
                    <td><span class="courier-id pathao">C-1001</span></td>
                    <td>
                        <img src="{{ asset('deliverypartner/pathao.svg') }}" alt="Pathao" class="courier-icon">
                        @lang('Pathao')
                    </td>
                    <td>@lang('Dhaka Warehouse')</td>
                    <td><span class="status-active">@lang('Active')</span></td>
                    <td class="actions">
                        <button onclick="openModal('pathaoApiModal')" class="btn-api">
                            <i class="fas fa-cogs"></i> @lang('API Settings')
                        </button>
                        <button class="btn-settings">
                            <i class="fas fa-tools"></i> @lang('Settings')
                        </button>
                    </td>
                </tr>

                <!-- 🔹 Steadfast -->
                <tr>
                    <td><span class="courier-id steadfast">C-1002</span></td>
                    <td>
                        <img src="{{ asset('deliverypartner/steadfast.svg') }}" alt="Steadfast" class="courier-icon">
                        @lang('Steadfast')
                    </td>
                    <td>@lang('Chattogram Warehouse')</td>
                    <td><span class="status-active">@lang('Active')</span></td>
                    <td class="actions">
                        <button onclick="openModal('steadfastApiModal')" class="btn-api">
                            <i class="fas fa-cogs"></i> @lang('API Settings')
                        </button>
                        <button class="btn-settings">
                            <i class="fas fa-tools"></i> @lang('Settings')
                        </button>
                    </td>
                </tr>

                <!-- 🔹 RedX -->
                <tr>
                    <td><span class="courier-id redx">C-1003</span></td>
                    <td>
                        <img src="{{ asset('deliverypartner/redx.svg') }}" alt="RedX" class="courier-icon">
                        @lang('RedX')
                    </td>
                    <td>@lang('Khulna Warehouse')</td>
                    <td><span class="status-inactive">@lang('Inactive')</span></td>
                    <td class="actions">
                        <button onclick="openModal('redxApiModal')" class="btn-api">
                            <i class="fas fa-cogs"></i> @lang('API Settings')
                        </button>
                        <button class="btn-settings">
                            <i class="fas fa-tools"></i> @lang('Settings')
                        </button>
                    </td>
                </tr>
                <!-- 🔹 E-Courier -->
<tr>
    <td><span class="courier-id ecourier">C-1004</span></td>
    <td>
        <img src="{{ asset('deliverypartner/e-courier.svg') }}" alt="E-Courier" class="courier-icon">
        @lang('E-Courier')
    </td>
    <td>@lang('Barishal Warehouse')</td>
    <td><span class="status-active">@lang('Active')</span></td>
    <td class="actions">
        <button onclick="openModal('eCourierApiModal')" class="btn-api">
            <i class="fas fa-cogs"></i> @lang('API Settings')
        </button>
        <button class="btn-settings">
            <i class="fas fa-tools"></i> @lang('Settings')
        </button>
    </td>
</tr>

            </tbody>
        </table>
    </div>
</div>

<!-- ✅ Include Each Courier's API Modal -->
@include('DeliveryPartner.partials.api.pathao_api')
@include('DeliveryPartner.partials.api.steadfast_api')
@include('DeliveryPartner.partials.api.redx_api')
@include('DeliveryPartner.partials.api.e_courier_api')

<!-- ✅ JavaScript -->
<script>
    // ✅ Open Modal Function
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove("hidden");
        document.body.style.overflow = "hidden"; // Prevents background scrolling
    }

    // ✅ Close Modal Function
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add("hidden");
        document.body.style.overflow = "auto"; // Restores scrolling
    }

    // ✅ Dropdown Toggle
    document.getElementById("btn-add-courier").addEventListener("click", function () {
        document.getElementById("courierDropdown").classList.toggle("hidden");
    });

    // ✅ Close Dropdown on Click Outside
    document.addEventListener("click", function (event) {
        if (!document.getElementById("btn-add-courier").contains(event.target) &&
            !document.getElementById("courierDropdown").contains(event.target)) {
            document.getElementById("courierDropdown").classList.add("hidden");
        }
    });
</script>

@endsection
