@extends('layouts.app')

@section('title', 'Roles Management')

@section('content')

<div class="page-container">
    <!-- ✅ Page Header -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="page-title">User Roles</h1>
        <a href="{{ route('roles.create') }}" class="primary-btn">
            <span class="material-icons">add</span> <span class="btn-text">Add Role</span>
        </a>
    </div>

    <!-- ✅ Entries Dropdown & Search Bar -->
    <div class="flex justify-between items-center mb-4">
        <div class="entries-dropdown flex items-center space-x-2">
            <span class="text-sm text-gray-600">Show</span>
            <select class="entries-select" id="entriesSelect">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
            </select>
            <span class="text-sm text-gray-600">entries</span>
        </div>

        <!-- ✅ Search Bar -->
        <input type="text" name="search" id="searchInput" value="{{ request('search') }}" 
            class="search-input" placeholder="Search roles...">
    </div>

    <!-- ✅ Roles Table (Matching Partials File) -->
    <div id="rolesTableContainer">
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>Role Name</th>
                    <th>Users Assigned</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->users_count }} Users</td>
                    <td class="actions">
                        @if (strtolower($role->name) !== 'admin')
                            <a href="{{ route('roles.edit', $role->id) }}" class="action-btn edit">
                                <span class="material-icons">edit</span> <span class="btn-text">Edit</span>
                            </a>
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete" onclick="return confirm('Are you sure?')">
                                    <span class="material-icons">delete</span> <span class="btn-text">Delete</span>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-gray-500 py-4">No roles found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ✅ Pagination -->
    <div class="flex justify-between items-center text-sm text-gray-600 mt-4">
        <p class="text-xs">
            Showing {{ $roles->firstItem() }} to {{ $roles->lastItem() }} of {{ $roles->total() }} entries
        </p>

        <div class="pagination-controls flex items-center space-x-2">
            @if ($roles->onFirstPage())
                <button class="pagination-btn prev-btn disabled">← Prev</button>
            @else
                <a href="{{ $roles->previousPageUrl() }}" class="pagination-btn prev-btn">← Prev</a>
            @endif
            
            <span class="current-page">{{ $roles->currentPage() }}</span>

            @if ($roles->hasMorePages())
                <a href="{{ $roles->nextPageUrl() }}" class="pagination-btn next-btn">Next →</a>
            @else
                <button class="pagination-btn next-btn disabled">Next →</button>
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let debounceTimer;

        // ✅ Fetch roles via AJAX
        function fetchRoles(url = "{{ route('roles.index') }}") {
            let search = $("#searchInput").val();
            let perPage = $("#entriesSelect").val();

            $.ajax({
                url: url,
                type: "GET",
                data: { search: search, per_page: perPage },
                dataType: "json",
                beforeSend: function () {
                    $("#rolesTableContainer").css({ opacity: "0.5" });
                },
                success: function (response) {
                    if (response.html) {
                        $("#rolesTableContainer").html(response.html);
                    }
                    $("#rolesTableContainer").css({ opacity: "1" });

                    // ✅ Reattach event listeners after AJAX update
                    attachEvents();
                },
                error: function (xhr, status, error) {
                    console.error("❌ AJAX Error:", xhr.responseText);
                    alert("Error fetching roles. Check console for details.");
                }
            });
        }

        // ✅ Live Search with Debounce
        $("#searchInput").on("input", function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(fetchRoles, 300);
        });

        // ✅ Change Entries Per Page
        $("#entriesSelect").on("change", function () {
            fetchRoles();
        });

        // ✅ Handle AJAX Pagination
        $(document).on("click", ".pagination a", function (event) {
            event.preventDefault();
            let url = $(this).attr("href");
            if (url) fetchRoles(url);
        });

        // ✅ Handle Role Deletion
        function attachEvents() {
            $(".delete-btn").off("click").on("click", function () {
                let confirmDelete = confirm('Are you sure you want to delete this role?');
                if (!confirmDelete) return false;
            });
        }

        // ✅ Initial Attach for delete buttons
        attachEvents();
    });
</script>

@endsection
