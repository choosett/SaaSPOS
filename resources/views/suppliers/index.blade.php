@extends('layouts.app')

@section('title', __('Suppliers'))

<div x-data="{ open: false }" x-init="fetchUsers()">

@section('content')
<div class="max-w-7xl mx-auto p-0"> <!-- Reduced padding from p-6 to p-4 -->

    <!-- ✅ Page Header (Reduced Margin) -->
    <div class="flex justify-between items-center mb-2"> <!-- Reduced mb-4 to mb-2 -->
        <h2 class="text-xl font-bold text-gray-800">@lang('All Suppliers')</h2>
        
        <!-- Include Add Supplier Modal & Pass $users -->
        @include('suppliers.partials._add-supplier-modal', ['users' => $users])
    </div>

    <!-- ✅ Filters Section -->
    @include('suppliers.partials._filters')

    <!-- ✅ Suppliers Table (Spacing Adjusted) -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden mt-3"> <!-- Reduced margin-top -->
        @include('suppliers.partials._suppliers-table')
    </div>

</div>

@endsection
