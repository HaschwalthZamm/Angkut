<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\StoreTeamRequest;
use App\Http\Requests\Team\UpdateTeamRequest;
use App\Models\Region;
use App\Models\Team;
use App\Services\TeamService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        return view('admin.teams.index', [
            'teams' => Team::query()->with('region')->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.teams.create', [
            'regions' => Region::query()->orderBy('name')->get(),
        ]);
    }

    public function store(StoreTeamRequest $request, TeamService $teamService): RedirectResponse
    {
        $teamService->create($request->validated());

        return redirect()->route('admin.teams.index')->with('status', 'Tim dibuat.');
    }

    public function edit(Team $team): View
    {
        return view('admin.teams.edit', [
            'team' => $team,
            'regions' => Region::query()->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateTeamRequest $request, Team $team, TeamService $teamService): RedirectResponse
    {
        $teamService->update($team, $request->validated());

        return redirect()->route('admin.teams.index')->with('status', 'Tim diperbarui.');
    }
}
