@extends('layouts.masyarakat')

@section('header', 'Dashboard Warga')

@section('content')
<div class="space-y-6">

    <!-- Kartu Sambutan -->
    <div class="bg-angkut-light border-4 border-angkut-deep rounded-3xl p-6 shadow-cartoon flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h2 class="font-fun text-2xl font-extrabold text-angkut-deep">Halo, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-sm font-semibold text-angkut-dark mt-1">Mari jaga kebersihan Palembang. Laporkan tumpukan sampah di sekitarmu.</p>
        </div>
        <a href="{{ route('masyarakat.reports.create') }}" class="bg-angkut-pop hover:bg-yellow-400 text-angkut-deep font-fun font-extrabold px-6 py-3 border-3 border-angkut-deep rounded-xl shadow-cartoon transition-all hover:-translate-y-1 whitespace-nowrap">
            + Buat Laporan
        </a>
    </div>

    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Laporan -->
        <div class="bg-white rounded-xl shadow-sm border-3 border-angkut-deep p-6 flex items-center gap-4 shadow-cartoon-xs">
            <div class="p-3 bg-blue-100 text-blue-600 rounded-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold font-fun text-slate-500 uppercase">Total Laporan</p>
                <p class="text-3xl font-black text-slate-900">{{ number_format($stats['total']) }}</p>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white rounded-xl shadow-sm border-3 border-angkut-deep p-6 flex items-center gap-4 shadow-cartoon-xs">
            <div class="p-3 bg-yellow-100 text-yellow-600 rounded-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold font-fun text-slate-500 uppercase">Menunggu</p>
                <p class="text-3xl font-black text-slate-900">{{ number_format($stats['pending']) }}</p>
            </div>
        </div>

        <!-- On Progress -->
        <div class="bg-white rounded-xl shadow-sm border-3 border-angkut-deep p-6 flex items-center gap-4 shadow-cartoon-xs">
            <div class="p-3 bg-orange-100 text-orange-600 rounded-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold font-fun text-slate-500 uppercase">Diproses</p>
                <p class="text-3xl font-black text-slate-900">{{ number_format($stats['on_progress']) }}</p>
            </div>
        </div>

        <!-- Completed -->
        <div class="bg-white rounded-xl shadow-sm border-3 border-angkut-deep p-6 flex items-center gap-4 shadow-cartoon-xs">
            <div class="p-3 bg-green-100 text-green-600 rounded-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold font-fun text-slate-500 uppercase">Selesai</p>
                <p class="text-3xl font-black text-slate-900">{{ number_format($stats['completed']) }}</p>
            </div>
        </div>
    </div>

    <!-- Laporan Terbaru -->
    <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden mt-8">
        <div class="p-6 border-b-4 border-angkut-deep flex justify-between items-center bg-slate-50">
            <h3 class="font-fun text-lg font-bold text-angkut-deep">Laporan Terbaru Anda</h3>
            <a href="{{ route('masyarakat.reports.index') }}" class="text-sm font-bold font-fun text-angkut-medium hover:text-angkut-dark transition">Lihat Semua &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse font-sans">
                <thead>
                    <tr class="bg-white border-b-2 border-slate-200 font-fun font-bold text-slate-500 uppercase text-xs">
                        <th class="px-6 py-4">Tiket</th>
                        <th class="px-6 py-4">Laporan</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-slate-100">
                    @forelse($recentReports as $report)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-mono text-sm font-bold">{{ $report->tracking_code }}</td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-angkut-deep">{{ $report->title }}</p>
                                <p class="text-xs text-slate-500">{{ $report->category->name }} • {{ $report->region->name }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColor = match($report->status->color()) {
                                        'yellow' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                                        'blue'   => 'bg-blue-100 text-blue-800 border-blue-300',
                                        'red'    => 'bg-red-100 text-red-800 border-red-300',
                                        'indigo' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                                        'orange' => 'bg-orange-100 text-orange-800 border-orange-300',
                                        'green'  => 'bg-green-100 text-green-800 border-green-300',
                                        'gray'   => 'bg-slate-100 text-slate-800 border-slate-300',
                                        default  => 'bg-slate-100 text-slate-800 border-slate-300',
                                    };
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-xl border-2 shadow-sm {{ $statusColor }}">
                                    {{ $report->status->label() }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-slate-500 font-fun font-bold text-lg">
                                Belum ada laporan. Yuk mulai lapor!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection