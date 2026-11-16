<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with(['region', 'leader'])
            ->withCount('activeMembers')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        $regions = Region::where('is_active', true)->orderBy('name')->get();
        $petugas = User::role('petugas')->orderBy('name')->get();
        
        return view('admin.teams.create', compact('regions', 'petugas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50|unique:teams,code',
            'region_id' => 'required|exists:regions,id',
            'leader_id' => 'nullable|exists:users,id',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        $validated['status'] = 'active';

        $team = Team::create($validated);

        // Jika leader dipilih, otomatis masukkan ke anggota tim
        if ($team->leader_id) {
            TeamMember::create([
                'team_id' => $team->id,
                'user_id' => $team->leader_id,
                'role_in_team' => 'leader',
                'joined_at' => now(),
            ]);
        }

        return redirect()->route('admin.teams.index')->with('success', 'Tim berhasil dibuat.');
    }

    public function show(Team $team)
    {
        $team->load(['region', 'leader', 'activeMembers.user']);
        
        // Ambil petugas yang BELUM masuk ke tim manapun
        $availablePetugas = User::role('petugas')
            ->whereDoesntHave('teamMemberships', function ($query) {
                $query->whereNull('left_at');
            })
            ->orderBy('name')
            ->get();

        return view('admin.teams.show', compact('team', 'availablePetugas'));
    }

    public function edit(Team $team)
    {
        $regions = Region::where('is_active', true)->orderBy('name')->get();
        $petugas = User::role('petugas')->orderBy('name')->get();
        
        return view('admin.teams.edit', compact('team', 'regions', 'petugas'));
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => ['required', 'string', 'max:50', Rule::unique('teams')->ignore($team->id)],
            'region_id' => 'required|exists:regions,id',
            'leader_id' => 'nullable|exists:users,id',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,suspended',
            'description' => 'nullable|string',
        ]);

        $team->update($validated);

        return redirect()->route('admin.teams.index')->with('success', 'Data tim berhasil diperbarui.');
    }

    public function destroy(Team $team)
    {
        if ($team->activeAssignments()->count() > 0) {
            return back()->withErrors(['error' => 'Tidak bisa menghapus tim yang masih memiliki tugas aktif.']);
        }

        $team->delete();
        return redirect()->route('admin.teams.index')->with('success', 'Tim berhasil dihapus.');
    }

    public function addMember(Request $request, Team $team)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Cek apakah user sudah punya tim aktif
        $activeMembership = TeamMember::where('user_id', $validated['user_id'])
            ->whereNull('left_at')
            ->first();

        if ($activeMembership) {
            return back()->withErrors(['error' => 'Petugas ini sudah tergabung dalam tim lain.']);
        }

        TeamMember::create([
            'team_id' => $team->id,
            'user_id' => $validated['user_id'],
            'role_in_team' => 'member',
            'joined_at' => now(),
        ]);

        return back()->with('success', 'Petugas berhasil ditambahkan ke tim.');
    }

    public function removeMember(Team $team, User $user)
    {
        $membership = TeamMember::where('team_id', $team->id)
            ->where('user_id', $user->id)
            ->whereNull('left_at')
            ->first();

        if ($membership) {
            $membership->update(['left_at' => now()]);
            
            // Jika yang keluar adalah leader, hapus status leader di tim
            if ($team->leader_id === $user->id) {
                $team->update(['leader_id' => null]);
            }
        }

        return back()->with('success', 'Petugas berhasil dikeluarkan dari tim.');
    }
}