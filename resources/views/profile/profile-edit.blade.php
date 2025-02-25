@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<div class="profile-edit-container">
    <!-- ✅ Tab Navigation -->
    <div class="tabs">
        <button id="tabInfo" class="tab active">Update Information</button>
        <button id="tabPassword" class="tab">Change Password</button>
    </div>

    <!-- ✅ Section 1: Update Information -->
    <div id="infoSection" class="tab-content">
        <form action="#" method="POST">
            <div class="grid grid-cols-1 gap-5">
                <div>
                    <label class="form-label">First Name</label>
                    <input type="text" value="John" class="form-input">
                </div>
                <div>
                    <label class="form-label">Last Name</label>
                    <input type="text" value="Doe" class="form-input">
                </div>
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" value="admin@test.com" class="form-input">
                </div>
            </div>
            <button type="submit" class="primary-btn full-width mt-5">Update Profile</button>
        </form>
    </div>

    <!-- ✅ Section 2: Change Password -->
    <div id="passwordSection" class="tab-content hidden">
        <form action="#" method="POST">
            <div class="grid grid-cols-1 gap-5">
                <div>
                    <label class="form-label">Current Password</label>
                    <input type="password" class="form-input">
                </div>
                <div>
                    <label class="form-label">New Password</label>
                    <input type="password" class="form-input">
                </div>
                <div>
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" class="form-input">
                </div>
            </div>
            <button type="submit" class="primary-btn full-width mt-5">Update Password</button>
        </form>
    </div>
</div>

<!-- ✅ Tab Switching Logic -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabInfo = document.getElementById("tabInfo");
        const tabPassword = document.getElementById("tabPassword");
        const infoSection = document.getElementById("infoSection");
        const passwordSection = document.getElementById("passwordSection");

        tabInfo.addEventListener("click", function () {
            tabInfo.classList.add("active");
            tabPassword.classList.remove("active");
            infoSection.classList.remove("hidden");
            passwordSection.classList.add("hidden");
        });

        tabPassword.addEventListener("click", function () {
            tabPassword.classList.add("active");
            tabInfo.classList.remove("active");
            passwordSection.classList.remove("hidden");
            infoSection.classList.add("hidden");
        });
    });
</script>

@endsection
