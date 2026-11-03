<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Petugas - {{ config('app.name', 'ANGKUT') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <nav class="bg-amber-600 text-white px-4 py-3 flex justify-between items-center shadow">
            <div class="font-bold text-lg">Portal Petugas ANGKUT</div>
            <div class="text-sm">{{ auth()->user()->name ?? 'Petugas' }}</div>
        </nav>
        <main class="flex-1 max-w-4xl w-full mx-auto p-4 sm:p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
