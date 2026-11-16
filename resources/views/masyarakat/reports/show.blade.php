@extends('layouts.masyarakat')

@section('header', 'Detail Laporan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    
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

    <!-- Kartu Utama -->
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
                <div class="bg-slate-50 p-4 rounded-xl border-2 border-slate-200 sm:col-span-2">
                    <p class="text-xs font-bold text-slate-500 uppercase mb-1">Alamat Lokasi</p>
                    <p class="font-bold text-angkut-deep">{{ $report->address ?? 'Lihat koordinat' }}</p>
                    <p class="text-xs text-slate-500 mt-1">Koordinat: {{ $report->latitude }}, {{ $report->longitude }}</p>
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

    <!-- BAGIAN FEEDBACK & RATING -->
    @if($report->status->value === 'completed')
        <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden">
            <div class="p-6 border-b-4 border-angkut-deep bg-angkut-pop">
                <h3 class="font-fun text-xl font-bold text-angkut-deep">Penilaian Layanan</h3>
                <p class="text-sm font-semibold text-angkut-dark">Bagaimana kinerja petugas kami dalam menangani laporan ini?</p>
            </div>
            
            <div class="p-6">
                @if($report->feedback)
                    <!-- Tampilan Jika Sudah Feedback -->
                    <div class="text-center space-y-4">
                        <div class="flex justify-center gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-10 h-10 {{ $i <= $report->feedback->rating ? 'text-angkut-pop' : 'text-slate-200' }} drop-shadow-md" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-lg font-bold text-angkut-deep italic">"{{ $report->feedback->comment ?? 'Tanpa komentar.' }}"</p>
                        <p class="text-xs text-slate-500">Diberikan pada {{ $report->feedback->created_at->format('d M Y') }}</p>
                    </div>
                @else
                    <!-- Form Input Feedback -->
                    <form action="{{ route('masyarakat.reports.feedback', $report->id) }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="text-center">
                            <p class="font-bold text-slate-600 mb-3">Pilih Rating (1-5 Bintang)</p>
                            <div class="flex justify-center gap-2 flex-row-reverse">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden peer" required />
                                    <label for="star{{ $i }}" class="cursor-pointer text-slate-300 hover:text-angkut-pop peer-checked:text-angkut-pop transition-colors">
                                        <svg class="w-12 h-12 drop-shadow-md" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                        </div>
                        <div>
                            <label class="block font-fun font-bold text-angkut-deep mb-2">Komentar (Opsional)</label>
                            <textarea name="comment" rows="3" class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium" placeholder="Tuliskan pengalaman atau saran Anda..."></textarea>
                        </div>
                        <button type="submit" class="w-full bg-angkut-medium hover:bg-angkut-dark text-white font-fun text-lg font-extrabold px-8 py-3 border-3 border-angkut-deep rounded-xl shadow-cartoon transition-all hover:-translate-y-1">
                            Kirim Penilaian
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @endif
    
    <div class="text-center pb-8">
        <a href="{{ route('masyarakat.reports.index') }}" class="text-angkut-medium font-bold hover:underline font-fun">Kembali ke Riwayat Laporan</a>
    </div>
</div>
@endsection