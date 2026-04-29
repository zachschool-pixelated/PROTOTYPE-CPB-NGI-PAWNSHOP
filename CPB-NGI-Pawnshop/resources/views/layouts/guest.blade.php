<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Management System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script>
            // Dark mode detection and initialization
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-white to-slate-50 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <!-- Theme Toggle Button -->
        <button id="theme-toggle" class="fixed top-6 right-6 p-2 rounded-lg bg-gray-200 dark:bg-slate-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-slate-600 transition-all duration-300 shadow-md hover:shadow-lg z-50" title="Toggle dark mode">
            <svg id="sun-icon" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v2a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l-1.414-1.414a1 1 0 00-1.414 1.414l1.414 1.414a1 1 0 001.414-1.414zM2.05 6.464A1 1 0 000 8a1 1 0 001.414 1.414l1.414-1.414a1 1 0 10-1.414-1.414zm12.728 0a1 1 0 010 1.414l-1.414 1.414a1 1 0 11-1.414-1.414l1.414-1.414a1 1 0 011.414 0zM16.05 13.536a1 1 0 000-1.414l-1.414-1.414a1 1 0 10-1.414 1.414l1.414 1.414a1 1 0 001.414 0z" clip-rule="evenodd" /></svg>
            <svg id="moon-icon" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
            </svg>
        </button>

        <div class="w-full max-w-md">
            <!-- Logo & Branding -->
            <div class="flex justify-center mb-10">
                <a href="/" class="inline-flex items-center gap-3 group">
                    <div class="p-2 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                        <x-application-logo class="w-6 h-6 fill-current text-white" />
                    </div>
                    <span class="text-lg font-bold text-gray-900 dark:text-white hidden sm:inline">{{ config('app.name') }}</span>
                </a>
            </div>

            <!-- Auth Card -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl overflow-hidden border border-gray-100 dark:border-slate-700 transition-all duration-300 hover:shadow-2xl">
                <!-- Decorative Header Bar -->
                <div class="h-1 bg-gradient-to-r from-blue-500 via-blue-600 to-indigo-600"></div>
                
                <div class="px-6 py-8 sm:px-8 sm:py-10">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center space-y-2">
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Secure Authentication') }} • {{ date('Y') }} {{ config('app.name') }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500">{{ __('All rights reserved.') }}</p>
            </div>
        </div>

        <!-- Theme Toggle Script -->
        <script>
            const themeToggle = document.getElementById('theme-toggle');
            const sunIcon = document.getElementById('sun-icon');
            const moonIcon = document.getElementById('moon-icon');

            function updateThemeIcons() {
                if (document.documentElement.classList.contains('dark')) {
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                } else {
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
                }
            }

            themeToggle.addEventListener('click', () => {
                const isDark = document.documentElement.classList.contains('dark');
                
                if (isDark) {
                    document.documentElement.classList.remove('dark');
                    localStorage.theme = 'light';
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.theme = 'dark';
                }
                
                updateThemeIcons();
            });

            // Initialize icons on page load
            updateThemeIcons();
        </script>
    </body>
</html>
