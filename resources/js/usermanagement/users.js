// users.js - This script is for the Add User page, Edit User page & Users List

$(document).ready(function () {

    let debounceTimer;
    let csrfToken = $('meta[name="csrf-token"]').attr("content");

    // ✅ Check if users table exists before setting userIndexRoute
    let userIndexRoute = $("#usersTableContainer").length > 0 ? $("#usersTableContainer").data("fetch-url") : null;

    // ✅ Ensure Default Entries is Set to 5 for Users Table
    if ($("#usersTableContainer").length > 0 && !localStorage.getItem("perPage")) {
        localStorage.setItem("perPage", "5");
        $("#entriesSelect").val(localStorage.getItem("perPage"));
    }

    // ✅ Live Username Availability Check
    $("#usernameInput").on("input", function () {
        let username = $(this).val().trim();
        if (username.length < 3) {
            $("#usernameAvailability").text("").removeClass("text-green-500 text-red-500");
            return;
        }

        $.ajax({
            url: window.checkUsernameRoute, 
            type: "GET",
            data: { username: username },
            dataType: "json",
            success: function (response) {
                if (response.available) {
                    $("#usernameAvailability").text("✅ Username available").addClass("text-green-500").removeClass("text-red-500");
                    $("#generatedUsername").text(response.suggested_username || "");
                } else {
                    $("#usernameAvailability").text("❌ Username already taken").addClass("text-red-500").removeClass("text-green-500");
                    $("#generatedUsername").text("");
                }
            },
            error: function () {
                $("#usernameAvailability").text("⚠️ Error checking username").addClass("text-yellow-500").removeClass("text-green-500 text-red-500");
            }
        });
    });

    // ✅ Live Email Availability Check
    $("#emailInput").on("input", function () {
        let email = $(this).val().trim();
        if (!email.includes("@") || email.length < 5) {
            $("#emailAvailability").text("").removeClass("text-green-500 text-red-500");
            return;
        }

        $.ajax({
            url: window.checkEmailRoute,
            type: "GET",
            data: { email: email },
            dataType: "json",
            success: function (response) {
                if (response.available) {
                    $("#emailAvailability").text("✅ Email available").addClass("text-green-500").removeClass("text-red-500");
                } else {
                    $("#emailAvailability").text("❌ Email already in use").addClass("text-red-500").removeClass("text-green-500");
                }
            },
            error: function () {
                $("#emailAvailability").text("⚠️ Error checking email").addClass("text-yellow-500").removeClass("text-green-500 text-red-500");
            }
        });
    });

    // ✅ Live Password Match Check
    $("#passwordInput, #confirmPasswordInput").on("input", function () {
        let password = $("#passwordInput").val();
        let confirmPassword = $("#confirmPasswordInput").val();
        let message = $("#passwordMatchMessage");
        let submitButton = $("#submitButton");

        if (password.length >= 6 && confirmPassword.length >= 6) {
            if (password === confirmPassword) {
                message.text("✅ Passwords match").addClass("text-green-500").removeClass("text-red-500");
                submitButton.prop("disabled", false);
            } else {
                message.text("❌ Passwords do not match").addClass("text-red-500").removeClass("text-green-500");
                submitButton.prop("disabled", true);
            }
        } else {
            message.text("");
            submitButton.prop("disabled", true);
        }
    });

    // ✅ Toastr Success Notification
    if (typeof window.successMessage !== "undefined" && window.successMessage) {
        toastr.success(window.successMessage, "Success", {
            positionClass: "toast-top-right",
            timeOut: 3000,
            progressBar: true,
            closeButton: true,
        });
    }

    // ✅ Fetch Users List with AJAX (Only if Users List Table Exists)
    function fetchUsers(url = userIndexRoute) {
        if (!userIndexRoute) {
            console.warn("❌ fetchUsers() called on a page without users table.");
            return;
        }

        let search = $("#searchInput").val();
        let perPage = $("#entriesSelect").val();
        let params = new URLSearchParams(window.location.search);
        let page = params.get("page") || 1;

        $.ajax({
            url: url,
            type: "GET",
            data: { search: search, per_page: perPage, page: page },
            dataType: "json",
            beforeSend: function () {
                $("#usersTableContainer").css({ opacity: "1" });
            },
            success: function (response) {
                if (response.html) {
                    $("#usersTableContainer").html(response.html);
                    attachPaginationEvents();
                    attachDeleteEvents(); // ✅ Re-attach Delete Events after Refresh
                } else {
                    console.error("❌ No data received from server.");
                }
                $("#usersTableContainer").css({ opacity: "1" });
            },
            error: function (xhr) {
                console.error("❌ AJAX Error:", xhr.status, xhr.statusText);
                console.error("❌ Response:", xhr.responseText);
            }
        });
    }

    // ✅ Attach AJAX Delete Functionality
    function attachDeleteEvents() {
        $(".delete-btn").off("click").on("click", function (event) {
            event.preventDefault();

            let deleteUrl = $(this).data("url");
            if (!deleteUrl) {
                toastr.error("❌ Delete URL is missing.", "Error");
                return;
            }

            if (!confirm("Are you sure you want to delete this user?")) return;

            $.ajax({
                url: deleteUrl,
                type: "POST",
                data: { _method: "DELETE", _token: csrfToken },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.success, "User Deleted");
                        fetchUsers(); // ✅ Refresh User List After Deletion
                    } else {
                        toastr.error("❌ Failed to delete user", "Error");
                    }
                },
                error: function (xhr) {
                    toastr.error("❌ Error deleting user. Check console.", "Error");
                    console.error("❌ Delete Error:", xhr.responseText);
                }
            });
        });
    }

    // ✅ Attach AJAX Pagination Events
    function attachPaginationEvents() {
        $(document).off("click", ".pagination a").on("click", ".pagination a", function (event) {
            event.preventDefault();
            let url = $(this).attr("href");

            if (url) {
                fetchUsers(url);
                window.history.pushState(null, "", url);
            }
        });
    }

    // ✅ Debounced Live Search
    $("#searchInput").on("input", function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchUsers, 300);
    });

    // ✅ Change Entries Per Page
    $("#entriesSelect").on("change", function () {
        fetchUsers();
    });

    // ✅ Ensure Everything Works on Page Load
    if ($("#usersTableContainer").length > 0) {
        fetchUsers();
    }
});

// ✅ Ensure jQuery is Always Up-to-Date
(function () {
    let script = document.createElement("script");
    script.src = "https://code.jquery.com/jquery-3.7.1.min.js";
    script.crossOrigin = "anonymous";
    script.onload = function () {
        console.log("✅ jQuery 3.7.1 loaded successfully.");
    };
    document.head.appendChild(script);
})();
