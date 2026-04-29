<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-indigo-100 to-indigo-50 dark:from-indigo-900/30 dark:to-indigo-800/20 rounded-lg mb-4">
            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Set New Password') }}</h1>
        <p class="text-gray-600 dark:text-gray-400">{{ __('Create a strong password to secure your account') }}</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="font-semibold" />
            <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('New Password')" class="font-semibold" />
            <x-text-input id="password" class="block mt-2 w-full" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-1">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                {{ __('Use at least 8 characters with letters, numbers, and symbols') }}
            </p>
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="font-semibold" />
            <x-text-input id="password_confirmation" class="block mt-2 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Reset Button -->
        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3 text-base font-semibold transition-all duration-200 hover:shadow-lg active:scale-95">{{ __('Reset Password') }}</x-primary-button>
        </div>
    </form>

    <!-- Divider -->
    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-slate-700">
        <p class="text-sm text-center text-gray-600 dark:text-gray-400">
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-semibold transition">
                {{ __('Back to Sign In') }}
            </a>
        </p>
    </div>
</x-guest-layout>
