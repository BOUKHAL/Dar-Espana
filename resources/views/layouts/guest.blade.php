<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CAPSTONE') }} - Connexion</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased" style="background: linear-gradient(135deg, #c60d1e 0%, #ffca26 100%); min-height: 100vh;">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-8">
                <a href="/" class="flex flex-col items-center">
                    <img src="{{ asset('images/capstone-logo.svg') }}" alt="Capstone Logo" class="w-32 h-auto filter drop-shadow-lg" />
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-8 bg-white bg-opacity-95 backdrop-blur-sm shadow-2xl overflow-hidden sm:rounded-xl border border-yellow-200 border-opacity-50">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
