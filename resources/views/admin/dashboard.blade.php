@extends('layouts.admin')

@section('header', 'Ringkasan Sistem')

@section('content')
<div class="space-y-6">

    <!-- BARIS 1: CARD STATUS LAPORAN UTAMA -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Laporan -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center gap-4">
            <div class="p-3 bg-blue-100 text-blue-600 rounded-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Total Laporan</p>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($data['reports']['total']) }}</p>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center gap-4">
            <div class="p-3 bg-yellow-100 text-yellow-600 rounded-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Pending (Baru)</p>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($data['reports']['pending']) }}</p>
            </div>
        </div>

        <!-- On Progress -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center gap-4">
            <div class="p-3 bg-orange-100 text-orange-600 rounded-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Sedang Ditangani</p>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($data['reports']['on_progress'] + $data['reports']['assigned']) }}</p>
            </div>
        </div>

        <!-- Selesai -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex items-center gap-4">
            <div class="p-3 bg-green-100 text-green-600 rounded-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Selesai / Closed</p>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($data['reports']['completed'] + $data['reports']['closed']) }}</p>
            </div>
        </div>
    </div>

    <!-- BARIS 2: GRID KONTEN -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- KIRI: TABEL LAPORAN TERBARU (2 Kolom) -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200">
            <div class="p-6 border-b border-slate-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-slate-800">Laporan Terbaru</h3>
                <a href="{{ route('admin.reports.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">Lihat Semua &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-sm border-b border-slate-200">
                            <th class="px-6 py-4 font-medium">Tiket</th>
                            <th class="px-6 py-4 font-medium">Laporan</th>
                            <th class="px-6 py-4 font-medium">Wilayah</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentReports as $report)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-sm font-mono text-slate-600">{{ $report->tracking_code }}</td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-slate-900 truncate max-w-xs">{{ $report->title }}</p>
                                    <p class="text-xs text-slate-500">{{ $report->category->name }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $report->region->name }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColor = match($report->status->color()) {
                                            'yellow' => 'bg-yellow-100 text-yellow-800',
                                            'blue'   => 'bg-blue-100 text-blue-800',
                                            'red'    => 'bg-red-100 text-red-800',
                                            'indigo' => 'bg-indigo-100 text-indigo-800',
                                            'orange' => 'bg-orange-100 text-orange-800',
                                            'green'  => 'bg-green-100 text-green-800',
                                            'gray'   => 'bg-slate-100 text-slate-800',
                                            default  => 'bg-slate-100 text-slate-800',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                        {{ $report->status->label() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500 text-sm">Belum ada laporan masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- KANAN: PANEL INFO & STATUS DETAIL (1 Kolom) -->
        <div class="space-y-6">
            
            <!-- SLA Peringatan -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Perhatian SLA</h3>
                @if($data['reports']['overdue'] > 0)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 flex gap-3">
                        <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                        <div>
                            <p class="text-sm font-bold text-red-800">{{ $data['reports']['overdue'] }} Laporan Melewati SLA</p>
                            <p class="text-xs text-red-600 mt-1">Butuh tindakan segera.</p>
                        </div>
                    </div>
                @else
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex gap-3">
                        <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <p class="text-sm font-bold text-green-800">SLA Aman</p>
                            <p class="text-xs text-green-600 mt-1">Semua laporan ditangani tepat waktu.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Detail Status Laporan (Semua data ditampilkan) -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Detail Status Laporan</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Terverifikasi (Verified)</span>
                        <span class="font-bold text-blue-600">{{ $data['reports']['verified'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Ditugaskan (Assigned)</span>
                        <span class="font-bold text-indigo-600">{{ $data['reports']['assigned'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Sedang Ditangani</span>
                        <span class="font-bold text-orange-600">{{ $data['reports']['on_progress'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Selesai (Completed)</span>
                        <span class="font-bold text-green-600">{{ $data['reports']['completed'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Ditolak (Rejected)</span>
                        <span class="font-bold text-red-600">{{ $data['reports']['rejected'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Ditutup (Closed)</span>
                        <span class="font-bold text-slate-800">{{ $data['reports']['closed'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Pengguna & Tim -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Data Pengguna & Tim</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Total Pengguna</span>
                        <span class="font-bold text-slate-900">{{ number_format($data['users']['total']) }} Akun</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600 pl-4">- Masyarakat</span>
                        <span class="font-bold text-slate-900">{{ number_format($data['users']['masyarakat']) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600 pl-4">- Petugas</span>
                        <span class="font-bold text-slate-900">{{ number_format($data['users']['petugas']) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600 pl-4">- Admin</span>
                        <span class="font-bold text-slate-900">{{ number_format($data['users']['admin']) }}</span>
                    </div>
                    <hr class="my-2 border-slate-100">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Total Tim</span>
                        <span class="font-bold text-slate-900">{{ number_format($data['teams']['total']) }} Tim</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600 pl-4">- Tim Aktif</span>
                        <span class="font-bold text-emerald-600">{{ number_format($data['teams']['active']) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Tugas Aktif</span>
                        <span class="font-bold text-indigo-600">{{ number_format($data['assignments']['active']) }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection