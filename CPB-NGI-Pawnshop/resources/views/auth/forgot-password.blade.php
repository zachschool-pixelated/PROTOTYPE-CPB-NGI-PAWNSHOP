<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-amber-100 to-amber-50 dark:from-amber-900/30 dark:to-amber-800/20 rounded-lg mb-4">
            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Forgot Password') }}</h1>
        <p class="text-gray-600 dark:text-gray-400">{{ __('No worries, we\'ll help you reset it') }}</p>
    </div>

    <!-- Instructions -->
    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg flex gap-3">
        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zM8 8a1 1 0 000 2h6a1 1 0 100-2H8z" clip-rule="evenodd" />
        </svg>
        <p class="text-sm text-blue-800 dark:text-blue-300">
            {{ __('Enter your email address and we\'ll send you a link to reset your password.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="font-semibold" />
            <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Send Button -->
        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3 text-base font-semibold transition-all duration-200 hover:shadow-lg active:scale-95">{{ __('Send Reset Link') }}</x-primary-button>
        </div>
    </form>

    <!-- Divider -->
    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-slate-700">
        <p class="text-sm text-center text-gray-600 dark:text-gray-400">
            {{ __('Remember your password?') }}
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-semibold transition">
                {{ __('Back to Sign In') }}
            </a>
        </p>
    </div>
</x-guest-layout>
