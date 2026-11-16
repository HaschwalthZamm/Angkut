@extends('layouts.admin')

@section('header', 'Kelola Tim')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    
    @if(session('success'))
        <div class="bg-green-100 border-4 border-angkut-deep text-green-800 font-bold p-4 rounded-2xl shadow-cartoon text-center font-fun">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 border-4 border-angkut-deep text-red-800 font-bold p-4 rounded-2xl shadow-cartoon font-fun">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Info Tim -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden">
                <div class="p-6 border-b-4 border-angkut-deep bg-angkut-dark text-white">
                    <h2 class="font-fun text-xl font-bold">{{ $team->name }}</h2>
                    <p class="text-sm font-mono text-angkut-light mt-1">{{ $team->code }}</p>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase">Kecamatan</p>
                        <p class="font-bold text-angkut-deep">{{ $team->region->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase">Ketua Tim</p>
                        <p class="font-bold text-angkut-deep">{{ $team->leader?->name ?? 'Belum diatur' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase">Status</p>
                        <!-- PERBAIKAN: Menggunakan ->value dan ->label() -->
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-xl border-2 border-angkut-deep shadow-cartoon-xs {{ $team->status->value === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $team->status->label() }}
                        </span>
                    </div>
                    <div class="pt-4 border-t-2 border-slate-100">
                        <a href="{{ route('admin.teams.edit', $team->id) }}" class="w-full block text-center bg-angkut-pop text-angkut-deep font-fun font-bold px-4 py-2 border-2 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-yellow-400 hover:-translate-y-0.5 transition">
                            Edit Data Tim
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Anggota Tim -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Form Tambah Anggota -->
            <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon p-6">
                <h3 class="font-fun font-bold text-angkut-deep mb-4">Tambah Petugas ke Tim</h3>
                <form action="{{ route('admin.teams.addMember', $team->id) }}" method="POST" class="flex flex-col sm:flex-row gap-4 items-end">
                    @csrf
                    <div class="flex-1 w-full">
                        <label class="block font-fun font-bold text-angkut-deep mb-2 text-sm">Pilih Petugas (Yang belum punya tim)</label>
                        <select name="user_id" required class="w-full border-3 border-angkut-deep rounded-xl px-3 py-2 text-sm font-semibold focus:ring-0 focus:border-angkut-medium bg-white">
                            <option value="">-- Pilih Petugas --</option>
                            @foreach($availablePetugas as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->phone }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full sm:w-auto bg-angkut-medium text-white font-fun font-bold px-6 py-2 border-3 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-angkut-dark hover:-translate-y-0.5 transition whitespace-nowrap">
                        Tambahkan
                    </button>
                </form>
            </div>

            <!-- Tabel Anggota -->
            <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden">
                <div class="p-4 border-b-4 border-angkut-deep bg-slate-50">
                    <h3 class="font-fun font-bold text-angkut-deep">Anggota Tim Saat Ini</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse font-sans">
                        <thead>
                            <tr class="bg-white border-b-2 border-slate-200 font-fun font-bold text-slate-500 uppercase text-xs">
                                <th class="px-6 py-4">Nama Petugas</th>
                                <th class="px-6 py-4">Peran</th>
                                <th class="px-6 py-4">No HP</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-slate-100">
                            @forelse($team->activeMembers as $member)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 font-bold text-angkut-deep">{{ $member->user->name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs font-bold uppercase {{ $member->role_in_team === 'leader' ? 'text-angkut-orange' : 'text-slate-500' }}">
                                            {{ $member->role_in_team }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold">{{ $member->user->phone }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('admin.teams.removeMember', ['team' => $team->id, 'user' => $member->user_id]) }}" method="POST" onsubmit="return confirm('Keluarkan petugas ini dari tim?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 font-bold text-sm hover:underline">Keluarkan</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-500 font-semibold">
                                        Belum ada anggota di tim ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection