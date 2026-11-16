<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - {{ config('app.name', 'Angkut') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-angkut-deep overflow-x-hidden">
    <div class="flex h-screen overflow-hidden">

        <aside class="w-64 bg-white border-r-4 border-angkut-deep flex-shrink-0 hidden md:flex flex-col z-20 shadow-[4px_0px_0px_0px_rgba(30,48,17,0.1)]">
            <div class="h-20 flex items-center px-6 border-b-4 border-angkut-deep">
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-angkut-light border-3 border-angkut-deep rounded-xl flex items-center justify-center shadow-cartoon-xs group-hover:-translate-y-1 transition-transform">
                        <svg class="w-6 h-6 text-angkut-dark" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 8h-2V5a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h1a3 3 0 0 0 6 0h4a3 3 0 0 0 6 0h1a1 1 0 0 0 1-1v-5a3 3 0 0 0-3-3z"/>
                        </svg>
                    </div>
                    <span class="font-fun text-2xl font-extrabold text-angkut-deep tracking-wider drop-shadow-[1px_1px_0px_#1E3011]">ANGKUT</span>
                </a>
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-3 overflow-y-auto font-fun font-bold text-sm">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border-3 transition-all hover:-translate-y-1 {{ request()->routeIs('admin.dashboard') ? 'bg-angkut-pop border-angkut-deep shadow-cartoon text-angkut-deep' : 'bg-white border-transparent text-slate-500 hover:border-angkut-deep hover:text-angkut-deep hover:shadow-cartoon-xs' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.verifications.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border-3 transition-all hover:-translate-y-1 {{ request()->routeIs('admin.verifications.*') ? 'bg-angkut-light border-angkut-deep shadow-cartoon text-angkut-deep' : 'bg-white border-transparent text-slate-500 hover:border-angkut-deep hover:text-angkut-deep hover:shadow-cartoon-xs' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Verifikasi Laporan
                </a>

                <a href="{{ route('admin.assignments.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border-3 transition-all hover:-translate-y-1 {{ request()->routeIs('admin.assignments.*') ? 'bg-angkut-medium border-angkut-deep shadow-cartoon text-white' : 'bg-white border-transparent text-slate-500 hover:border-angkut-deep hover:text-angkut-deep hover:shadow-cartoon-xs' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Assign Tugas
                </a>

                <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border-3 transition-all hover:-translate-y-1 {{ request()->routeIs('admin.reports.*') ? 'bg-angkut-orange border-angkut-deep shadow-cartoon text-white' : 'bg-white border-transparent text-slate-500 hover:border-angkut-deep hover:text-angkut-deep hover:shadow-cartoon-xs' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Semua Laporan
                </a>

                <!-- Menu Manajemen Tim -->
                <a href="{{ route('admin.teams.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl border-3 transition-all hover:-translate-y-1 {{ request()->routeIs('admin.teams.*') ? 'bg-angkut-soft border-angkut-deep shadow-cartoon text-angkut-deep' : 'bg-white border-transparent text-slate-500 hover:border-angkut-deep hover:text-angkut-deep hover:shadow-cartoon-xs' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Manajemen Tim
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
            <header class="h-20 bg-white border-b-4 border-angkut-deep flex items-center justify-between px-6 z-10">
                <div class="flex items-center gap-4">
                    <h1 class="font-fun text-2xl font-extrabold text-angkut-deep uppercase tracking-wide">@yield('header', 'Dashboard')</h1>
                </div>
                
                <div class="flex items-center gap-4">
                    <x-notification-bell />

                    <div class="text-right hidden sm:block font-fun">
                        <p class="text-sm font-bold text-angkut-deep">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-angkut-medium font-semibold">Administrator</p>
                    </div>
                    <div class="h-11 w-11 rounded-xl bg-angkut-pop border-3 border-angkut-deep flex items-center justify-center text-angkut-deep font-fun font-black text-lg shadow-cartoon-xs">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>