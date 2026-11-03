<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegionController extends Controller
{
    public function index(): View
    {
        return view('admin.regions.index', [
            'regions' => Region::query()->orderBy('name')->paginate(20),
        ]);
    }

    public function update(Request $request, Region $region): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $region->update($data);

        return back()->with('status', 'Wilayah diperbarui.');
    }
}
