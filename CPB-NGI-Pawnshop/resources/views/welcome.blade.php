<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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

        <style>
            body {
                font-family: 'Figtree', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-center justify-center">
            <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-4">
                        {{ config('app.name', 'Management System') }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mb-8">
                        Welcome to the system
                    </p>

                    <div class="space-y-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    Login
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="block w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

