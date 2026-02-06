<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgressTrackingController extends Controller
{
    public function index()
    {
        $user = auth('peserta')->user();
        $totalAttendance = $user->attendance()->count();
        $presentAttendance = $user->attendance()->where('status', 'present')->count();
        $attendancePercentage = $totalAttendance > 0 ? round(($presentAttendance / $totalAttendance) * 100, 2) : 0;
        
        $averageResilience = $user->psychosocialNotes()->avg('resilience_score') ?? 0;
        $progressNotes = $user->progressNotes()->with('sport')->paginate(10);

        return view('peserta.progress.index', compact(
            'totalAttendance',
            'presentAttendance',
            'attendancePercentage',
            'averageResilience',
            'progressNotes'
        ));
    }

    public function badges()
    {
        $user = auth('peserta')->user();
        $badges = $user->badges()->paginate(12);
        return view('peserta.badges.index', compact('badges'));
    }
}
