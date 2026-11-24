@extends('layouts.guest')

@section('content')
<div class="max-w-2xl mx-auto">
    
    <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon-lg overflow-hidden">
        
        <!-- Header Status -->
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
            <!-- Info Laporan -->
            <div>
                <h3 class="font-fun text-2xl font-bold text-angkut-deep mb-2">{{ $report->title }}</h3>
                <p class="text-slate-600">{{ $report->description }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-slate-50 p-4 rounded-xl border-2 border-slate-200">
                    <p class="text-xs font-bold text-slate-500 uppercase mb-1">Kategori Sampah</p>
                    <p class="font-bold text-angkut-deep">{{ $report->category->name }}</p>
                </div>
                <div class="bg-slate-50 p-4 rounded-xl border-2 border-slate-200">
                    <p class="text-xs font-bold text-slate-500 uppercase mb-1">Kecamatan</p>
                    <p class="font-bold text-angkut-deep">{{ $report->region->name }}</p>
                </div>
            </div>

            <!-- Foto -->
            @if($report->images->count() > 0)
                <div>
                    <h4 class="font-fun font-bold text-angkut-deep mb-3">Foto Laporan & Bukti</h4>
                    <div class="flex gap-2 overflow-x-auto pb-2">
                        @foreach($report->images as $img)
                            <img src="{{ Storage::url($img->path) }}" alt="Foto" class="h-32 w-auto rounded-xl border-3 border-angkut-deep object-cover shadow-cartoon-xs">
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Timeline -->
            <div class="pt-4 border-t-4 border-slate-100">
                <h4 class="font-fun font-bold text-angkut-deep mb-4 uppercase tracking-wider">Riwayat Status</h4>
                <div class="space-y-4 border-l-4 border-angkut-light ml-3 pl-4">
                    @foreach($report->statusHistories as $history)
                        <div class="relative">
                            <div class="absolute -left-[23px] top-1 w-4 h-4 bg-angkut-medium border-2 border-angkut-deep rounded-full"></div>
                            <p class="font-bold text-angkut-dark text-sm">{{ $history->status->label() }}</p>
                            <p class="text-xs text-slate-500">{{ $history->created_at->format('d M Y, H:i') }} WIB</p>
                            <p class="text-sm text-slate-600 mt-1">{{ $history->note }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-6 pb-8">
        <a href="{{ url('/') }}" class="text-angkut-medium font-bold hover:underline font-fun">Kembali ke Beranda</a>
    </div>
</div>
@endsection