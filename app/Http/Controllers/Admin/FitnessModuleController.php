<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sport;
use App\Models\FitnessSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FitnessModuleController extends Controller
{
    // Sports Management
    public function indexSports()
    {
        $sports = Sport::paginate(15);
        return view('admin.fitness.sports.index', compact('sports'));
    }

    public function createSport()
    {
        return view('admin.fitness.sports.create');
    }

    public function storeSport(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:tim,individu',
            'difficulty_level' => 'required|integer|min:1|max:5',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('icon')) {
            $validated['icon'] = $request->file('icon')->store('sports-icons', 'public');
        }

        Sport::create($validated);
        return redirect()->route('admin.fitness.sports.index')->with('success', 'Olahraga berhasil ditambahkan');
    }

    public function editSport(Sport $sport)
    {
        return view('admin.fitness.sports.edit', compact('sport'));
    }

    public function updateSport(Request $request, Sport $sport)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:tim,individu',
            'difficulty_level' => 'required|integer|min:1|max:5',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('icon')) {
            if ($sport->icon && Storage::disk('public')->exists($sport->icon)) {
                Storage::disk('public')->delete($sport->icon);
            }
            $validated['icon'] = $request->file('icon')->store('sports-icons', 'public');
        } else {
            unset($validated['icon']);
        }

        $sport->update($validated);
        return redirect()->route('admin.fitness.sports.index')->with('success', 'Olahraga berhasil diperbarui');
    }

    public function destroySport(Sport $sport)
    {
        $sport->delete();
        return redirect()->route('admin.fitness.sports.index')->with('success', 'Olahraga berhasil dihapus');
    }

    // Fitness Schedules Management
    public function indexSchedules()
    {
        $schedules = FitnessSchedule::with('sport')->paginate(15);
        return view('admin.fitness.schedules.index', compact('schedules'));
    }

    public function createSchedule()
    {
        $sports = Sport::all();
        return view('admin.fitness.schedules.create', compact('sports'));
    }

    public function storeSchedule(Request $request)
    {
        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'schedule_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string',
            'description' => 'nullable|string',
            'max_participants' => 'nullable|integer|min:1',
            'is_active' => 'required|in:0,1',
        ]);

        $validated['is_active'] = (bool) $validated['is_active'];
        FitnessSchedule::create($validated);
        return redirect()->route('admin.fitness.schedules.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function editSchedule(FitnessSchedule $schedule)
    {
        $sports = Sport::all();
        return view('admin.fitness.schedules.edit', compact('schedule', 'sports'));
    }

    public function updateSchedule(Request $request, FitnessSchedule $schedule)
    {
        $validated = $request->validate([
            'sport_id' => 'required|exists:sports,id',
            'schedule_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string',
            'description' => 'nullable|string',
            'max_participants' => 'nullable|integer|min:1',
            'is_active' => 'required|in:0,1',
        ]);

        $validated['is_active'] = (bool) $validated['is_active'];
        $schedule->update($validated);
        return redirect()->route('admin.fitness.schedules.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroySchedule(FitnessSchedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.fitness.schedules.index')->with('success', 'Jadwal berhasil dihapus');
    }
}
