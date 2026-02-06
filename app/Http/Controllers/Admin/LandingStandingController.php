<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingStanding;
use App\Models\Sport;
use Illuminate\Http\Request;

class LandingStandingController extends Controller
{
    public function index()
    {
        $standings = LandingStanding::with('sport')
            ->orderBy('sport_id')
            ->orderBy('position')
            ->paginate(20);

        return view('admin.landing.standings.index', compact('standings'));
    }

    public function create()
    {
        $sports = Sport::orderBy('name')->get();
        return view('admin.landing.standings.create', compact('sports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sport_id' => ['required', 'exists:sports,id'],
            'position' => ['required', 'integer', 'min:1', 'max:999'],
            'team_name' => ['required', 'string', 'max:255'],
            'played' => ['required', 'integer', 'min:0', 'max:999'],
            'wins' => ['required', 'integer', 'min:0', 'max:999'],
            'draws' => ['required', 'integer', 'min:0', 'max:999'],
            'losses' => ['required', 'integer', 'min:0', 'max:999'],
            'goals_for' => ['required', 'integer', 'min:0', 'max:9999'],
            'goals_against' => ['required', 'integer', 'min:0', 'max:9999'],
            'points' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);

        LandingStanding::create($validated);

        return redirect()->route('admin.landing.standings.index')
            ->with('success', 'Klasemen berhasil ditambahkan.');
    }

    public function edit(LandingStanding $standing)
    {
        $sports = Sport::orderBy('name')->get();
        return view('admin.landing.standings.edit', compact('standing', 'sports'));
    }

    public function update(Request $request, LandingStanding $standing)
    {
        $validated = $request->validate([
            'sport_id' => ['required', 'exists:sports,id'],
            'position' => ['required', 'integer', 'min:1', 'max:999'],
            'team_name' => ['required', 'string', 'max:255'],
            'played' => ['required', 'integer', 'min:0', 'max:999'],
            'wins' => ['required', 'integer', 'min:0', 'max:999'],
            'draws' => ['required', 'integer', 'min:0', 'max:999'],
            'losses' => ['required', 'integer', 'min:0', 'max:999'],
            'goals_for' => ['required', 'integer', 'min:0', 'max:9999'],
            'goals_against' => ['required', 'integer', 'min:0', 'max:9999'],
            'points' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);

        $standing->update($validated);

        return redirect()->route('admin.landing.standings.index')
            ->with('success', 'Klasemen berhasil diperbarui.');
    }

    public function destroy(LandingStanding $standing)
    {
        $standing->delete();

        return redirect()->route('admin.landing.standings.index')
            ->with('success', 'Klasemen berhasil dihapus.');
    }
}
