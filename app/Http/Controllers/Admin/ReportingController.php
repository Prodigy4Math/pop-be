<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\FitnessProgressNote;
use App\Models\User;
use App\Models\Sport;
use Illuminate\Http\Request;

class ReportingController extends Controller
{
    public function activityReport()
    {
        $totalActivities = AttendanceRecord::count();
        $pesertaCount = User::where('role', 'peserta')->count();
        $attendanceByMonth = AttendanceRecord::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->get();

        $topSports = Sport::withCount('progressNotes')
            ->orderByDesc('progress_notes_count')
            ->limit(5)
            ->get();

        return view('admin.reports.activity', compact('totalActivities', 'pesertaCount', 'attendanceByMonth', 'topSports'));
    }

    public function progressReport()
    {
        $peserta = User::where('role', 'peserta')->with('progressNotes')->paginate(15);
        return view('admin.reports.progress', compact('peserta'));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'attendance');

        if ($type === 'attendance') {
            return $this->exportAttendance();
        } elseif ($type === 'progress') {
            return $this->exportProgress();
        }

        return redirect()->back()->with('error', 'Tipe export tidak valid');
    }

    private function exportAttendance()
    {
        $filename = 'attendance_report_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $handle = fopen('php://output', 'w');

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Header
        fputcsv($handle, ['Peserta', 'Olahraga', 'Tanggal', 'Status', 'Catatan']);

        // Data
        $records = AttendanceRecord::with('user', 'schedule.sport')->get();
        foreach ($records as $record) {
            fputcsv($handle, [
                $record->user->name,
                $record->schedule->sport->name,
                $record->schedule->schedule_date,
                $record->status,
                $record->notes
            ]);
        }

        fclose($handle);
        exit;
    }

    private function exportProgress()
    {
        $filename = 'progress_report_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $handle = fopen('php://output', 'w');

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Header
        fputcsv($handle, ['Peserta', 'Olahraga', 'Tanggal', 'Progress', 'Catatan']);

        // Data
        $notes = FitnessProgressNote::with('user', 'sport')->get();
        foreach ($notes as $note) {
            fputcsv($handle, [
                $note->user->name,
                $note->sport->name,
                $note->created_at->format('Y-m-d'),
                $note->progress_percentage . '%',
                $note->notes
            ]);
        }

        fclose($handle);
        exit;
    }
}
