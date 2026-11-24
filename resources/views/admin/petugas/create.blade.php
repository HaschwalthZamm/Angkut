@extends('layouts.admin')

@section('header', 'Tambah Petugas')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden">
        <div class="p-6 border-b-4 border-angkut-deep bg-angkut-soft">
            <h2 class="font-fun text-xl font-bold text-angkut-deep">Formulir Petugas Baru</h2>
        </div>

        <form action="{{ route('admin.petugas.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            @if($errors->any())
                <div class="bg-red-100 border-3 border-red-500 text-red-700 p-4 rounded-xl font-bold text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block font-fun font-bold text-angkut-deep mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium" placeholder="Masukkan nama petugas">
                </div>

                <div>
                    <label class="block font-fun font-bold text-angkut-deep mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium" placeholder="petugas@angkut.id">
                </div>

                <div>
                    <label class="block font-fun font-bold text-angkut-deep mb-2">Nomor HP</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium" placeholder="0812xxxxxx">
                </div>

                <div>
                    <label class="block font-fun font-bold text-angkut-deep mb-2">Password</label>
                    <input type="password" name="password" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium" placeholder="Minimal 8 karakter">
                </div>

                <div>
                    <label class="block font-fun font-bold text-angkut-deep mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium" placeholder="Ulangi password">
                </div>
            </div>

            <div class="pt-4 border-t-4 border-slate-100 flex justify-end gap-4">
                <a href="{{ route('admin.petugas.index') }}" class="bg-slate-200 text-slate-700 font-fun font-bold px-6 py-3 border-3 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-slate-300 hover:-translate-y-0.5 transition">
                    Batal
                </a>
                <button type="submit" class="bg-angkut-medium text-white font-fun font-bold px-6 py-3 border-3 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-angkut-dark hover:-translate-y-0.5 transition">
                    Simpan Akun Petugas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection