@extends('layouts.petugas')

@section('header', 'Tugas Aktif')

@section('content')
<div class="space-y-6">
    
    @if(!$team)
        <div class="bg-red-100 border-4 border-red-500 text-red-800 font-bold p-6 rounded-2xl shadow-cartoon text-center font-fun text-xl">
            Anda belum tergabung dalam tim manapun.
        </div>
    @else
        <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden">
            <div class="p-6 border-b-4 border-angkut-deep bg-angkut-dark text-white flex justify-between items-center">
                <h3 class="font-fun text-lg font-bold">Daftar Tugas: {{ $team->name }}</h3>
            </div>
            
            @if(session('success'))
                <div class="bg-green-100 border-b-4 border-angkut-deep text-green-800 font-bold p-4 text-center font-fun">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse font-sans">
                    <thead>
                        <tr class="bg-angkut-soft border-b-3 border-angkut-deep font-fun font-bold text-angkut-deep uppercase text-sm">
                            <th class="px-6 py-4">Tiket</th>
                            <th class="px-6 py-4">Laporan</th>
                            <th class="px-6 py-4">Prioritas</th>
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
                                <td class="px-6 py-4">
                                    @if($report->priority->value === 'urgent')
                                        <span class="text-red-600 font-bold text-sm">Mendesak</span>
                                    @elseif($report->priority->value === 'high')
                                        <span class="text-orange-500 font-bold text-sm">Tinggi</span>
                                    @else
                                        <span class="text-slate-500 font-bold text-sm">{{ $report->priority->label() }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-xl border-2 border-angkut-deep shadow-cartoon-xs bg-slate-100 text-slate-800">
                                        {{ $report->status->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('petugas.tasks.show', $report->id) }}" class="inline-block bg-angkut-medium text-white font-fun font-bold px-4 py-2 border-2 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-angkut-dark hover:-translate-y-0.5 transition">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-fun font-bold text-lg">
                                    Belum ada tugas yang diberikan ke tim Anda.
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