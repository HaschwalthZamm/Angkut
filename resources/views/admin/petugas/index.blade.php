@extends('layouts.admin')

@section('header', 'Data Petugas')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="font-fun text-xl font-bold text-angkut-deep">Daftar Akun Petugas</h2>
        <a href="{{ route('admin.petugas.create') }}" class="bg-angkut-medium text-white font-fun font-bold px-6 py-3 border-3 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-angkut-dark hover:-translate-y-0.5 transition">
            Tambah Petugas Baru
        </a>
    </div>

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

    <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse font-sans">
                <thead>
                    <tr class="bg-angkut-soft border-b-3 border-angkut-deep font-fun font-bold text-angkut-deep uppercase text-sm">
                        <th class="px-6 py-4">Nama Petugas</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">Tim Saat Ini</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-slate-100">
                    @forelse($petugas as $p)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <p class="font-bold text-angkut-deep">{{ $p->name }}</p>
                                <p class="text-xs font-mono text-slate-500">ID: {{ $p->id }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <p class="font-semibold">{{ $p->email }}</p>
                                <p class="text-xs text-slate-500">{{ $p->phone }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold">
                                @if($p->activeTeamMember)
                                    <span class="bg-angkut-light text-angkut-deep px-2 py-1 rounded-lg border border-angkut-deep">
                                        {{ $p->activeTeamMember->team->name }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">Belum punya tim</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-xl border-2 border-angkut-deep shadow-cartoon-xs {{ $p->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $p->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.petugas.edit', $p->id) }}" class="bg-angkut-light text-angkut-deep font-fun font-bold px-3 py-1.5 border-2 border-angkut-deep rounded-lg shadow-cartoon-xs hover:bg-angkut-pop transition text-xs">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.petugas.toggleStatus', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Ubah status akun petugas ini?')">
                                        @csrf
                                        <button type="submit" class="bg-slate-200 text-slate-700 font-fun font-bold px-3 py-1.5 border-2 border-angkut-deep rounded-lg shadow-cartoon-xs hover:bg-slate-300 transition text-xs">
                                            {{ $p->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-fun font-bold text-lg">
                                Belum ada data petugas. Silakan tambah petugas baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t-3 border-angkut-deep">
            {{ $petugas->links() }}
        </div>
    </div>
</div>
@endsection