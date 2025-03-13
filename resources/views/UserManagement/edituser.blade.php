@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- ✅ Form Container -->
<div class="flex justify-center items-start min-h-screen mt-0 pt-0">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-3xl"> 
        <h1 class="text-2xl font-bold mb-6 text-center text-[#017e84]">Edit User</h1>

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
            <button type="submit" id="submitButton" class="bg-[#017e84] text-white px-6 py-2 rounded-md shadow-md hover:bg-[#015a5e] transition w-full mt-6">
                Update User
            </button>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    window.csrfToken = "{{ csrf_token() }}";
    window.userIndexRoute = "{{ route('users.index') }}"; // ✅ Users List Page
    window.userEditRoute = "{{ route('users.update', $editingUser->id) }}"; // ✅ Edit User Route
    window.checkUsernameRoute = "{{ route('users.checkUsername') }}";
    window.checkEmailRoute = "{{ route('users.checkEmail') }}";
    window.successMessage = "{{ session('success') }}";
</script>

<!-- ✅ Fix jQuery Integrity Issue -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- ✅ Include users.js -->
<script src="{{ asset('js/users.js') }}"></script>
@endsection
