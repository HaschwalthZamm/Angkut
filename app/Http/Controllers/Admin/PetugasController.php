<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PetugasController extends Controller
{
    public function index(): View
    {
        return view('admin.petugas.index', [
            'petugas' => User::role(UserRole::Petugas->value)->with('petugasProfile.region')->paginate(15),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'employee_number' => ['required', 'string', 'unique:petugas_profiles,employee_number'],
            'region_id' => ['nullable', 'exists:regions,id'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole(UserRole::Petugas);
        $user->petugasProfile()->create([
            'employee_number' => $data['employee_number'],
            'region_id' => $data['region_id'] ?? null,
        ]);

        return back()->with('status', 'Petugas ditambahkan.');
    }

    public function create(): View
    {
        return view('admin.petugas.create', [
            'regions' => Region::query()->orderBy('name')->get(),
        ]);
    }
}
