@extends('layouts.app')

@section('title', __('Courier List'))

@section('content')

<!-- ✅ FontAwesome Free Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<div class="max-w-7xl mx-auto p-4">
    <!-- ✅ Page Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">@lang('Courier List')</h2>

        <!-- ✅ Add Courier Button with Dropdown -->
        <div class="relative">
            <button id="btn-add-courier" class="btn-add-courier">
                <i class="fas fa-plus"></i>
                <span>@lang('Add Courier')</span>
            </button>

            <div id="courierDropdown" class="dropdown-menu hidden">
                <ul>
                    @foreach (['pathao', 'steadfast', 'redx', 'ecourier'] as $courier)
                        <li onclick="openModal('{{ $courier }}ApiModal')">
                            <img src="{{ asset('deliverypartner/' . $courier . '.svg') }}" 
                                 alt="{{ ucfirst($courier) }}">
                            @lang(ucfirst($courier))
                        </li>
                    @endforeach
                    <li class="disabled">
                        <i class="fas fa-truck"></i> @lang('New Courier')
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- ✅ Courier Table with Mobile Scrolling -->
    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="table-custom min-w-max w-full">
            <thead>
                <tr>
                    <th>@lang('Courier ID')</th>
                    <th>@lang('Name')</th>
                    <th class="text-center">@lang('Status')</th>
                    <th class="text-center action-header">@lang('Actions')</th>
                </tr>
            </thead>
            <tbody>
                @foreach (['pathao', 'steadfast', 'redx', 'ecourier'] as $index => $courier)
                    <tr>
                        <td><span class="courier-id {{ $courier }}">C-100{{ $index + 1 }}</span></td>
                        <td>
                            <img src="{{ asset('deliverypartner/' . $courier . '.svg') }}" 
                                 alt="{{ ucfirst($courier) }}" class="courier-icon">
                            @lang(ucfirst($courier))
                        </td>
                        <td class="text-center">
                            <label class="switch">
                                <input type="checkbox" {{ $index !== 2 ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td class="actions">
                            <button onclick="openModal('{{ $courier }}ApiModal')" class="btn btn-api">
                                <i class="fas fa-cogs"></i> @lang('API')
                            </button>
                            <a href="{{ route('delivery.settings.' . $courier) }}" class="btn btn-settings">
                                <i class="fas fa-tools"></i> @lang('Settings')
                            </a>
                            <button class="btn btn-view">
                                <i class="fas fa-eye"></i> @lang('View')
                            </button>
                            <button class="btn btn-delete">
                                <i class="fas fa-trash"></i> @lang('Delete')
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- ✅ Modals for Each Courier -->
@include('DeliveryPartner.partials.api.pathao_api')
@include('DeliveryPartner.partials.api.steadfast_api')
@include('DeliveryPartner.partials.api.redx_api')
@include('DeliveryPartner.partials.api.ecourier_api') <!-- ✅ FIXED: Changed to ecourier -->

<!-- ✅ JavaScript -->
<script>
    function openModal(modalId) {
        let modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove("hidden");
            document.body.style.overflow = "hidden";
        } else {
            console.error("Modal ID not found:", modalId);
        }
    }

    function closeModal(modalId) {
        let modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add("hidden");
            document.body.style.overflow = "auto";
        }
    }

    document.getElementById("btn-add-courier").addEventListener("click", function () {
        document.getElementById("courierDropdown").classList.toggle("hidden");
    });

    document.addEventListener("click", function (event) {
        let addCourierBtn = document.getElementById("btn-add-courier");
        let dropdown = document.getElementById("courierDropdown");

        if (!addCourierBtn.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add("hidden");
        }
    });
</script>

@endsection