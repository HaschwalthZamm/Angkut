@extends('layouts.petugas')

@section('header', 'Dashboard Tim')

@section('content')
<div class="space-y-6">
    
    @if(!$team)
        <div class="bg-red-100 border-4 border-red-500 text-red-800 font-bold p-6 rounded-2xl shadow-cartoon text-center font-fun text-xl">
            ⚠️ Anda belum tergabung dalam tim manapun. Hubungi Admin Pusat untuk dimasukkan ke dalam tim.
        </div>
    @else
        <!-- Kartu Info Tim -->
        <div class="bg-angkut-dark border-4 border-angkut-deep rounded-3xl p-6 shadow-cartoon text-white flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <p class="text-sm font-bold text-angkut-light uppercase tracking-wider mb-1">Tugas Anda Saat Ini</p>
                <h2 class="font-fun text-3xl font-extrabold">{{ $team->name }}</h2>
                <p class="text-sm font-semibold mt-1">Wilayah: Kecamatan {{ $team->region?->name }}</p>
            </div>
            <a href="{{ route('petugas.tasks.index') }}" class="bg-angkut-pop hover:bg-yellow-400 text-angkut-deep font-fun font-extrabold px-6 py-3 border-3 border-angkut-deep rounded-xl shadow-cartoon transition-all hover:-translate-y-1 whitespace-nowrap">
                Lihat Semua Tugas
            </a>
        </div>

        <!-- Kartu Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Tugas Baru -->
            <div class="bg-white rounded-xl shadow-sm border-3 border-angkut-deep p-6 flex items-center gap-4 shadow-cartoon-xs">
                <div class="p-3 bg-indigo-100 text-indigo-600 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold font-fun text-slate-500 uppercase">Tugas Baru</p>
                    <p class="text-3xl font-black text-slate-900">{{ number_format($stats['assigned']) }}</p>
                </div>
            </div>

            <!-- Sedang Dikerjakan -->
            <div class="bg-white rounded-xl shadow-sm border-3 border-angkut-deep p-6 flex items-center gap-4 shadow-cartoon-xs">
                <div class="p-3 bg-orange-100 text-orange-600 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold font-fun text-slate-500 uppercase">Diproses</p>
                    <p class="text-3xl font-black text-slate-900">{{ number_format($stats['on_progress']) }}</p>
                </div>
            </div>

            <!-- Selesai Hari Ini -->
            <div class="bg-white rounded-xl shadow-sm border-3 border-angkut-deep p-6 flex items-center gap-4 shadow-cartoon-xs">
                <div class="p-3 bg-green-100 text-green-600 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold font-fun text-slate-500 uppercase">Selesai Hari Ini</p>
                    <p class="text-3xl font-black text-slate-900">{{ number_format($stats['completed_today']) }}</p>
                </div>
            </div>

            <!-- Overdue -->
            <div class="bg-white rounded-xl shadow-sm border-3 border-angkut-deep p-6 flex items-center gap-4 shadow-cartoon-xs">
                <div class="p-3 bg-red-100 text-red-600 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold font-fun text-slate-500 uppercase">Melewati SLA</p>
                    <p class="text-3xl font-black text-slate-900">{{ number_format($stats['overdue']) }}</p>
                </div>
            </div>
        </div>

        <!-- Tabel Tugas Prioritas -->
        <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden mt-8">
            <div class="p-6 border-b-4 border-angkut-deep bg-slate-50 flex justify-between items-center">
                <h3 class="font-fun text-lg font-bold text-angkut-deep">Tugas Terdekat (Berdasarkan SLA)</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse font-sans">
                    <thead>
                        <tr class="bg-white border-b-2 border-slate-200 font-fun font-bold text-slate-500 uppercase text-xs">
                            <th class="px-6 py-4">Tiket</th>
                            <th class="px-6 py-4">Laporan</th>
                            <th class="px-6 py-4">Batas Waktu</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-slate-100">
                        @forelse($recentTasks as $task)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-mono text-sm font-bold">
                                    <a href="{{ route('petugas.tasks.show', $task->id) }}" class="text-angkut-medium hover:underline">{{ $task->tracking_code }}</a>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-angkut-deep">{{ $task->title }}</p>
                                    <p class="text-xs text-slate-500">{{ $task->category->name }} • {{ $task->region->name }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @if($task->sla_deadline_at < now())
                                        <span class="text-red-600 font-bold text-sm">Lewat Batas!</span>
                                    @else
                                        <span class="text-green-600 font-bold text-sm">{{ $task->sla_deadline_at->diffForHumans() }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-xl border-2 border-angkut-deep shadow-cartoon-xs bg-slate-100 text-slate-800">
                                        {{ $task->status->label() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500 font-fun font-bold text-lg">
                                    Tidak ada tugas yang menunggu. Kerja bagus! 🎉
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection