@extends('layouts.app')

@section('title', 'Add New User')

@section('content')

<!-- ✅ Form Container -->
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
<script>
    window.csrfToken = "{{ csrf_token() }}";
    window.checkUsernameRoute = "{{ route('users.checkUsername') }}";
    window.checkEmailRoute = "{{ route('users.checkEmail') }}";
    window.successMessage = "{{ session('success') }}";
</script>

<!-- ✅ Include Latest jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- ✅ Include users.js -->
<script src="{{ asset('js/users.js') }}"></script>
@endsection
