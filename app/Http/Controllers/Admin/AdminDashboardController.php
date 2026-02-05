<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AttendanceRecord;
use App\Models\FitnessProgressNote;
use App\Models\PsychosocialNote;
use App\Models\PsychosocialActivity;
use App\Models\Sport;
use App\Models\FitnessSchedule;
use App\Models\Badge;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Basic Statistics
        $totalUsers = User::where('role', 'peserta')->count();
        $activeUsers = User::where('role', 'peserta')->where('is_active', true)->count();
        $totalAttendance = AttendanceRecord::count();
        $presentCount = AttendanceRecord::where('status', 'present')->count();
        $averageAttendance = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100, 2) : 0;
        $averageResilience = PsychosocialNote::avg('resilience_score') ?? 0;
        
        // Additional Statistics
        $totalSports = Sport::count();
        $activeSchedules = FitnessSchedule::where('is_active', true)->count();
        $totalActivities = PsychosocialActivity::count();
        $activeActivities = PsychosocialActivity::where('is_active', true)->count();
        $totalNotes = PsychosocialNote::count();
        $totalBadges = Badge::count();
        
        // Recent Activities
        $recentAttendance = AttendanceRecord::with('user', 'schedule.sport')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        $recentNotes = PsychosocialNote::with('user', 'activity')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentActivities = PsychosocialActivity::latest()
            ->take(5)
            ->get();
        
        // Weekly Statistics
        $weeklyAttendance = AttendanceRecord::where('created_at', '>=', Carbon::now()->startOfWeek())
            ->where('created_at', '<=', Carbon::now()->endOfWeek())
            ->count();
        
        $weeklyNotes = PsychosocialNote::where('created_at', '>=', Carbon::now()->startOfWeek())
            ->where('created_at', '<=', Carbon::now()->endOfWeek())
            ->count();
        
        // Monthly Trends (Last 6 months)
        $monthlyAttendance = AttendanceRecord::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();
        
        $monthlyResilience = PsychosocialNote::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('AVG(resilience_score) as avg_score'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();
        
        // Top Performing Sports
        $topSports = Sport::withCount('schedules')
            ->orderBy('schedules_count', 'desc')
            ->take(5)
            ->get();
        
        // Attendance Status Distribution
        $attendanceStatus = AttendanceRecord::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();
        
        // Resilience Score Distribution
        $resilienceDistribution = PsychosocialNote::select(
            DB::raw('CASE 
                WHEN resilience_score >= 7 THEN "Tinggi (7-10)"
                WHEN resilience_score >= 4 THEN "Sedang (4-6)"
                ELSE "Rendah (1-3)"
            END as category'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('category')
        ->get();

        $moodDistribution = PsychosocialNote::select('mood', DB::raw('COUNT(*) as count'))
            ->groupBy('mood')
            ->orderBy('count', 'desc')
            ->get();
        
        // Upcoming Schedules (Next 7 days)
        $upcomingSchedules = FitnessSchedule::with('sport')
            ->where('schedule_date', '>=', Carbon::now())
            ->where('schedule_date', '<=', Carbon::now()->addDays(7))
            ->where('is_active', true)
            ->orderBy('schedule_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();
        
        // New Users This Month
        $newUsersThisMonth = User::where('role', 'peserta')
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();

        $topParticipants = User::where('role', 'peserta')
            ->withCount(['psychosocialNotes' => function ($query) {
                $query->whereNotNull('id');
            }])
            ->orderBy('psychosocial_notes_count', 'desc')
            ->take(5)
            ->get();
        
        return view('dashboard.admin', compact(
            'totalUsers',
            'activeUsers',
            'totalAttendance',
            'presentCount',
            'averageAttendance',
            'averageResilience',
            'totalSports',
            'activeSchedules',
            'totalActivities',
            'activeActivities',
            'totalNotes',
            'totalBadges',
            'recentAttendance',
            'recentNotes',
            'recentActivities',
            'weeklyAttendance',
            'weeklyNotes',
            'monthlyAttendance',
            'monthlyResilience',
            'topSports',
            'attendanceStatus',
            'resilienceDistribution',
            'moodDistribution',
            'upcomingSchedules',
            'newUsersThisMonth',
            'topParticipants'
        ));
    }
}
