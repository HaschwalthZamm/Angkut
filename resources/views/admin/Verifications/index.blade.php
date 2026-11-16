@extends('layouts.admin') <!-- Sesuaikan dengan nama layout admin Anda -->

@section('content')
<div class="container-fluid" style="background-color: #f8f9fa; min-height: 100vh; padding: 20px;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 style="font-weight: 700; color: #333;">Verifikasi Laporan</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background-color: #d1fae5; color: #065f46; border: none; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <div class="table-responsive">
            <table class="table table-hover" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #eee; text-align: left;">
                        <th style="padding: 15px; color: #6b7280; font-weight: 600;">Tiket</th>
                        <th style="padding: 15px; color: #6b7280; font-weight: 600;">Laporan</th>
                        <th style="padding: 15px; color: #6b7280; font-weight: 600;">Kategori</th>
                        <th style="padding: 15px; color: #6b7280; font-weight: 600;">Wilayah</th>
                        <th style="padding: 15px; color: #6b7280; font-weight: 600;">Tanggal</th>
                        <th style="padding: 15px; color: #6b7280; font-weight: 600;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px; font-weight: 600; color: #f59e0b;">{{ $report->tracking_code }}</td>
                        <td style="padding: 15px;">
                            <div style="font-weight: 600; color: #111827;">{{ $report->title }}</div>
                            <div style="font-size: 12px; color: #6b7280;">Oleh: {{ $report->user ? $report->user->name : 'Anonim' }}</div>
                        </td>
                        <td style="padding: 15px;">
                            <span style="background-color: {{ $report->category->color ?? '#e5e7eb' }}20; color: {{ $report->category->color ?? '#374151' }}; padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                {{ $report->category->name }}
                            </span>
                        </td>
                        <td style="padding: 15px; color: #374151;">{{ $report->region->name ?? '-' }}</td>
                        <td style="padding: 15px; color: #6b7280;">{{ $report->created_at->format('d M Y') }}</td>
                        <td style="padding: 15px;">
                            <!-- Sesuaikan route 'admin.reports.show' dengan route detail laporan Anda -->
                            <a href="{{ route('admin.reports.show', $report->id) }}" style="background-color: #fbbf24; color: #000; text-decoration: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 13px;">
                                Periksa
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 30px; color: #6b7280;">
                            Tidak ada laporan yang menunggu verifikasi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div style="margin-top: 20px;">
            {{ $reports->links() }}
        </div>
    </div>
</div>
@endsection
@extends('layouts.admin')

@section('header', 'Verifikasi Laporan')

@section('content')
<div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden">
    
    @if(session('success'))
        <div class="bg-green-100 border-b-4 border-angkut-deep text-green-800 font-bold p-4 text-center font-fun text-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse font-sans">
            <thead>
                <tr class="bg-angkut-soft border-b-3 border-angkut-deep font-fun font-bold text-angkut-deep uppercase text-sm">
                    <th class="px-6 py-4">Tiket</th>
                    <th class="px-6 py-4">Laporan</th>
                    <th class="px-6 py-4">Pelapor</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-slate-100">
                @forelse($reports as $report)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-mono text-sm font-bold">{{ $report->tracking_code }}</td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-angkut-deep">{{ $report->title }}</p>
                            <p class="text-xs text-slate-500">{{ $report->category->name }} • {{ $report->region->name }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <p class="font-bold">{{ $report->reporter_name }}</p>
                            <p class="text-xs text-slate-500">{{ $report->reporter_phone }}</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Form Verifikasi -->
                                <form action="{{ route('admin.verifications.verify', $report->id) }}" method="POST" onsubmit="return confirm('Yakin ingin memverifikasi laporan ini?')">
                                    @csrf
                                    <button type="submit" class="bg-angkut-light text-angkut-deep font-fun font-bold px-4 py-2 border-2 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-angkut-pop hover:-translate-y-0.5 transition">
                                        Terima
                                    </button>
                                </form>

                                <!-- Form Tolak (Menggunakan JS Prompt untuk alasan) -->
                                <form action="{{ route('admin.verifications.reject', $report->id) }}" method="POST" onsubmit="event.preventDefault(); let reason = prompt('Masukkan alasan penolakan:'); if(reason != null && reason.trim() !== '') { this.reason.value = reason; this.submit(); }">
                                    @csrf
                                    <input type="hidden" name="reason" id="reason">
                                    <button type="submit" class="bg-rose-500 text-white font-fun font-bold px-4 py-2 border-2 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-rose-600 hover:-translate-y-0.5 transition">
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500 font-fun font-bold text-lg">
                            Belum ada laporan yang perlu diverifikasi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t-3 border-angkut-deep">
        {{ $reports->links() }}
    </div>
</div>
@endsection