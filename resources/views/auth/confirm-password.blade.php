<x-guest-layout>
    @section('styles')
        <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @endsection

    @section('scripts')
        <script src="{{ asset('js/auth.js') }}" defer></script>
    @endsection

    <div class="auth-container mx-auto mt-10 p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <h2 class="text-xl font-semibold text-center mb-4 text-gray-900 dark:text-gray-100">
            {{ __('Confirm Your Password') }}
        </h2>

        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 text-center">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
            @csrf

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="auth-input mt-1" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end mt-4">
                <x-primary-button class="auth-button">
                    {{ __('Confirm') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
