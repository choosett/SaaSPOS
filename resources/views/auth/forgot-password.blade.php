<x-guest-layout>
    @section('styles')
        <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @endsection

    @section('scripts')
        <script src="{{ asset('js/auth.js') }}" defer></script>
    @endsection

    <div class="auth-container mx-auto mt-10 p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <h2 class="text-xl font-semibold text-center mb-4 text-gray-900 dark:text-gray-100">
            {{ __('Forgot Password?') }}
        </h2>

        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 text-center">
            {{ __('No problem. Just enter your email address, and we will email you a password reset link.') }}
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="auth-input mt-1" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="auth-button">
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>

