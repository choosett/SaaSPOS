@extends('layouts.app')

@section('title', 'Roles Management')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="page-container">
    <!-- ✅ Page Header -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold text-gray-800">All Roles</h1>
        
        <!-- ✅ Add Role Button -->
        <a href="{{ route('roles.create') }}" 
           class="bg-[#017e84] text-white px-4 py-2 rounded-md flex items-center gap-2 hover:bg-[#015a5e] transition duration-300 shadow-md">
            <span class="material-icons">add</span> Add Role
        </a>
    </div>

    <script>
        let roleIndexRoute = "{{ route('roles.index') }}";
    </script>

    <!-- ✅ Entries Dropdown & Search Bar -->
    <div class="bg-white shadow-lg rounded-lg p-4 mb-6 flex flex-wrap justify-between items-center">
        
        <!-- ✅ Entries Dropdown -->
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-600">Show</span>
            <select class="border border-gray-300 rounded-lg px-3 py-1.5 shadow-md focus:ring focus:ring-[#017e84] w-20" id="entriesSelect">
                <option value="5" {{ request('per_page', 5) == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
            </select>
            <span class="text-sm text-gray-600">entries</span>
        </div>

        <!-- ✅ Search Bar -->
        <div class="relative">
            <input type="text" 
                   class="border border-gray-300 focus:ring-[#017e84] focus:border-[#017e84] rounded-lg text-sm px-5 py-3 shadow-sm w-72" 
                   id="searchInput" 
                   placeholder="Search roles..." 
                   value="{{ request('search') }}">
            <span class="absolute right-3 top-3 text-[#017e84] material-icons">search</span>
        </div>
    </div>

    <!-- ✅ AJAX Loaded Table -->
    <div id="rolesTableContainer" data-fetch-url="{{ route('roles.index') }}">
        @include('UserManagement.partials.roles-table')
    </div>
</div>

@endsection
