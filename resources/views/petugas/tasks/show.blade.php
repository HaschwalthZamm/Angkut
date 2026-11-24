@extends('layouts.petugas')

@section('header', 'Detail Tugas')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    @if(session('success'))
        <div class="bg-green-100 border-4 border-angkut-deep text-green-800 font-bold p-4 rounded-2xl shadow-cartoon text-center font-fun text-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border-4 border-angkut-deep text-red-800 font-bold p-4 rounded-2xl shadow-cartoon font-fun">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- KONDISI 1: JIKA TUGAS SUDAH SELESAI (COMPLETED / CLOSED) --}}
    @if($report->status === \App\Enums\ReportStatus::Completed || $report->status === \App\Enums\ReportStatus::Closed)
        <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon-lg overflow-hidden relative">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-green-100 rounded-full opacity-50"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-angkut-light rounded-full opacity-50"></div>

            <div class="p-8 md:p-12 text-center relative z-10">
                <div class="w-24 h-24 bg-green-100 border-4 border-angkut-deep rounded-full flex items-center justify-center mx-auto mb-6 shadow-cartoon-sm">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                </div>

                <h2 class="font-fun text-3xl md:text-4xl font-extrabold text-angkut-deep mb-4 uppercase tracking-wide">Tugas Selesai</h2>
                <p class="text-slate-600 font-semibold mb-8 max-w-lg mx-auto">Terima kasih atas kerja keras Anda! Laporan sampah ini telah berhasil diselesaikan dan diangkut.</p>

                <div class="bg-angkut-soft border-3 border-angkut-deep rounded-2xl p-6 max-w-lg mx-auto text-left shadow-cartoon-xs mb-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kode Tracking</p>
                            <p class="font-mono text-lg font-black text-angkut-deep">{{ $report->tracking_code }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu Selesai</p>
                            <p class="font-bold text-angkut-deep">{{ $report->completed_at ? $report->completed_at->format('d M Y, H:i') : '-' }} WIB</p>
                        </div>
                        <div class="sm:col-span-2 pt-2 border-t-2 border-angkut-deep/10">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Judul Laporan</p>
                            <p class="font-bold text-angkut-deep text-lg">{{ $report->title }}</p>
                        </div>
                    </div>
                </div>

                <!-- TOMBOL KEMBALI KE RIWAYAT -->
                <a href="{{ route('petugas.tasks.history') }}" class="inline-flex items-center gap-2 bg-angkut-medium hover:bg-angkut-dark text-white font-fun text-lg font-extrabold px-8 py-4 border-3 border-angkut-deep rounded-2xl shadow-cartoon transition-all hover:-translate-y-1 active:translate-y-1 active:shadow-cartoon-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Riwayat Tugas
                </a>
            </div>
        </div>

    {{-- KONDISI 2: JIKA TUGAS MASIH AKTIF --}}
    @else
        <!-- ... (Kode untuk tampilan tugas aktif tetap sama seperti sebelumnya) ... -->
        <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden">
            <div class="p-6 border-b-4 border-angkut-deep bg-angkut-soft flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                <div>
                    <p class="text-sm font-bold text-slate-500 uppercase">Kode Tracking</p>
                    <p class="font-mono text-2xl font-black text-angkut-deep">{{ $report->tracking_code }}</p>
                </div>
                @php
                    $statusColor = match($report->status->color()) {
                        'indigo' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                        'orange' => 'bg-orange-100 text-orange-800 border-orange-300',
                        default  => 'bg-slate-100 text-slate-800 border-slate-300',
                    };
                @endphp
                <span class="px-4 py-2 text-sm font-bold rounded-xl border-2 shadow-sm {{ $statusColor }}">
                    {{ $report->status->label() }}
                </span>
            </div>

            <div class="p-6 space-y-8">
                <!-- Info Laporan -->
                <div>
                    <h3 class="font-fun text-2xl font-bold text-angkut-deep mb-2">{{ $report->title }}</h3>
                    <p class="text-slate-600">{{ $report->description }}</p>
                    <div class="mt-4 flex flex-wrap gap-2 text-sm font-bold">
                        <span class="bg-slate-100 px-3 py-1 rounded-lg border-2 border-slate-200">Kategori: {{ $report->category->name }}</span>
                        <span class="bg-slate-100 px-3 py-1 rounded-lg border-2 border-slate-200">Wilayah: {{ $report->region->name }}</span>
                        <span class="bg-angkut-light px-3 py-1 rounded-lg border-2 border-angkut-deep">Prioritas: {{ $report->priority->label() }}</span>
                    </div>
                </div>

                <!-- PETA LOKASI -->
                <div>
                    <h4 class="font-fun font-bold text-angkut-deep mb-3 uppercase tracking-wider text-sm">Lokasi Persis (Navigasi)</h4>
                    <div id="map" class="w-full h-64 rounded-2xl border-4 border-angkut-deep shadow-inner z-0"></div>
                    <div class="mt-3 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 bg-slate-50 p-3 rounded-xl border-2 border-slate-200">
                        <p class="text-sm font-semibold text-slate-600">{{ $report->address ?? 'Alamat tidak tersedia' }}</p>
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $report->latitude }},{{ $report->longitude }}" target="_blank" class="bg-blue-500 hover:bg-blue-600 text-white font-bold text-sm px-4 py-2 rounded-lg border-2 border-angkut-deep shadow-cartoon-xs transition-colors whitespace-nowrap">
                            Buka Google Maps
                        </a>
                    </div>
                </div>

                <!-- Foto Laporan dari Warga -->
                @if($report->images->where('type', 'report')->count() > 0)
                    <div>
                        <h4 class="font-fun font-bold text-angkut-deep mb-3 uppercase tracking-wider text-sm">Foto dari Pelapor</h4>
                        <div class="flex gap-2 overflow-x-auto pb-2">
                            @foreach($report->images->where('type', 'report') as $img)
                                <img src="{{ Storage::url($img->path) }}" alt="Foto Laporan" class="h-32 w-auto rounded-xl border-3 border-angkut-deep object-cover shadow-cartoon-xs">
                            @endforeach
                        </div>
                    </div>
                @endif

                <hr class="border-t-4 border-slate-100">

                <!-- AREA AKSI -->
                <div class="bg-angkut-soft p-6 rounded-2xl border-3 border-angkut-deep">
                    
                    @if(!$report->activeAssignment->accepted_at)
                        <!-- TAMPILAN JIKA BELUM MENERIMA TUGAS -->
                        <h4 class="font-fun text-xl font-bold text-angkut-deep mb-2">Konfirmasi Tugas</h4>
                        <p class="text-sm font-semibold text-slate-600 mb-6">Anda ditugaskan untuk menangani laporan ini. Silakan konfirmasi untuk mulai menuju lokasi.</p>
                        
                        <form action="{{ route('petugas.tasks.accept', $report->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-angkut-pop hover:bg-yellow-400 text-angkut-deep font-fun text-lg font-extrabold px-8 py-4 border-4 border-angkut-deep rounded-xl shadow-cartoon transition-all hover:-translate-y-1 active:translate-y-1">
                                Terima Tugas & Menuju Lokasi
                            </button>
                        </form>
                    
                    @else
                        <!-- TAMPILAN JIKA SUDAH MENERIMA TUGAS (FORM SELESAI) -->
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-green-100 border-2 border-green-600 rounded-full flex items-center justify-center text-green-600 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-fun text-xl font-bold text-angkut-deep">Tugas Telah Diterima</h4>
                                <p class="text-xs font-bold text-slate-500">Diterima pada: {{ $report->activeAssignment->accepted_at->format('d M Y, H:i') }} WIB</p>
                            </div>
                        </div>

                        <p class="text-sm font-semibold text-slate-600 mb-4 mt-6">Jika sampah sudah selesai diangkut, unggah foto bukti di bawah ini untuk menyelesaikan tugas.</p>
                        
                        <form action="{{ route('petugas.tasks.complete', $report->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block font-fun font-bold text-angkut-deep mb-2">Upload Bukti (Wajib)</label>
                                <input type="file" name="evidence_image" required accept="image/*" class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium bg-white">
                            </div>
                            <div>
                                <label class="block font-fun font-bold text-angkut-deep mb-2">Catatan (Opsional)</label>
                                <input type="text" name="note" class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium" placeholder="Contoh: Sampah sudah diangkut ke TPA.">
                            </div>
                            <button type="submit" class="w-full bg-angkut-dark hover:bg-angkut-deep text-white font-fun text-lg font-extrabold px-8 py-3 border-3 border-angkut-deep rounded-xl shadow-cartoon transition-all hover:-translate-y-1" onclick="return confirm('Pastikan sampah sudah diangkut dan foto bukti sudah benar. Lanjutkan?')">
                                Selesaikan Tugas
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
@if($report->status !== \App\Enums\ReportStatus::Completed && $report->status !== \App\Enums\ReportStatus::Closed)
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let lat = {{ $report->latitude }};
            let lng = {{ $report->longitude }};
            var map = L.map('map').setView([lat, lng], 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
            L.marker([lat, lng]).addTo(map).bindPopup("<b>Lokasi Sampah</b><br>{{ $report->title }}").openPopup();
        });
    </script>
@endif
@endpush