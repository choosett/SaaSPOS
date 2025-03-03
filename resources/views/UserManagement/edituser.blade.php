@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<!-- ✅ Form Container -->
<div class="flex justify-center items-start min-h-screen mt-0 pt-0">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-3xl"> 
        <h1 class="text-2xl font-bold mb-6 text-center text-[#0E3EA8]">Edit User</h1>

        <!-- ✅ Show Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update', $editingUser->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- ✅ Two-Column Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- ✅ First Column -->
                <div class="space-y-4">
                    <div>
                        <label class="form-label">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" class="form-input" required 
                               value="{{ old('first_name', $editingUser->first_name) }}">
                    </div>

                    <div>
                        <label class="form-label">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="emailInput" class="form-input" required 
                               value="{{ old('email', $editingUser->email) }}">
                        <p id="emailAvailability" class="text-sm mt-1"></p>
                    </div>

                    <div>
                        <label class="form-label">Username <span class="text-red-500">*</span></label>
                        <div class="flex items-center">
                            <input type="text" name="username" id="usernameInput" class="form-input flex-1" required 
                                   value="{{ old('username', $editingUser->username) }}">
                            <span class="ml-2 text-gray-600" id="generatedUsername"></span>
                        </div>
                        <p class="text-sm mt-1" id="usernameAvailability"></p>
                    </div>

                    <div>
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="confirmPasswordInput" class="form-input">
                        <p id="passwordMatchMessage" class="text-sm mt-1"></p>
                    </div>
                </div>

                <!-- ✅ Second Column -->
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-input" 
                               value="{{ old('last_name', $editingUser->last_name) }}">
                    </div>

                    <div>
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-input" 
                               value="{{ old('phone', $editingUser->phone) }}">
                    </div>

                    <div>
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" id="passwordInput" class="form-input">
                    </div>

                    <div>
                        <label class="form-label">Role <span class="text-red-500">*</span></label>
                        <select name="role" class="form-input" required>
                            <option value="" disabled>Select a role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" 
                                    {{ $editingUser->roles->pluck('name')->contains($role->name) ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <!-- ✅ Submit Button -->
            <button type="submit" id="submitButton" class="primary-btn w-full mt-6">Update User</button>
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
                    } else {
                        $("#usernameAvailability").text("❌ Username already taken").addClass("text-red-500").removeClass("text-green-500");
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

            if (password !== "" || confirmPassword !== "") {
                if (password === confirmPassword) {
                    message.text("✅ Passwords match").addClass("text-green-500").removeClass("text-red-500");
                } else {
                    message.text("❌ Passwords do not match").addClass("text-red-500").removeClass("text-green-500");
                }
            } else {
                message.text("");
            }
        });

        // ✅ Toastr Success Notification
        @if(session('success'))
            toastr.success("{{ session('success') }}", "Success", {
                positionClass: "toast-top-right",
                timeOut: 3000,
                progressBar: true,
                closeButton: true,
            });
        @endif

    });
</script>
@endsection
