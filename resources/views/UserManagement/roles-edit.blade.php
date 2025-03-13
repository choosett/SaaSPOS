@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')

<div class="page-container">
    <!-- ✅ Page Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Edit Role</h1>
        
        <!-- ✅ Back to Roles Button -->
        <a href="{{ route('roles.index') }}" 
           class="bg-[#017e84] text-white px-5 py-2 rounded-md flex items-center gap-2 hover:bg-[#015a5e] transition duration-300 shadow-md">
            <span class="material-icons">arrow_back</span> Back to Roles
        </a>
    </div>

    <!-- ✅ Alerts & Notifications -->
    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-3 rounded-lg mb-4 shadow-md">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-600 p-3 rounded-lg mb-4 shadow-md">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 text-green-600 p-3 rounded-lg mb-4 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    <!-- ✅ Role Edit Form -->
    <div class="bg-white shadow-lg rounded-lg p-6">
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- ✅ Role Name -->
            <div class="mb-6">
                <label class="block font-semibold mb-2 text-gray-700">* Role Name</label>
                <input type="text" name="name" class="border border-gray-300 w-full rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-[#017e84]" required placeholder="Enter Role Name" value="{{ $role->name }}">
            </div>

            <!-- ✅ Permissions Section -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 shadow-md">
                <h2 class="text-lg font-semibold mb-4 text-gray-700">Assign Permissions</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <!-- ✅ Dashboard Access -->
                    <div class="p-4 bg-white shadow-md rounded-lg">
                        <h3 class="font-semibold text-gray-800 mb-3 flex justify-between">
                            Dashboard Access
                            <label class="text-[#017e84] font-medium cursor-pointer">
                                <input type="checkbox" class="custom-checkbox select-all-module" data-module="dashboard"> Select All
                            </label>
                        </h3>
                        <label class="flex items-center gap-3">
                            <input type="checkbox" name="permissions[]" value="dashboard.view" class="custom-checkbox permission-checkbox dashboard"
                            {{ in_array('dashboard.view', $rolePermissions) ? 'checked' : '' }}>
                            <span class="text-gray-700 text-sm">Access Dashboard</span>
                        </label>
                    </div>

                    <!-- ✅ Role Management -->
                    <div class="p-4 bg-white shadow-md rounded-lg">
                        <h3 class="font-semibold text-gray-800 mb-3 flex justify-between">
                            Roles Management
                            <label class="text-[#017e84] font-medium cursor-pointer">
                                <input type="checkbox" class="custom-checkbox select-all-module" data-module="roles"> Select All
                            </label>
                        </h3>
                        <div class="space-y-2">
                            @foreach(['roles.view' => 'View Roles', 'roles.create' => 'Add Role', 'roles.edit' => 'Edit Role', 'roles.delete' => 'Delete Role'] as $value => $label)
                                <label class="flex items-center gap-3">
                                    <input type="checkbox" name="permissions[]" value="{{ $value }}" class="custom-checkbox permission-checkbox roles"
                                    {{ in_array($value, $rolePermissions) ? 'checked' : '' }}>
                                    <span class="text-gray-700 text-sm">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- ✅ User Management -->
                    <div class="p-4 bg-white shadow-md rounded-lg">
                        <h3 class="font-semibold text-gray-800 mb-3 flex justify-between">
                            User Management
                            <label class="text-[#017e84] font-medium cursor-pointer">
                                <input type="checkbox" class="custom-checkbox select-all-module" data-module="users"> Select All
                            </label>
                        </h3>
                        <div class="space-y-2">
                            @foreach(['users.view' => 'View Users', 'users.create' => 'Add User', 'users.edit' => 'Edit User', 'users.delete' => 'Delete User'] as $value => $label)
                                <label class="flex items-center gap-3">
                                    <input type="checkbox" name="permissions[]" value="{{ $value }}" class="custom-checkbox permission-checkbox users"
                                    {{ in_array($value, $rolePermissions) ? 'checked' : '' }}>
                                    <span class="text-gray-700 text-sm">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- ✅ Submit Button -->
            <div class="mt-6 text-right">
                <button type="submit" class="bg-[#017e84] text-white px-6 py-2 rounded-md shadow-md hover:bg-[#015a5e] transition duration-300">
                    Update Role
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectAllCheckboxes = document.querySelectorAll(".select-all-module");

        selectAllCheckboxes.forEach(selectAll => {
            selectAll.addEventListener("change", function () {
                let module = this.dataset.module;
                let checkboxes = document.querySelectorAll(`.permission-checkbox.${module}`);
                
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        });
    });
</script>
@endsection
