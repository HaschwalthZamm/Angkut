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