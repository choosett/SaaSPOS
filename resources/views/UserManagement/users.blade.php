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
            dataType: "json", // Expecting a JSON response with 'html' key
            beforeSend: function () {
                console.log("🔄 Fetching users...");
                $("#usersTableContainer").css({ opacity: "0.5" });
            },
            success: function (response) {
                console.log("✅ AJAX Success:", response);

                if (response.html) {
                    $("#usersTableContainer").html(response.html);
                } else {
                    console.error("❌ No HTML received in response.");
                }

                $("#usersTableContainer").css({ opacity: "1" });

                // ✅ Reattach event listeners after content updates
                attachEvents();
            },
            error: function (xhr, status, error) {
                console.error("❌ AJAX Error:", xhr.responseText);
                alert("Error fetching users. Check console for details.");
            }
        });
    }

    // ✅ Live Search (Debounced)
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

    // ✅ Handle Delete Button Actions (AJAX)
    function attachEvents() {
        $(".delete-btn").off("click").on("click", function (event) {
            event.preventDefault();

            let deleteUrl = $(this).data("url"); // Get delete URL from button
            if (!deleteUrl) {
                console.error("❌ Delete URL missing.");
                return;
            }

            let confirmDelete = confirm("Are you sure you want to delete this user?");
            if (!confirmDelete) return;

            $.ajax({
                url: deleteUrl,
                type: "POST",
                data: {
                    _method: "DELETE", // Laravel requires DELETE method
                    _token: "{{ csrf_token() }}" // CSRF Token for security
                },
                beforeSend: function () {
                    console.log("🗑 Deleting user...");
                },
                success: function (response) {
                    alert("✅ User deleted successfully!");
                    fetchUsers(); // Refresh user table
                },
                error: function (xhr) {
                    console.error("❌ Delete Error:", xhr.responseText);
                    alert("❌ Error deleting user. Check console for details.");
                }
            });
        });
    }

  // ✅ Handle Delete Button Actions (AJAX with Toastr)
  function attachEvents() {
        $(".delete-btn").off("click").on("click", function (event) {
            event.preventDefault();

            let deleteUrl = $(this).data("url"); // Get delete URL from button
            if (!deleteUrl) {
                console.error("❌ Delete URL missing.");
                return;
            }

            let confirmDelete = confirm("Are you sure you want to delete this user?");
            if (!confirmDelete) return;

            $.ajax({
                url: deleteUrl,
                type: "POST",
                data: {
                    _method: "DELETE",
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function () {
                    console.log("🗑 Deleting user...");
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.success, "Success", {
                            positionClass: "toast-top-right",
                            timeOut: 3000,
                            progressBar: true,
                            closeButton: true,
                        });
                        fetchUsers(); // Refresh user table
                    } else {
                        toastr.error("❌ Failed to delete user", "Error");
                    }
                },
                error: function (xhr) {
                    console.error("❌ Delete Error:", xhr.responseText);
                    toastr.error("❌ Error deleting user. Check console for details.", "Error");
                }
            });
        });
    }



    // ✅ Initial Attach
    attachEvents();
});
</script>
@endsection
