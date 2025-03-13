// roles.js - Role Management Script
$(document).ready(function () {
    let debounceTimer;
    let csrfToken = $('meta[name="csrf-token"]').attr("content");

    // ✅ Check if roles table exists before setting roleIndexRoute
    let roleIndexRoute = $("#rolesTableContainer").data("fetch-url") || roleIndexRoute;


    // ✅ Ensure Default Entries is Set to 5 for Roles Table
    if (!localStorage.getItem("perPage")) {
        localStorage.setItem("perPage", "5");
    }
    $("#entriesSelect").val(localStorage.getItem("perPage"));

    // ✅ Fetch Roles List with AJAX
    function fetchRoles(url = roleIndexRoute) {
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
                    attachPaginationEvents();
                    attachDeleteEvents();
                } else {
                    console.error("❌ No data received from server.");
                }
                $("#rolesTableContainer").css({ opacity: "1" });
            },
            error: function (xhr) {
                console.error("❌ AJAX Error:", xhr.status, xhr.statusText);
                console.error("❌ Response:", xhr.responseText);
                alert("Error fetching roles. Check console for details.");
            }
        });
    }

    // ✅ Attach AJAX Pagination Events
    function attachPaginationEvents() {
        $(document).off("click", ".pagination-link").on("click", ".pagination-link", function (event) {
            event.preventDefault();
            let url = $(this).attr("href");

            if (url) {
                fetchRoles(url);
                window.history.pushState(null, "", url);
            }
        });
    }

    // ✅ Debounced Live Search
    $("#searchInput").on("input", function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchRoles, 300);
    });

    // ✅ Change Entries Per Page
    $("#entriesSelect").on("change", function () {
        localStorage.setItem("perPage", $(this).val()); // Store selection
        fetchRoles();
    });

    // ✅ Attach Delete Events
    function attachDeleteEvents() {
        $(".delete-btn").off("click").on("click", function (event) {
            event.preventDefault();

            let deleteUrl = $(this).data("url");
            if (!deleteUrl) {
                toastr.error("❌ Delete URL is missing.", "Error");
                return;
            }

            if (!confirm("Are you sure you want to delete this role?")) return;

            $.ajax({
                url: deleteUrl,
                type: "POST",
                data: { _method: "DELETE", _token: csrfToken },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.success, "Success");
                        fetchRoles();
                    } else {
                        toastr.error("❌ Failed to delete role", "Error");
                    }
                },
                error: function (xhr) {
                    console.error("❌ Delete Error:", xhr.responseText);
                }
            });
        });
    }

    // ✅ Ensure Everything Works on Page Load
    if ($("#rolesTableContainer").length > 0) {
        fetchRoles();
    }
});
