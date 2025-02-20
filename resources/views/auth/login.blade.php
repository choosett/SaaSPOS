@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="mode-toggle">
    <span id="mode-text">Day Mode</span>
    <label class="switch">
        <input type="checkbox" id="mode-toggle">
        <span class="slider round"></span>
    </label>
</div>

<div class="login-container"> 
    <h2 class="pos-title">Welcome Back</h2>
    <p class="pos-slogan">Login to your GoCreative ERP</p>

    @if(session('error'))
        <div class="error-message text-red-500 bg-red-100 p-2 rounded mb-3">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email or Username Field with Error Handling -->
        <div class="form-group">
            <div class="auth-input-wrapper">
                <i class="fas fa-user"></i>
                <input type="text" id="email_or_username" name="email_or_username" class="auth-input pl-10" placeholder="Email or Username" value="{{ old('email_or_username') }}" required autofocus>
            </div>
            @error('email_or_username')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password Field with Show/Hide Feature -->
        <div class="form-group">
            <div class="auth-input-wrapper relative">
                <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="password" id="password" name="password" class="auth-input pl-10 pr-10" placeholder="Password" required>
                <span class="toggle-password absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer">👁️</span>
            </div>
            @error('password')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex justify-between items-center mt-3 text-sm">
            <label class="flex items-center">
                <input type="checkbox" id="remember" name="remember" class="mr-2">
                Remember Me
            </label>
            <a href="{{ route('password.request') }}" class="auth-link">Forgot Password?</a>
        </div>

        <!-- Login & Register Buttons -->
        <div class="auth-buttons">
            <button type="submit" class="auth-button">Login</button>
            <a href="{{ route('register') }}" class="auth-button-secondary text-center">Register</a>
        </div>
    </form>
</div>

<script>
    // Toggle Password Visibility
    document.querySelector('.toggle-password').addEventListener('click', function() {
        let passwordField = document.getElementById('password');
        passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
    });

    // Day/Night Mode Toggle
    const modeToggle = document.getElementById('mode-toggle');
    const body = document.body;
    const modeText = document.getElementById('mode-text');

    modeToggle.addEventListener('change', function() {
        if (this.checked) {
            body.classList.add('dark');
            body.classList.remove('light');
            modeText.innerText = "Night Mode";
            localStorage.setItem('theme', 'dark');
        } else {
            body.classList.add('light');
            body.classList.remove('dark');
            modeText.innerText = "Day Mode";
            localStorage.setItem('theme', 'light');
        }
    });

    // Load saved theme
    if (localStorage.getItem('theme') === 'dark') {
        body.classList.add('dark');
        modeToggle.checked = true;
        modeText.innerText = "Night Mode";
    } else {
        body.classList.add('light');
        modeText.innerText = "Day Mode";
    }
</script>
@endsection
