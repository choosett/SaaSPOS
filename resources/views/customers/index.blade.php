@extends('layouts.app')

@section('title', __('Customers'))

@section('content')
<div class="max-w-7xl mx-auto p-0">

    <!-- ✅ Page Header -->
    <div class="flex justify-between items-center mb-6">
        

        <!-- Include Add Customer Modal -->
        @include('customers.partials._add-customer')
    </div>

    <!-- ✅ Filter Section -->
    <div class="bg-[#F8F8F8] shadow-md rounded-lg p-5 mb-6">
        @include('customers.partials._filters')
    </div>

    <!-- ✅ Customer Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        @include('customers.partials._customer-table')
    </div>




</div>
@endsection
