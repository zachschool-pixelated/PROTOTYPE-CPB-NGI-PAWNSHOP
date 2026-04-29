<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-red-100 to-red-50 dark:from-red-900/30 dark:to-red-800/20 rounded-lg mb-4">
            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Confirm Password') }}</h1>
        <p class="text-gray-600 dark:text-gray-400">{{ __('Verify your identity for security') }}</p>
    </div>

    <!-- Security Notice -->
    <div class="mb-6 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg flex gap-3">
        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
        <p class="text-sm text-amber-800 dark:text-amber-300">
            {{ __('This is a restricted area. Please confirm your password to continue.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="font-semibold" />
            <x-text-input id="password" class="block mt-2 w-full" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Button -->
        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3 text-base font-semibold transition-all duration-200 hover:shadow-lg active:scale-95">{{ __('Confirm Password') }}</x-primary-button>
        </div>
    </form>

    <!-- Divider -->
    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-slate-700">
        <p class="text-sm text-center text-gray-600 dark:text-gray-400">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-semibold transition">
                {{ __('Return to Dashboard') }}
            </a>
        </p>
    </div>
</x-guest-layout>
