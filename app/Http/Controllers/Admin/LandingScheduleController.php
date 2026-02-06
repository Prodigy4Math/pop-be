<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingSchedule;
use App\Models\Sport;
use Illuminate\Http\Request;

class LandingScheduleController extends Controller
{
    public function index()
    {
        $schedules = LandingSchedule::with('sport')
            ->orderByDesc('match_date')
            ->paginate(15);

        return view('admin.landing.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $sports = Sport::orderBy('name')->get();
        return view('admin.landing.schedules.create', compact('sports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sport_id' => ['required', 'exists:sports,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'team_home' => ['nullable', 'string', 'max:255'],
            'team_away' => ['nullable', 'string', 'max:255'],
            'match_date' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:scheduled,live,finished'],
            'score_home' => ['nullable', 'integer', 'min:0', 'max:999'],
            'score_away' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $validated['is_featured'] = (bool) ($validated['is_featured'] ?? false);

        LandingSchedule::create($validated);

        return redirect()->route('admin.landing.schedules.index')
            ->with('success', 'Jadwal pertandingan berhasil ditambahkan.');
    }

    public function edit(LandingSchedule $schedule)
    {
        $sports = Sport::orderBy('name')->get();
        return view('admin.landing.schedules.edit', compact('schedule', 'sports'));
    }

    public function update(Request $request, LandingSchedule $schedule)
    {
        $validated = $request->validate([
            'sport_id' => ['required', 'exists:sports,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'team_home' => ['nullable', 'string', 'max:255'],
            'team_away' => ['nullable', 'string', 'max:255'],
            'match_date' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:scheduled,live,finished'],
            'score_home' => ['nullable', 'integer', 'min:0', 'max:999'],
            'score_away' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $validated['is_featured'] = (bool) ($validated['is_featured'] ?? false);

        $schedule->update($validated);

        return redirect()->route('admin.landing.schedules.index')
            ->with('success', 'Jadwal pertandingan berhasil diperbarui.');
    }

    public function destroy(LandingSchedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.landing.schedules.index')
            ->with('success', 'Jadwal pertandingan berhasil dihapus.');
    }
}
