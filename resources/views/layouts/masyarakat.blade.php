<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Angkut - Masyarakat</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-angkut-deep overflow-x-hidden">
    <div class="flex h-screen overflow-hidden">

        <aside class="w-64 bg-white border-r-4 border-angkut-deep flex-shrink-0 hidden md:flex flex-col z-40 shadow-[4px_0px_0px_0px_rgba(30,48,17,0.1)]">
            <div class="h-20 flex items-center px-6 border-b-4 border-angkut-deep">
                <a href="{{ url('/') }}" class="flex items-center group">
                    <!-- LOGO BARU -->
                    <img src="{{ asset('images/logo.webp') }}" alt="Angkut Logo" class="h-10 w-auto object-contain group-hover:-translate-y-1 transition-transform">
                </a>
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-3 overflow-y-auto font-fun font-bold text-sm">
                <a href="{{ route('masyarakat.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border-3 transition-all hover:-translate-y-1 {{ request()->routeIs('masyarakat.dashboard') ? 'bg-angkut-pop border-angkut-deep shadow-cartoon text-angkut-deep' : 'bg-white border-transparent text-slate-500 hover:border-angkut-deep hover:text-angkut-deep hover:shadow-cartoon-xs' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>

                <a href="{{ route('masyarakat.reports.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border-3 transition-all hover:-translate-y-1 {{ request()->routeIs('masyarakat.reports.create') ? 'bg-angkut-medium border-angkut-deep shadow-cartoon text-white' : 'bg-white border-transparent text-slate-500 hover:border-angkut-deep hover:text-angkut-deep hover:shadow-cartoon-xs' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                    Buat Laporan
                </a>

                <a href="{{ route('masyarakat.reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border-3 transition-all hover:-translate-y-1 {{ request()->routeIs('masyarakat.reports.index') || request()->routeIs('masyarakat.reports.show') ? 'bg-angkut-light border-angkut-deep shadow-cartoon text-angkut-deep' : 'bg-white border-transparent text-slate-500 hover:border-angkut-deep hover:text-angkut-deep hover:shadow-cartoon-xs' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Riwayat Laporan
                </a>
            </nav>

            <div class="p-4 border-t-4 border-angkut-deep">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center justify-center gap-2 w-full px-4 py-3 font-fun text-sm font-bold text-white bg-red-500 border-3 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-red-600 hover:-translate-y-1 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden relative">
            <header class="h-20 bg-white border-b-4 border-angkut-deep flex items-center justify-between px-6 z-50 relative">
                <div class="flex items-center gap-4">
                    <h1 class="font-fun text-2xl font-extrabold text-angkut-deep uppercase tracking-wide">@yield('header', 'Dashboard')</h1>
                </div>
                
                <div class="flex items-center gap-4">
                    <x-notification-bell />

                    <div class="text-right hidden sm:block font-fun">
                        <p class="text-sm font-bold text-angkut-deep">{{ Auth::user()->name ?? 'Warga' }}</p>
                        <p class="text-xs text-angkut-medium font-semibold">Masyarakat</p>
                    </div>
                    <div class="h-11 w-11 rounded-xl bg-angkut-pop border-3 border-angkut-deep flex items-center justify-center text-angkut-deep font-fun font-black text-lg shadow-cartoon-xs">
                        {{ substr(Auth::user()->name ?? 'W', 0, 1) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-6">
                @yield('content')
            </main>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>