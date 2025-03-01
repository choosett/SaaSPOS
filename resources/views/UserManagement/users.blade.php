@extends('layouts.app')

@section('title', 'Users Management')

@section('content')

<div class="page-container">
    <!-- ✅ Page Header -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="page-title">All Users</h1>
        <a href="{{ route('users.create') }}" class="primary-btn">
            <span class="material-icons">add</span> Add User
        </a>
    </div>

    <!-- ✅ Entries Dropdown & Search Bar -->
    <div class="flex justify-between items-center mb-4">
        <div class="entries-dropdown flex items-center space-x-2">
            <span class="text-sm text-gray-600">Show</span>
            <select class="entries-select" id="entriesSelect">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page', 50) == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page', 100) == 100 ? 'selected' : '' }}>100</option>
            </select>
            <span class="text-sm text-gray-600">entries</span>
        </div>

        <!-- ✅ Search Bar -->
        <div class="relative">
            <input type="text" class="search-input" id="searchInput" placeholder="Search users..." value="{{ request('search') }}">
            <span class="search-icon material-icons">search</span>
        </div>
    </div>

    <!-- ✅ Users Table -->
    <div id="usersTableContainer">
        @include('UserManagement.partials._users-table')
    </div>

</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let debounceTimer;

        function fetchUsers(url = "{{ route('users.index') }}") {
            let search = $("#searchInput").val();
            let perPage = $("#entriesSelect").val();

            $.ajax({
                url: url,
                type: "GET",
                data: { search: search, per_page: perPage },
                beforeSend: function () {
                    $("#usersTableContainer").css({ opacity: "1" });
                },
                success: function (response) {
                    // ✅ Update the table correctly
                    $("#usersTableContainer").html(response.html);
                    $("#usersTableContainer").css({ opacity: "1" });

                    // ✅ Reattach event listeners
                    attachEvents();
                },
                error: function () {
                    alert("❌ Error fetching users. Please try again.");
                }
            });
        }

        // ✅ Live Search
        $("#searchInput").on("input", function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(fetchUsers, 300);
        });

        // ✅ Change Entries Per Page
        $("#entriesSelect").on("change", function () {
            fetchUsers();
        });

        // ✅ Handle AJAX Pagination
        $(document).on("click", ".pagination a", function (event) {
            event.preventDefault();
            let url = $(this).attr("href");
            if (url) fetchUsers(url);
        });

        // ✅ Handle Delete Button Actions
        function attachEvents() {
            $(".delete-btn").off("click").on("click", function () {
                let confirmDelete = confirm('Are you sure you want to delete this user?');
                if (!confirmDelete) return false;
            });
        }

        // ✅ Initial Attach
        attachEvents();
    });
</script>

@endsection
