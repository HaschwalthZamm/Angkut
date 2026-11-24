<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = User::role(UserRole::Petugas->value)
            ->with(['activeTeamMember.team'])
            ->orderBy('name')
            ->paginate(10);

        return view('admin.petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('admin.petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone'    => ['required', 'string', 'max:20', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'phone.unique' => 'Nomor HP sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $this->normalizePhone($request->phone),
            'password' => $request->password,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $user->assignRole(UserRole::Petugas->value);

        return redirect()->route('admin.petugas.index')->with('success', 'Akun Petugas berhasil dibuat.');
    }

    public function edit(User $user)
    {
        // Pastikan yang diedit adalah benar-benar petugas
        if (!$user->hasRole(UserRole::Petugas->value)) {
            abort(404);
        }

        // Kita passing sebagai $petugas ke view agar konsisten dengan view edit
        return view('admin.petugas.edit', ['petugas' => $user]);
    }

    public function update(Request $request, User $user)
    {
        if (!$user->hasRole(UserRole::Petugas->value)) {
            abort(404);
        }

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone'    => ['required', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ], [
            'phone.unique' => 'Nomor HP sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $this->normalizePhone($request->phone);
        
        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $user->save();

        return redirect()->route('admin.petugas.index')->with('success', 'Data Petugas berhasil diperbarui.');
    }

    public function toggleStatus(User $user)
    {
        if (!$user->hasRole(UserRole::Petugas->value)) {
            abort(404);
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Akun Petugas berhasil {$status}.");
    }

    public function destroy(User $user)
    {
        if ($user->activeTeamMember) {
            return back()->withErrors(['error' => 'Tidak bisa menghapus petugas yang masih tergabung dalam tim.']);
        }

        $user->delete();
        return redirect()->route('admin.petugas.index')->with('success', 'Akun Petugas berhasil dihapus.');
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);
        if (str_starts_with($phone, '62')) {
            $phone = '0' . substr($phone, 2);
        }
        if (!str_starts_with($phone, '0')) {
            $phone = '0' . $phone;
        }
        return $phone;
    }
}