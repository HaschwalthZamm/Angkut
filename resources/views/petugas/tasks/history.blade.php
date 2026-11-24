@extends('layouts.petugas')

@section('header', 'Riwayat Tugas')

@section('content')
<div class="space-y-6">
    
    @if(!$team)
        <div class="bg-red-100 border-4 border-red-500 text-red-800 font-bold p-6 rounded-2xl shadow-cartoon text-center font-fun text-xl">
            Anda belum tergabung dalam tim manapun.
        </div>
    @else
        <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden">
            <div class="p-6 border-b-4 border-angkut-deep bg-angkut-dark text-white flex justify-between items-center">
                <h3 class="font-fun text-lg font-bold">Riwayat Tugas: {{ $team->name }}</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse font-sans">
                    <thead>
                        <tr class="bg-angkut-soft border-b-3 border-angkut-deep font-fun font-bold text-angkut-deep uppercase text-sm">
                            <th class="px-6 py-4">Tiket</th>
                            <th class="px-6 py-4">Laporan</th>
                            <th class="px-6 py-4">Tanggal Selesai</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-slate-100">
                        @forelse($reports as $report)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-mono text-sm font-bold">{{ $report->tracking_code }}</td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-angkut-deep">{{ $report->title }}</p>
                                    <p class="text-xs text-slate-500">{{ $report->region->name }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold">
                                    {{ $report->completed_at ? $report->completed_at->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-xl border-2 border-angkut-deep shadow-cartoon-xs bg-green-100 text-green-800">
                                        {{ $report->status->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('petugas.tasks.show', $report->id) }}" class="inline-block bg-slate-200 text-slate-700 font-fun font-bold px-4 py-2 border-2 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-slate-300 hover:-translate-y-0.5 transition">
                                        Lihat Bukti
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-fun font-bold text-lg">
                                    Belum ada riwayat tugas yang diselesaikan.
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
    @endif
</div>
@endsection