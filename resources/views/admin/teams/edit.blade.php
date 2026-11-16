@extends('layouts.admin')

@section('header', 'Edit Tim')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden">
        <div class="p-6 border-b-4 border-angkut-deep bg-angkut-soft">
            <h2 class="font-fun text-xl font-bold text-angkut-deep">Formulir Edit Tim</h2>
        </div>

        <form action="{{ route('admin.teams.update', $team->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
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
                    <label class="block font-fun font-bold text-angkut-deep mb-2">Nama Tim</label>
                    <input type="text" name="name" value="{{ old('name', $team->name) }}" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium">
                </div>

                <div>
                    <label class="block font-fun font-bold text-angkut-deep mb-2">Kode Tim</label>
                    <input type="text" name="code" value="{{ old('code', $team->code) }}" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-mono font-bold focus:ring-0 focus:border-angkut-medium uppercase">
                </div>

                <div>
                    <label class="block font-fun font-bold text-angkut-deep mb-2">Kecamatan Tugas</label>
                    <select name="region_id" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium bg-white">
                        @foreach($regions as $r)
                            <option value="{{ $r->id }}" {{ old('region_id', $team->region_id) == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-fun font-bold text-angkut-deep mb-2">Status Tim</label>
                    <select name="status" required class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium bg-white">
                        <option value="active" {{ old('status', $team->status->value) == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $team->status->value) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="suspended" {{ old('status', $team->status->value) == 'suspended' ? 'selected' : '' }}>Ditangguhkan</option>
                    </select>
                </div>

                <div>
                    <label class="block font-fun font-bold text-angkut-deep mb-2">Ketua Tim</label>
                    <select name="leader_id" class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium bg-white">
                        <option value="">-- Pilih Ketua --</option>
                        @foreach($petugas as $p)
                            <option value="{{ $p->id }}" {{ old('leader_id', $team->leader_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block font-fun font-bold text-angkut-deep mb-2">Nomor Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $team->phone) }}" class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium">
                </div>

                <div class="md:col-span-2">
                    <label class="block font-fun font-bold text-angkut-deep mb-2">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full border-3 border-angkut-deep rounded-xl px-4 py-3 font-semibold focus:ring-0 focus:border-angkut-medium">{{ old('description', $team->description) }}</textarea>
                </div>
            </div>

            <div class="pt-4 border-t-4 border-slate-100 flex justify-end gap-4">
                <a href="{{ route('admin.teams.show', $team->id) }}" class="bg-slate-200 text-slate-700 font-fun font-bold px-6 py-3 border-3 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-slate-300 hover:-translate-y-0.5 transition">
                    Batal
                </a>
                <button type="submit" class="bg-angkut-medium text-white font-fun font-bold px-6 py-3 border-3 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-angkut-dark hover:-translate-y-0.5 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection