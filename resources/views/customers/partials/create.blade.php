@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">🛍️ Add New Customer</h3>

        @include('customers.partials._add-customer')
    </div>
@endsection
