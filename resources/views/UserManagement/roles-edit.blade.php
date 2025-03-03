@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="page-container">
    <h1 class="text-xl font-bold mb-4">Edit Role</h1>

    @if ($errors->any())
    <div class="bg-red-100 text-red-600 p-2 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-600 p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 text-green-600 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- ✅ Role Edit Form -->
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- ✅ Role Name -->
        <div class="mb-4">
            <label class="block font-semibold mb-1 text-gray-700">* Role Name</label>
            <input type="text" name="name" class="w-full border rounded p-2" required placeholder="Enter Role Name" value="{{ $role->name }}">
        </div>

        <!-- ✅ Permissions Section -->
        <div class="border rounded-lg overflow-hidden">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="p-3 text-left">Features</th>
                        <th class="p-3 text-left">Capabilities</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- ✅ Dashboard Access -->
                    <tr class="border-b">
                        <td class="p-3 font-semibold">Dashboard Access</td>
                        <td class="p-3">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="permissions[]" value="dashboard.view" 
                                    {{ in_array('dashboard.view', $rolePermissions) ? 'checked' : '' }}>
                                Access Dashboard
                            </label>
                        </td>
                    </tr>

                    <!-- ✅ Role Management -->
                    <tr class="border-b">
                        <td class="p-3 font-semibold">Roles Management</td>
                        <td class="p-3 flex flex-wrap gap-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="permissions[]" value="roles.view" 
                                    {{ in_array('roles.view', $rolePermissions) ? 'checked' : '' }}>
                                View Roles
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="permissions[]" value="roles.create" 
                                    {{ in_array('roles.create', $rolePermissions) ? 'checked' : '' }}>
                                Add Role
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="permissions[]" value="roles.edit" 
                                    {{ in_array('roles.edit', $rolePermissions) ? 'checked' : '' }}>
                                Edit Role
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="permissions[]" value="roles.delete" 
                                    {{ in_array('roles.delete', $rolePermissions) ? 'checked' : '' }}>
                                Delete Role
                            </label>
                        </td>
                    </tr>

                    <!-- ✅ User Management -->
                    <tr class="border-b">
                        <td class="p-3 font-semibold">User Management</td>
                        <td class="p-3 flex flex-wrap gap-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="permissions[]" value="users.view" 
                                    {{ in_array('users.view', $rolePermissions) ? 'checked' : '' }}>
                                View Users
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="permissions[]" value="users.create" 
                                    {{ in_array('users.create', $rolePermissions) ? 'checked' : '' }}>
                                Add User
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="permissions[]" value="users.edit" 
                                    {{ in_array('users.edit', $rolePermissions) ? 'checked' : '' }}>
                                Edit User
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="permissions[]" value="users.delete" 
                                    {{ in_array('users.delete', $rolePermissions) ? 'checked' : '' }}>
                                Delete User
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- ✅ Submit Button -->
        <div class="mt-4">
            <button type="submit" class="primary-btn">Update Role</button>
        </div>
    </form>
</div>
@endsection

