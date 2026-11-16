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

    <!-- Kartu Utama -->
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
                <div class="mt-3 flex justify-between items-center bg-slate-50 p-3 rounded-xl border-2 border-slate-200">
                    <p class="text-sm font-semibold text-slate-600">{{ $report->address ?? 'Alamat tidak tersedia' }}</p>
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $report->latitude }},{{ $report->longitude }}" target="_blank" class="bg-blue-500 text-white font-bold text-sm px-4 py-2 rounded-lg border-2 border-angkut-deep shadow-cartoon-xs hover:bg-blue-600">Buka Google Maps</a>
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

            <!-- AKSI PETUGAS -->
            <div class="bg-angkut-soft p-6 rounded-2xl border-3 border-angkut-deep">
                <h4 class="font-fun text-xl font-bold text-angkut-deep mb-4">Ubah Status Tugas</h4>
                
                <!-- Jika belum di-accept -->
                @if(!$report->activeAssignment->accepted_at)
                    <form action="{{ route('petugas.tasks.accept', $report->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-angkut-pop hover:bg-yellow-400 text-angkut-deep font-fun text-lg font-extrabold px-8 py-3 border-3 border-angkut-deep rounded-xl shadow-cartoon transition-all hover:-translate-y-1">
                            ✅ Terima Tugas & Menuju Lokasi
                        </button>
                    </form>
                
                <!-- Jika sudah accept tapi belum start -->
                @elseif($report->status->value === 'assigned')
                    <form action="{{ route('petugas.tasks.start', $report->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-angkut-orange hover:bg-orange-600 text-white font-fun text-lg font-extrabold px-8 py-3 border-3 border-angkut-deep rounded-xl shadow-cartoon transition-all hover:-translate-y-1">
                            🚀 Mulai Menangani (Sampah Sedang Diangkut)
                        </button>
                    </form>

                <!-- Jika sedang on_progress -->
                @elseif($report->status->value === 'on_progress')
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
                        <button type="submit" class="w-full bg-angkut-dark hover:bg-angkut-deep text-white font-fun text-lg font-extrabold px-8 py-3 border-3 border-angkut-deep rounded-xl shadow-cartoon transition-all hover:-translate-y-1" onclick="return confirm('Pastikan sampah sudah diangkut. Lanjutkan?')">
                            🎉 Selesaikan Tugas
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let lat = {{ $report->latitude }};
        let lng = {{ $report->longitude }};

        var map = L.map('map').setView([lat, lng], 16); // Zoom 16 lebih dekat

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map)
            .bindPopup("<b>Lokasi Sampah</b><br>{{ $report->title }}")
            .openPopup();
    });
</script>
@endpush