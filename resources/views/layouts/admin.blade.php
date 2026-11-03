<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - {{ config('app.name', 'ANGKUT') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-900 font-sans antialiased">
    <div class="min-h-screen flex">
        <aside class="w-64 bg-slate-800 text-slate-100 flex flex-col">
            <div class="h-16 flex items-center px-6 font-bold text-lg border-b border-slate-700">
                ANGKUT Admin
            </div>
            <nav class="flex-1 px-4 py-4 space-y-1">
                <a href="{{ url('/admin/dashboard') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Dashboard</a>
                <a href="{{ url('/admin/verifikasi') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Verifikasi Laporan</a>
                <a href="{{ url('/admin/penugasan') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Penugasan Tim</a>
                <a href="{{ url('/admin/tim') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Kelola Tim</a>
                <a href="{{ url('/admin/analitik') }}" class="block px-3 py-2 rounded hover:bg-slate-700">Analitik & SLA</a>
            </nav>
        </aside>
        <div class="flex-1 flex flex-col">
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6">
                <h1 class="text-xl font-semibold">@yield('page_title', 'Dashboard')</h1>
                <div>{{ auth()->user()->name ?? 'Administrator' }}</div>
            </header>
            <main class="p-6 flex-1">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
