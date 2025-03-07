@extends('layouts.app')

@section('title', 'Add New Role')

@section('content')
<div class="page-container">
    <h1 class="text-xl font-bold mb-4">Add New Role</h1>

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

    <!-- ✅ Role Creation Form -->
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf

        <!-- ✅ Role Name -->
        <div class="mb-4">
            <label class="block font-semibold mb-1 text-gray-700">* Role Name</label>
            <input type="text" name="name" class="w-full border rounded p-2" required placeholder="Enter Role Name">
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
                                <input type="checkbox" name="permissions[]" value="dashboard.view"> Access Dashboard
                            </label>
                        </td>
                    </tr>

                    <!-- ✅ Role Management Section -->
                    <tr class="border-b">
                        <td class="p-3 font-semibold">Roles Management</td>
                        <td class="p-3 flex flex-wrap gap-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="permissions[]" value="roles.view"> View Roles
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="permissions[]" value="roles.create"> Add Role
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="permissions[]" value="roles.edit"> Edit Role
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="permissions[]" value="roles.delete"> Delete Role
                            </label>
                        </td>
                    </tr>

                    <!-- ✅ User Management -->
                    <tr class="border-b">
                        <td class="p-3 font-semibold">User Management</td>
                        <td class="p-3 flex flex-wrap gap-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="permissions[]" value="users.view"> View Users
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="permissions[]" value="users.create"> Add User
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="permissions[]" value="users.edit"> Edit User
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="permissions[]" value="users.delete"> Delete User
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- ✅ Submit Button -->
        <div class="mt-4">
            <button type="submit" class="primary-btn">Save Role</button>
        </div>
    </form>
</div>
@endsection
