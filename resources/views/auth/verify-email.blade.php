<x-guest-layout>
    @section('styles')
        <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @endsection

    @section('scripts')
        <script src="{{ asset('js/auth.js') }}" defer></script>
    @endsection

    <div class="auth-container mx-auto mt-10 p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <h2 class="text-xl font-semibold text-center mb-4 text-gray-900 dark:text-gray-100">
            {{ __('Verify Your Email Address') }}
        </h2>

        <p class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center">
            {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just sent to you. If you didn\'t receive the email, click the button below to resend it.') }}
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400 text-center">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 flex flex-col space-y-3 items-center">
            <!-- Resend Verification Email -->
            <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                @csrf
                <x-primary-button class="auth-button w-full">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </form>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="w-full text-center">
                @csrf
                <button type="submit" class="auth-link">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
