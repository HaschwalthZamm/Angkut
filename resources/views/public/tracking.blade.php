@extends('layouts.guest')

@section('content')
<div class="max-w-3xl mx-auto">
    
    @if(session('success'))
        <div class="bg-green-100 border-4 border-angkut-deep text-green-800 font-bold p-6 rounded-2xl shadow-cartoon mb-8 text-center font-fun text-xl">
            🎉 {{ session('success') }}
        </div>
    @endif

    <!-- Form Pencarian -->
    <div class="bg-white p-6 rounded-2xl border-4 border-angkut-deep shadow-cartoon mb-8">
        <div class="text-center mb-6">
            <h2 class="font-fun text-3xl font-extrabold text-angkut-deep mb-2">Lacak Laporan Anda</h2>
            <p class="text-slate-500 font-semibold">Masukkan nomor HP yang Anda gunakan saat melapor.</p>
        </div>

        <form action="{{ route('public.tracking.track') }}" method="POST" class="flex flex-col sm:flex-row gap-4 items-end">
            @csrf
            <div class="flex-1 w-full">
                <label class="block font-fun font-bold text-angkut-deep mb-2">Nomor HP Pelapor</label>
                <input type="text" name="phone" value="{{ $phone }}" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-bold text-lg focus:ring-0 focus:border-angkut-medium" placeholder="0812xxxxxx">
                @if ($errors->has('phone'))
                    <p class="text-red-500 text-sm font-bold mt-2">{{ $errors->first('phone') }}</p>
                @endif
            </div>
            <button type="submit" class="w-full sm:w-auto bg-angkut-medium hover:bg-angkut-dark text-white font-fun text-lg font-extrabold px-8 py-3 border-3 border-angkut-deep rounded-xl shadow-cartoon transition-all hover:-translate-y-1">
                Cari Laporan
            </button>
        </form>
    </div>

    <!-- Hasil Pencarian (Daftar Laporan) -->
    @if($reports->count() > 0)
        <div class="space-y-6">
            <h3 class="font-fun text-xl font-bold text-angkut-deep">Ditemukan {{ $reports->count() }} Laporan:</h3>
            
            @foreach($reports as $report)
                <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden">
                    <div class="p-4 border-b-4 border-angkut-deep bg-angkut-soft flex justify-between items-center">
                        <div>
                            <p class="font-mono text-sm font-black text-angkut-deep">{{ $report->tracking_code }}</p>
                            <p class="text-xs font-semibold text-slate-500">{{ $report->created_at->format('d M Y, H:i') }} WIB</p>
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
                        <span class="px-3 py-1 text-xs font-bold rounded-xl border-2 shadow-sm {{ $statusColor }}">
                            {{ $report->status->label() }}
                        </span>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <h3 class="font-fun text-xl font-bold text-angkut-deep">{{ $report->title }}</h3>
                            <p class="text-sm text-slate-600 mt-1">{{ $report->description }}</p>
                        </div>

                        <div class="bg-slate-50 p-3 rounded-xl border-2 border-slate-200 text-sm">
                            <p><span class="font-bold">Kategori:</span> {{ $report->category->name }}</p>
                            <p class="mt-1"><span class="font-bold">Tim Penanganan:</span> {{ $report->activeAssignment?->team?->name ?? 'Belum Ditugaskan' }}</p>
                        </div>

                        <!-- Timeline Ringkas -->
                        <div class="pt-2">
                            <div class="space-y-3 border-l-4 border-angkut-light ml-2 pl-3">
                                @foreach($report->statusHistories->take(3) as $history)
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
            @endforeach
        </div>
    @endif
</div>
@endsection