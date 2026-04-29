<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-purple-100 to-purple-50 dark:from-purple-900/30 dark:to-purple-800/20 rounded-lg mb-4">
            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Verify Email') }}</h1>
        <p class="text-gray-600 dark:text-gray-400">{{ __('One last step to get started') }}</p>
    </div>

    <!-- Instructions -->
    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg flex gap-3">
        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zM8 8a1 1 0 000 2h6a1 1 0 100-2H8z" clip-rule="evenodd" />
        </svg>
        <div class="text-left">
            <p class="text-sm text-blue-800 dark:text-blue-300 font-medium mb-1">{{ __('Check your email') }}</p>
            <p class="text-sm text-blue-700 dark:text-blue-400">
                {{ __('We sent a verification link to your email. Click it to verify your account.') }}
            </p>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg flex gap-3 items-start">
            <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <div>
                <p class="text-sm font-medium text-green-800 dark:text-green-300">{{ __('Link sent!') }}</p>
                <p class="text-sm text-green-700 dark:text-green-400">
                    {{ __('A new verification link has been sent to your email.') }}
                </p>
            </div>
        </div>
    @endif

    <div class="space-y-3">
        <!-- Resend Button -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="w-full justify-center py-3 text-base font-semibold transition-all duration-200 hover:shadow-lg active:scale-95">{{ __('Resend Verification Email') }}</x-primary-button>
        </form>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full px-4 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-800 dark:text-white font-semibold rounded-lg transition duration-200">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
