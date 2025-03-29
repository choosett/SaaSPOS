<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Tailwind CSS -->
    @vite(['resources/css/auth.css', 'resources/js/auth.js'])
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">

    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Create an Account</h2>

        <!-- Error Message -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- First Name -->
            <div class="mb-4">
                <label class="block font-medium text-gray-700">First Name*</label>
                <input type="text" name="first_name" class="auth-input" value="{{ old('first_name') }}" required>
            </div>

            <!-- Last Name -->
            <div class="mb-4">
                <label class="block font-medium text-gray-700">Last Name*</label>
                <input type="text" name="last_name" class="auth-input" value="{{ old('last_name') }}" required>
            </div>

            <!-- Username -->
            <div class="mb-4">
                <label class="block font-medium text-gray-700">Username*</label>
                <input type="text" name="username" class="auth-input" value="{{ old('username') }}" required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block font-medium text-gray-700">Email*</label>
                <input type="email" name="email" class="auth-input" value="{{ old('email') }}" required>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block font-medium text-gray-700">Password*</label>
                <input type="password" name="password" class="auth-input" required>
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label class="block font-medium text-gray-700">Confirm Password*</label>
                <input type="password" name="password_confirmation" class="auth-input" required>
            </div>

            <!-- Register Button -->
            <button type="submit" class="w-full auth-button">Register</button>
        </form>

        <!-- Already Registered -->
        <p class="mt-4 text-sm text-center">
            Already have an account? <a href="{{ route('login') }}" class="text-blue-500">Sign in</a>
        </p>
    </div>

</body>
</html>
