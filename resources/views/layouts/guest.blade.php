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
            
            <!-- 
                LOGO HEADER: 
                Hanya tampil jika URL-nya adalah /login atau /register.
                Jika URL-nya /lapor atau /tracking, logo ini akan hilang sepenuhnya.
            -->
            @if(request()->is('login') || request()->is('register'))
                <div class="mb-6">
                    <a href="/" class="flex items-center gap-2 group">
                        <!-- Menggunakan logo asli dari folder public/images -->
                        <img src="{{ asset('images/logo.webp') }}" alt="Angkut Logo" class="h-16 md:h-20 object-contain drop-shadow-md group-hover:-translate-y-1 transition-transform">
                    </a>
                </div>
            @endif

            <!-- Kontainer Konten Form -->
            <!-- 
                Lebar akan otomatis menyesuaikan: 
                Jika di halaman lapor (report.create), maka max-w-4xl (lebar).
                Jika di halaman lain, maka sm:max-w-md (sedang).
            -->
            <div class="w-full {{ request()->routeIs('public.report.create') ? 'max-w-5xl' : 'sm:max-w-md' }} mt-6 px-4 sm:px-6 py-8 bg-white shadow-cartoon-lg border-4 border-angkut-deep overflow-hidden sm:rounded-3xl">
                @yield('content')
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-sm text-slate-500 font-bold pb-8">
                &copy; {{ date('Y') }} Angkut Palembang. All rights reserved.
            </div>
        </div>

        @stack('scripts')
    </body>
</html>