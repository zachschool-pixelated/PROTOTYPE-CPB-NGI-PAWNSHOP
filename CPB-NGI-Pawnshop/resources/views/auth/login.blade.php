<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-50 dark:from-blue-900/30 dark:to-blue-800/20 rounded-lg mb-4">
            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Welcome Back') }}</h1>
        <p class="text-gray-600 dark:text-gray-400">{{ __('Sign in to your account to continue') }}</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="font-semibold" />
            <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="font-semibold" />
            <x-text-input id="password" class="block mt-2 w-full" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-2">
            <label for="remember_me" class="flex items-center gap-2 cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 dark:bg-slate-700 dark:border-slate-600 text-blue-600 dark:text-blue-500 shadow-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:focus:ring-offset-slate-800 transition" name="remember">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition">{{ __('Remember me') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Sign In Button -->
        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3 text-base font-semibold transition-all duration-200 hover:shadow-lg active:scale-95">{{ __('Sign In') }}</x-primary-button>
        </div>
    </form>

    <!-- Divider -->
    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-slate-700">
        <p class="text-sm text-center text-gray-600 dark:text-gray-400">
            {{ __('Don\'t have an account?') }}
            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-semibold transition">
                {{ __('Create one now') }}
            </a>
        </p>
    </div>
</x-guest-layout>
