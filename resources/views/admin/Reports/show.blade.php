@extends('layouts.admin')

@section('header', 'Detail Laporan')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    
    @if(session('success'))
        <div class="bg-green-100 border-4 border-angkut-deep text-green-800 font-bold p-4 rounded-2xl shadow-cartoon text-center font-fun text-lg">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 border-4 border-angkut-deep text-red-800 font-bold p-4 rounded-2xl shadow-cartoon font-fun">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- KOLOM KIRI: Info & Peta -->
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden">
                <div class="p-6 border-b-4 border-angkut-deep bg-angkut-soft flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                    <div>
                        <p class="text-sm font-bold text-slate-500 uppercase">Kode Tracking</p>
                        <p class="font-mono text-2xl font-black text-angkut-deep">{{ $report->tracking_code }}</p>
                    </div>
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
                    <span class="px-4 py-2 text-sm font-bold rounded-xl border-2 shadow-sm {{ $statusColor }}">
                        {{ $report->status->label() }}
                    </span>
                </div>

                <div class="p-6 space-y-6">
                    <div>
                        <h3 class="font-fun text-2xl font-bold text-angkut-deep mb-2">{{ $report->title }}</h3>
                        <p class="text-slate-600">{{ $report->description }}</p>
                    </div>

                    <!-- Peta -->
                    <div>
                        <h4 class="font-fun font-bold text-angkut-deep mb-2 text-sm uppercase">Lokasi Kejadian</h4>
                        <div id="map" class="w-full h-64 rounded-2xl border-4 border-angkut-deep shadow-inner z-0"></div>
                        <p class="text-sm font-semibold text-slate-600 mt-2">{{ $report->address ?? 'Alamat tidak tersedia' }}</p>
                    </div>

                    <!-- Foto -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-fun font-bold text-angkut-deep mb-2 text-sm uppercase">Foto Pelapor</h4>
                            @if($report->images->where('type', 'report')->count() > 0)
                                <div class="flex flex-col gap-2">
                                    @foreach($report->images->where('type', 'report') as $img)
                                        <a href="{{ Storage::url($img->path) }}" target="_blank">
                                            <img src="{{ Storage::url($img->path) }}" class="w-full h-40 object-cover rounded-xl border-3 border-angkut-deep shadow-cartoon-xs hover:scale-105 transition-transform">
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-slate-400 italic">Tidak ada foto.</p>
                            @endif
                        </div>
                        
                        @if($report->images->where('type', 'evidence')->count() > 0)
                        <div>
                            <h4 class="font-fun font-bold text-angkut-deep mb-2 text-sm uppercase">Bukti Petugas</h4>
                            <div class="flex flex-col gap-2">
                                @foreach($report->images->where('type', 'evidence') as $img)
                                    <a href="{{ Storage::url($img->path) }}" target="_blank">
                                        <img src="{{ Storage::url($img->path) }}" class="w-full h-40 object-cover rounded-xl border-3 border-angkut-deep shadow-cartoon-xs hover:scale-105 transition-transform">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: Aksi & Metadata -->
        <div class="space-y-6">
            
            <!-- PANEL AKSI ADMIN -->
            <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden">
                <div class="p-4 border-b-4 border-angkut-deep bg-slate-800 text-white">
                    <h3 class="font-fun text-lg font-bold">Aksi Admin</h3>
                </div>
                <div class="p-4 space-y-4">
                    
                    @if($report->status->value === 'pending')
                        <form action="{{ route('admin.verifications.verify', $report->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-angkut-medium text-white font-fun font-bold px-4 py-3 border-3 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-angkut-dark hover:-translate-y-0.5 transition">
                                ✅ Terima Laporan
                            </button>
                        </form>
                        <form action="{{ route('admin.verifications.reject', $report->id) }}" method="POST" onsubmit="event.preventDefault(); let reason = prompt('Masukkan alasan penolakan:'); if(reason != null && reason.trim() !== '') { this.reason.value = reason; this.submit(); }">
                            @csrf
                            <input type="hidden" name="reason" id="reason">
                            <button type="submit" class="w-full bg-rose-500 text-white font-fun font-bold px-4 py-3 border-3 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-rose-600 hover:-translate-y-0.5 transition">
                                ❌ Tolak Laporan
                            </button>
                        </form>
                    
                    @elseif($report->status->value === 'verified')
                        <form action="{{ route('admin.assignments.assign', $report->id) }}" method="POST" class="space-y-3">
                            @csrf
                            <label class="block font-fun font-bold text-angkut-deep text-sm">Pilih Tim Petugas</label>
                            <select name="team_id" required class="w-full border-3 border-angkut-deep rounded-xl px-3 py-2 text-sm font-bold focus:ring-0 focus:border-angkut-medium shadow-cartoon-xs">
                                <option value="">-- Pilih Tim --</option>
                                @foreach($availableTeams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="w-full bg-angkut-medium text-white font-fun font-bold px-4 py-3 border-3 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-angkut-dark hover:-translate-y-0.5 transition">
                                🚀 Assign Tugas
                            </button>
                        </form>
                        @if($availableTeams->isEmpty())
                            <p class="text-xs text-red-500 font-bold mt-2">*Tidak ada tim aktif di wilayah ini.</p>
                        @endif

                    @elseif($report->status->value === 'completed')
                        <form action="{{ route('admin.reports.close', $report->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-angkut-deep text-white font-fun font-bold px-4 py-3 border-3 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-slate-900 hover:-translate-y-0.5 transition" onclick="return confirm('Yakin ingin menutup laporan ini?')">
                                🔒 Tutup Laporan
                            </button>
                        </form>
                    @else
                        <div class="text-center py-4 bg-slate-50 rounded-xl border-2 border-slate-200">
                            <p class="text-sm font-semibold text-slate-500">Tidak ada aksi untuk status ini.</p>
                        </div>
                    @endif

                </div>
            </div>

            <!-- Detail Pelapor -->
            <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon p-6">
                <h3 class="font-fun font-bold text-angkut-deep mb-4 uppercase tracking-wider text-sm">Informasi Pelapor</h3>
                <div class="space-y-2 text-sm">
                    <p><span class="font-bold text-slate-500">Nama:</span> {{ $report->reporter_name }}</p>
                    <p><span class="font-bold text-slate-500">No HP:</span> {{ $report->reporter_phone }}</p>
                    <p><span class="font-bold text-slate-500">Tipe:</span> {{ $report->user_id ? 'Warga Terdaftar' : 'Guest (Tanpa Akun)' }}</p>
                </div>
            </div>

            <!-- Panel Feedback (Jika Ada) -->
            @if($report->feedback)
                <div class="bg-angkut-pop/20 border-4 border-angkut-deep rounded-3xl shadow-cartoon p-6">
                    <h3 class="font-fun font-bold text-angkut-deep mb-2 uppercase tracking-wider text-sm">Penilaian Warga</h3>
                    <div class="flex items-center gap-1 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $report->feedback->rating ? 'text-angkut-pop' : 'text-slate-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-sm italic text-slate-700">"{{ $report->feedback->comment ?? 'Tidak ada komentar.' }}"</p>
                </div>
            @endif

            <!-- Timeline -->
            <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon p-6">
                <h3 class="font-fun font-bold text-angkut-deep mb-4 uppercase tracking-wider text-sm">Riwayat Status</h3>
                <div class="space-y-4 border-l-4 border-angkut-light ml-2 pl-3">
                    @foreach($report->statusHistories as $history)
                        <div class="relative">
                            <div class="absolute -left-[19px] top-1 w-3 h-3 bg-angkut-medium border-2 border-angkut-deep rounded-full"></div>
                            <p class="font-bold text-angkut-dark text-xs">{{ $history->status->label() }}</p>
                            <p class="text-[11px] text-slate-500">{{ $history->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let lat = {{ $report->latitude }};
        let lng = {{ $report->longitude }};
        var map = L.map('map').setView([lat, lng], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);
        L.marker([lat, lng]).addTo(map).bindPopup("<b>Lokasi Sampah</b>").openPopup();
    });
</script>
@endpush