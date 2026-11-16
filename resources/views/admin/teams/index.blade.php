@extends('layouts.admin')

@section('header', 'Manajemen Tim')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="font-fun text-xl font-bold text-angkut-deep">Daftar Tim Kebersihan</h2>
        <a href="{{ route('admin.teams.create') }}" class="bg-angkut-medium text-white font-fun font-bold px-6 py-3 border-3 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-angkut-dark hover:-translate-y-0.5 transition">
            Tambah Tim Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-4 border-angkut-deep text-green-800 font-bold p-4 rounded-2xl shadow-cartoon text-center font-fun">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse font-sans">
                <thead>
                    <tr class="bg-angkut-soft border-b-3 border-angkut-deep font-fun font-bold text-angkut-deep uppercase text-sm">
                        <th class="px-6 py-4">Nama Tim</th>
                        <th class="px-6 py-4">Kecamatan</th>
                        <th class="px-6 py-4">Ketua Tim</th>
                        <th class="px-6 py-4 text-center">Jumlah Anggota</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-slate-100">
                    @forelse($teams as $team)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <p class="font-bold text-angkut-deep">{{ $team->name }}</p>
                                <p class="text-xs font-mono text-slate-500">{{ $team->code }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold">{{ $team->region->name }}</td>
                            <td class="px-6 py-4 text-sm font-semibold">{{ $team->leader?->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-center font-bold">{{ $team->active_members_count }} Orang</td>
                            <td class="px-6 py-4">
                                <!-- PERBAIKAN: Menggunakan ->value untuk cek status dan ->label() untuk menampilkan -->
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-xl border-2 border-angkut-deep shadow-cartoon-xs {{ $team->status->value === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $team->status->label() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.teams.show', $team->id) }}" class="inline-block bg-angkut-light text-angkut-deep font-fun font-bold px-4 py-2 border-2 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-angkut-pop hover:-translate-y-0.5 transition">
                                    Kelola Tim
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500 font-fun font-bold text-lg">
                                Belum ada data tim.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t-3 border-angkut-deep">
            {{ $teams->links() }}
        </div>
    </div>
</div>
@endsection