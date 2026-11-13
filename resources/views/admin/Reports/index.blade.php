@extends('layouts.admin')

@section('header', 'Semua Laporan')

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
                    <th class="px-6 py-4">Wilayah</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Ditangani Oleh</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-slate-100">
                @forelse($reports as $report)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-mono text-sm font-bold">{{ $report->tracking_code }}</td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-angkut-deep">{{ $report->title }}</p>
                            <p class="text-xs text-slate-500">{{ $report->category->name }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold">{{ $report->region->name }}</td>
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
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-xl border-2 border-angkut-deep shadow-cartoon-xs {{ $statusColor }}">
                                {{ $report->status->label() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-angkut-dark">
                            {{ $report->activeAssignment?->team?->name ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-fun font-bold text-lg">
                            Belum ada data laporan.
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