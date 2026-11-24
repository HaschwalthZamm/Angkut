@extends('layouts.petugas')

@section('header', 'Dashboard Tim')

@section('content')
<div class="space-y-6">
    
    @if(!$team)
        <div class="bg-rose-100 border-4 border-rose-500 text-rose-800 font-bold p-8 rounded-3xl shadow-cartoon text-center font-fun text-xl">
            <svg class="w-16 h-16 mx-auto mb-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
            Anda belum tergabung dalam tim manapun.<br>Hubungi Admin Pusat untuk dimasukkan ke dalam tim.
        </div>
    @else
        <!-- HERO BANNER -->
        <div class="bg-angkut-dark border-4 border-angkut-deep rounded-3xl p-6 md:p-8 shadow-cartoon relative overflow-hidden flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="absolute top-0 right-0 w-64 h-64 bg-angkut-medium rounded-full blur-3xl opacity-30 -z-0"></div>
            
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 bg-angkut-light border-2 border-angkut-deep px-3 py-1 rounded-full shadow-cartoon-xs mb-4">
                    <span class="w-2 h-2 bg-angkut-pop rounded-full animate-ping"></span>
                    <span class="font-fun font-bold text-xs uppercase tracking-widest text-angkut-deep">Tugas Anda Saat Ini</span>
                </div>
                <h2 class="font-fun text-3xl md:text-4xl font-extrabold text-white drop-shadow-md">{{ $team->name }}</h2>
                <div class="flex items-center gap-2 mt-2 text-angkut-cream font-bold text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Wilayah: Kecamatan {{ $team->region?->name }}
                </div>
            </div>
            
            <a href="{{ route('petugas.tasks.index') }}" class="relative z-10 bg-angkut-pop hover:bg-yellow-400 text-angkut-deep font-fun font-extrabold px-8 py-4 border-4 border-angkut-deep rounded-2xl shadow-cartoon-lg transition-all hover:-translate-y-1 active:translate-y-1 active:shadow-cartoon-xs uppercase tracking-wider flex items-center gap-2 whitespace-nowrap">
                <span>Lihat Semua Tugas</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

        <!-- STATISTIK CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Tugas Baru -->
            <div class="bg-white rounded-3xl border-4 border-angkut-deep p-6 flex items-center gap-4 shadow-cartoon hover:-translate-y-1 transition-transform">
                <div class="p-4 bg-indigo-100 text-indigo-600 rounded-2xl border-3 border-angkut-deep shadow-cartoon-xs">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold font-fun text-slate-500 uppercase tracking-wide">Tugas Baru</p>
                    <p class="text-4xl font-black text-angkut-deep">{{ number_format($stats['assigned']) }}</p>
                </div>
            </div>

            <!-- Diproses -->
            <div class="bg-white rounded-3xl border-4 border-angkut-deep p-6 flex items-center gap-4 shadow-cartoon hover:-translate-y-1 transition-transform">
                <div class="p-4 bg-orange-100 text-angkut-orange rounded-2xl border-3 border-angkut-deep shadow-cartoon-xs">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold font-fun text-slate-500 uppercase tracking-wide">Diproses</p>
                    <p class="text-4xl font-black text-angkut-deep">{{ number_format($stats['on_progress']) }}</p>
                </div>
            </div>

            <!-- Selesai Hari Ini -->
            <div class="bg-white rounded-3xl border-4 border-angkut-deep p-6 flex items-center gap-4 shadow-cartoon hover:-translate-y-1 transition-transform">
                <div class="p-4 bg-green-100 text-angkut-dark rounded-2xl border-3 border-angkut-deep shadow-cartoon-xs">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold font-fun text-slate-500 uppercase tracking-wide">Selesai Hari Ini</p>
                    <p class="text-4xl font-black text-angkut-deep">{{ number_format($stats['completed_today']) }}</p>
                </div>
            </div>

            <!-- Melewati SLA -->
            <div class="bg-white rounded-3xl border-4 border-angkut-deep p-6 flex items-center gap-4 shadow-cartoon hover:-translate-y-1 transition-transform relative overflow-hidden">
                @if($stats['overdue'] > 0)
                    <div class="absolute top-0 right-0 w-full h-full bg-rose-50 -z-10"></div>
                @endif
                <div class="p-4 bg-rose-100 text-rose-600 rounded-2xl border-3 border-angkut-deep shadow-cartoon-xs">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold font-fun text-rose-500 uppercase tracking-wide">Melewati SLA</p>
                    <p class="text-4xl font-black text-rose-600">{{ number_format($stats['overdue']) }}</p>
                </div>
            </div>
        </div>

        <!-- MAIN GRID CONTENT -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
            
            <!-- KOLOM KIRI (2/3) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- GRAFIK AKTIVITAS -->
                <div class="bg-white border-4 border-angkut-deep rounded-3xl p-6 shadow-cartoon">
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4">
                        <div>
                            <h3 class="font-fun text-xl font-bold text-angkut-deep uppercase tracking-wide">Aktivitas Operasional</h3>
                            <p class="text-xs font-bold text-slate-400 mt-1">Tugas Masuk vs Tugas Selesai</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-angkut-pop border border-angkut-deep"></span>
                                <span class="text-xs font-bold text-slate-500">Masuk</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-angkut-dark border border-angkut-deep"></span>
                                <span class="text-xs font-bold text-slate-500">Selesai</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- CANVAS CHART.JS -->
                    <div class="relative w-full h-64 md:h-72">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>

                <!-- TABEL TUGAS AKTIF -->
                <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden">
                    <div class="p-6 border-b-4 border-angkut-deep bg-angkut-light flex justify-between items-center">
                        <h3 class="font-fun text-xl font-bold text-angkut-deep uppercase tracking-wide">Tugas Aktif</h3>
                        <a href="{{ route('petugas.tasks.index') }}" class="text-sm font-bold font-fun text-angkut-dark hover:text-angkut-orange transition">Lihat Semua</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse font-sans">
                            <thead>
                                <tr class="bg-slate-50 border-b-3 border-angkut-deep font-fun font-bold text-angkut-deep uppercase text-xs">
                                    <th class="px-6 py-4">Laporan</th>
                                    <th class="px-6 py-4">Batas Waktu (SLA)</th>
                                    <th class="px-6 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y-2 divide-slate-100">
                                @forelse($recentTasks as $task)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4">
                                            <a href="{{ route('petugas.tasks.show', $task->id) }}" class="font-bold text-angkut-deep hover:text-angkut-orange transition">{{ $task->title }}</a>
                                            <p class="text-xs font-semibold text-slate-500 mt-1">{{ $task->region->name }} • {{ $task->category->name }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($task->sla_deadline_at < now())
                                                <span class="inline-flex items-center gap-1 text-rose-600 font-bold text-sm bg-rose-100 px-2 py-1 rounded-lg border border-rose-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Terlambat!
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 text-angkut-dark font-bold text-sm bg-green-100 px-2 py-1 rounded-lg border border-green-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    {{ $task->sla_deadline_at->diffForHumans() }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-xl border-2 border-angkut-deep shadow-cartoon-xs bg-angkut-pop text-angkut-deep">
                                                {{ $task->status->label() }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-slate-500 font-fun font-bold text-lg">
                                            Yeay! Tidak ada tugas yang menunggu. Kerja bagus!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN (1/3) -->
            <div class="space-y-6">
                
                <!-- PROGRES PEKERJAAN -->
                <div class="bg-white border-4 border-angkut-deep rounded-3xl p-6 shadow-cartoon text-center">
                    <h3 class="font-fun text-lg font-bold text-angkut-deep uppercase tracking-wide mb-6">Progres Hari Ini</h3>
                    
                    <div class="relative w-40 h-40 mx-auto">
                        <!-- SVG Donut Chart -->
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-slate-100" stroke-width="4" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="text-angkut-dark transition-all duration-1000 ease-out" stroke-width="4" stroke-dasharray="{{ $progressPercentage }}, 100" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-4xl font-black font-fun text-angkut-deep">{{ $progressPercentage }}%</span>
                            <span class="text-xs font-bold text-slate-400">Selesai</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center text-sm font-bold text-slate-600 mt-6 bg-slate-50 p-3 rounded-xl border-2 border-slate-200">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-angkut-dark rounded-full"></span>
                            <span>Selesai: {{ $stats['completed_today'] }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-angkut-light rounded-full border border-angkut-deep"></span>
                            <span>Total: {{ $totalToday }}</span>
                        </div>
                    </div>
                </div>

                <!-- AKSES CEPAT -->
                <div class="bg-white border-4 border-angkut-deep rounded-3xl p-6 shadow-cartoon">
                    <h3 class="font-fun text-lg font-bold text-angkut-deep uppercase tracking-wide mb-4">Akses Cepat</h3>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('petugas.tasks.index') }}" class="flex flex-col items-center justify-center p-4 bg-angkut-soft border-3 border-angkut-deep rounded-2xl shadow-cartoon-xs hover:bg-angkut-light hover:-translate-y-1 transition-all group">
                            <svg class="w-8 h-8 text-angkut-dark mb-2 group-hover:animate-bounce" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <span class="font-fun font-bold text-sm text-angkut-deep text-center">Tugas Baru</span>
                        </a>
                        
                        <a href="{{ route('petugas.tasks.index') }}" class="flex flex-col items-center justify-center p-4 bg-angkut-soft border-3 border-angkut-deep rounded-2xl shadow-cartoon-xs hover:bg-angkut-light hover:-translate-y-1 transition-all group">
                            <svg class="w-8 h-8 text-angkut-orange mb-2 group-hover:animate-pulse" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            <span class="font-fun font-bold text-sm text-angkut-deep text-center">Diproses</span>
                        </a>
                    </div>
                </div>

                <!-- AKTIVITAS TERBARU (TIMELINE) -->
                <div class="bg-white border-4 border-angkut-deep rounded-3xl p-6 shadow-cartoon">
                    <h3 class="font-fun text-lg font-bold text-angkut-deep uppercase tracking-wide mb-4">Aktivitas Terbaru</h3>
                    
                    <div class="relative border-l-4 border-slate-200 ml-3 space-y-6 pb-4">
                        <div class="relative pl-6">
                            <div class="absolute -left-[11px] top-1 w-5 h-5 bg-slate-100 border-4 border-slate-300 rounded-full"></div>
                            <p class="text-sm font-bold text-slate-400 italic">Belum ada aktivitas tim hari ini.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<!-- Chart.js dari CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('activityChart').getContext('2d');
        
        // Data dari Controller
        const labels = @json($chartLabels);
        const dataMasuk = @json($chartDataMasuk);
        const dataSelesai = @json($chartDataSelesai);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Tugas Masuk',
                        data: dataMasuk,
                        backgroundColor: '#FFBF00', // angkut-pop
                        borderColor: '#1E3011',     // angkut-deep
                        borderWidth: 2,
                        borderRadius: 6,
                    },
                    {
                        label: 'Tugas Selesai',
                        data: dataSelesai,
                        backgroundColor: '#537B2F', // angkut-dark
                        borderColor: '#1E3011',     // angkut-deep
                        borderWidth: 2,
                        borderRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Kita sudah buat legenda kustom di HTML
                    },
                    tooltip: {
                        backgroundColor: '#1E3011',
                        titleFont: { family: 'Fredoka', size: 14 },
                        bodyFont: { family: 'Plus Jakarta Sans', size: 13 },
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: true,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1, // Angka bulat
                            font: { family: 'Plus Jakarta Sans', weight: 'bold' },
                            color: '#64748b'
                        },
                        grid: {
                            color: '#e2e8f0',
                            drawBorder: false,
                        }
                    },
                    x: {
                        ticks: {
                            font: { family: 'Fredoka', weight: 'bold', size: 13 },
                            color: '#1E3011'
                        },
                        grid: {
                            display: false,
                            drawBorder: true,
                            borderColor: '#1E3011',
                            borderWidth: 2
                        }
                    }
                }
            }
        });
    });
</script>
@endpush