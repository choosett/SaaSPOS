@extends('layouts.app')

@section('title', 'Users Management')

@section('content')

<div class="page-container">
    <!-- ✅ Page Header -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="page-title">All Users</h1>
        <button class="primary-btn">
            <span class="material-icons">add</span> Add User
        </button>
    </div>

   <!-- ✅ Entries Dropdown & Search Bar -->
<div class="flex justify-between items-center mb-4">
    <!-- Entries Dropdown -->
    <div class="entries-dropdown flex items-center space-x-2">
        <span class="text-sm text-gray-600">Show</span>
        <select class="entries-select">
            <option value="10">10</option>
            <option value="25" selected>25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <span class="text-sm text-gray-600">entries</span>
    </div>

    <!-- Search Bar -->
    <div class="relative">
        <input type="text" class="search-input" placeholder="Search...">
        <span class="search-icon material-icons">search</span>
    </div>
</div>


    <!-- ✅ Users Table -->
    <div class="table-container">
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Last Login</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>user1</td>
                    <td class="font-semibold">User 1</td>
                    <td>Cashier</td>
                    <td>user1@example.com</td>
                    <td><span class="status-badge inactive">Inactive</span></td>
                    <td>2025-02-24</td>
                    <td>2025-02-25 15:46</td>
                    <td class="actions">
                        <button class="action-btn edit"><span class="material-icons">edit</span> <span class="btn-text">Edit</span></button>
                        <button class="action-btn view"><span class="material-icons">visibility</span> <span class="btn-text">View</span></button>
                        <button class="action-btn delete"><span class="material-icons">delete</span> <span class="btn-text">Delete</span></button>
                    </td>
                </tr>
                <tr>
                    <td>user2</td>
                    <td class="font-semibold">User 2</td>
                    <td>Admin</td>
                    <td>user2@example.com</td>
                    <td><span class="status-badge active">Active</span></td>
                    <td>2025-02-23</td>
                    <td>2025-02-25 12:46</td>
                    <td class="actions">
                        <button class="action-btn edit"><span class="material-icons">edit</span> <span class="btn-text">Edit</span></button>
                        <button class="action-btn view"><span class="material-icons">visibility</span> <span class="btn-text">View</span></button>
                        <button class="action-btn delete"><span class="material-icons">delete</span> <span class="btn-text">Delete</span></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

<!-- ✅ Pagination -->
<div class="pagination-container flex justify-between items-center text-xs text-gray-600 mt-4">
    <p class="text-xs">Showing 1 to 10 of 50 entries</p>
    <div class="pagination-controls flex items-center space-x-2">
        <button class="pagination-btn prev-btn">← Prev</button>
        <span class="current-page">1</span>
        <button class="pagination-btn next-btn">Next →</button>
    </div>
</div>


@endsection
