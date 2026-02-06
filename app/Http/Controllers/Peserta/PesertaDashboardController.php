<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class PesertaDashboardController extends Controller
{
    public function index()
    {
        $user = auth('peserta')->user();
        $totalAttendance = $user->attendance()->count();
        $presentAttendance = $user->attendance()->where('status', 'present')->count();
        $attendancePercentage = $totalAttendance > 0 ? round(($presentAttendance / $totalAttendance) * 100, 2) : 0;

        $averageResilience = $user->psychosocialNotes()->avg('resilience_score') ?? 0;
        $badgeCount = $user->badges()->count();
        $recentActivities = $user->attendance()
            ->with('schedule.sport')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $notifications = $user->notifications()
            ->latest()
            ->limit(5)
            ->get();

        return view('peserta.dashboard', compact(
            'totalAttendance',
            'presentAttendance',
            'attendancePercentage',
            'averageResilience',
            'badgeCount',
            'recentActivities',
            'notifications'
        ));
    }
}
