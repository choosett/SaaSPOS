@extends('layouts.app')

@section('title', 'Add New User')

@section('content')

<!-- ✅ Form Container: Aligned with Header -->
<div class="flex justify-center items-start min-h-screen mt-0 pt-0">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-3xl"> 
        <h1 class="text-2xl font-bold mb-6 text-center text-[#0E3EA8]">Add New User</h1>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <!-- ✅ Two-Column Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- ✅ First Column -->
                <div class="space-y-4">
                    <div>
                        <label class="form-label">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" class="form-input" required>
                    </div>

                    <div>
                        <label class="form-label">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="emailInput" class="form-input" required>
                        <p id="emailAvailability" class="text-sm mt-1"></p>
                    </div>

                    <div>
                        <label class="form-label">Username <span class="text-red-500">*</span></label>
                        <div class="flex items-center">
                            <input type="text" name="username" id="usernameInput" class="form-input flex-1" required>
                            <span class="ml-2 text-gray-600" id="generatedUsername"></span>
                        </div>
                        <p class="text-sm mt-1" id="usernameAvailability"></p>
                    </div>

                    <div>
                        <label class="form-label">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" id="confirmPasswordInput" class="form-input" required>
                        <p id="passwordMatchMessage" class="text-sm mt-1"></p>
                    </div>
                </div>

                <!-- ✅ Second Column -->
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-input">
                    </div>

                    <div>
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-input">
                    </div>

                    <div>
                        <label class="form-label">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" id="passwordInput" class="form-input" required>
                    </div>

                    <div>
                        <label class="form-label">Role <span class="text-red-500">*</span></label>
                        <select name="role" class="form-input" required>
                            <option value="" disabled selected>Select a role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <!-- ✅ Submit Button -->
            <button type="submit" id="submitButton" class="primary-btn w-full mt-6" disabled>Create User</button>
        </form>
    </div>
</div>

@endsection



@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {

        // ✅ Live Username Availability Check
        $("#usernameInput").on("input", function () {
            let username = $(this).val().trim();
            if (username.length < 3) {
                $("#usernameAvailability").text("").removeClass("text-green-500 text-red-500");
                return;
            }

            $.ajax({
                url: "{{ route('users.checkUsername') }}",
                type: "GET",
                data: { username: username },
                success: function (response) {
                    if (response.available) {
                        $("#usernameAvailability").text("✅ Username available").addClass("text-green-500").removeClass("text-red-500");
                        $("#generatedUsername").text(response.suggested_username);
                    } else {
                        $("#usernameAvailability").text("❌ Username already taken").addClass("text-red-500").removeClass("text-green-500");
                        $("#generatedUsername").text("");
                    }
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
                url: "{{ route('users.checkEmail') }}",
                type: "GET",
                data: { email: email },
                success: function (response) {
                    if (response.available) {
                        $("#emailAvailability").text("✅ Email available").addClass("text-green-500").removeClass("text-red-500");
                    } else {
                        $("#emailAvailability").text("❌ Email already in use").addClass("text-red-500").removeClass("text-green-500");
                    }
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

    });
</script>
@endsection
