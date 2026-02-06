<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\FitnessSchedule;
use Illuminate\Http\Request;

class FitnessActivityController extends Controller
{
    public function schedules()
    {
        $schedules = FitnessSchedule::with('sport')
            ->where('is_active', true)
            ->paginate(10);
        return view('peserta.fitness.schedules', compact('schedules'));
    }

    public function attendance()
    {
        $user = auth('peserta')->user();
        $attendance = $user->attendance()
            ->with('schedule.sport')
            ->paginate(15);
        return view('peserta.fitness.attendance', compact('attendance'));
    }

    public function progress()
    {
        $user = auth('peserta')->user();
        $progressNotes = $user->progressNotes()
            ->with('sport')
            ->paginate(15);
        return view('peserta.fitness.progress', compact('progressNotes'));
    }
}
