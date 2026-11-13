@extends('layouts.admin')

@section('header', 'Assign Tugas')

@section('content')
<div class="bg-white border-4 border-angkut-deep rounded-3xl shadow-cartoon overflow-hidden">
    
    @if(session('success'))
        <div class="bg-green-100 border-b-4 border-angkut-deep text-green-800 font-bold p-4 text-center font-fun text-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border-b-4 border-angkut-deep text-red-800 font-bold p-4 text-center font-fun text-lg">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse font-sans">
            <thead>
                <tr class="bg-angkut-soft border-b-3 border-angkut-deep font-fun font-bold text-angkut-deep uppercase text-sm">
                    <th class="px-6 py-4">Tiket</th>
                    <th class="px-6 py-4">Laporan</th>
                    <th class="px-6 py-4">Pilih Tim</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-slate-100">
                @forelse($reports as $report)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-mono text-sm font-bold">{{ $report->tracking_code }}</td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-angkut-deep">{{ $report->title }}</p>
                            <p class="text-xs text-slate-500">Wilayah: {{ $report->region->name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.assignments.assign', $report->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <select name="team_id" class="border-3 border-angkut-deep rounded-xl px-3 py-2 text-sm font-bold font-fun focus:ring-0 focus:border-angkut-medium w-full max-w-xs shadow-cartoon-xs" required>
                                    <option value="">-- Pilih Tim --</option>
                                    @foreach($teams as $team)
                                        @if($team->region_id === $report->region_id)
                                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-angkut-medium text-white font-fun font-bold px-4 py-2 border-3 border-angkut-deep rounded-xl shadow-cartoon-xs hover:bg-angkut-dark hover:-translate-y-0.5 transition whitespace-nowrap">
                                    Assign
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-slate-500 font-fun font-bold text-lg">
                            Tidak ada laporan terverifikasi yang menunggu di-assign.
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