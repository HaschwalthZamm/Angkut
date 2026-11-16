<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-slate-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-angkut-soft/30">
            
            <!-- Logo di atas form (bisa diklik ke home) -->
            <div class="mb-6">
                <a href="/" class="flex items-center gap-2 group">
                    <div class="w-12 h-12 bg-angkut-light border-3 border-angkut-deep rounded-2xl flex items-center justify-center shadow-cartoon group-hover:-translate-y-1 transition-transform">
                        <svg class="w-7 h-7 text-angkut-dark" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 8h-2V5a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h1a3 3 0 0 0 6 0h4a3 3 0 0 0 6 0h1a1 1 0 0 0 1-1v-5a3 3 0 0 0-3-3z"/>
                        </svg>
                    </div>
                    <span class="font-fun text-3xl font-extrabold text-angkut-deep tracking-wider drop-shadow-[1px_1px_0px_#1E3011]">ANGKUT</span>
                </a>
            </div>

            <!-- Konten Form -->
            <div class="w-full sm:max-w-4xl mt-6 px-6 py-8 bg-white shadow-cartoon-lg border-4 border-angkut-deep overflow-hidden sm:rounded-3xl">
                @yield('content')
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-sm text-slate-500 font-bold">
                &copy; {{ date('Y') }} Angkut Palembang. All rights reserved.
            </div>
        </div>

        @stack('scripts')
    </body>
</html>