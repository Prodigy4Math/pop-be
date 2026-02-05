<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\User;
use App\Models\FitnessSchedule;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendance = AttendanceRecord::with('user', 'schedule.sport')
            ->paginate(20);
        return view('admin.attendance.index', compact('attendance'));
    }

    public function record()
    {
        $schedules = FitnessSchedule::with('sport')->where('is_active', true)->get();
        $peserta = User::where('role', 'peserta')->where('is_active', true)->get();
        return view('admin.attendance.record', compact('schedules', 'peserta'));
    }

    public function scanPage(Request $request)
    {
        $payload = (string) $request->query('payload', '');
        $participantCode = $this->extractParticipantCode($payload);
        $participant = null;

        if ($participantCode) {
            $participant = User::where('participant_code', $participantCode)
                ->with('sportInterest')
                ->first();
        }

        $schedules = FitnessSchedule::with('sport')->where('is_active', true)->get();

        return view('admin.attendance.scan-page', compact('payload', 'participant', 'schedules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'fitness_schedule_id' => 'required|exists:fitness_schedules,id',
            'status' => 'required|in:present,absent,late',
            'notes' => 'nullable|string|max:500'
        ]);

        $result = $this->upsertAttendance($validated);

        return redirect()->route('admin.attendance.index')
            ->with('success', $result['message']);
    }

    public function destroy(AttendanceRecord $attendance)
    {
        $attendance->delete();
        return redirect()->route('admin.attendance.index')
            ->with('success', 'Absensi berhasil dihapus');
    }

    public function scan(Request $request)
    {
        $validated = $request->validate([
            'payload' => 'required|string',
            'fitness_schedule_id' => 'required|exists:fitness_schedules,id',
            'status' => 'nullable|in:present,absent,late',
        ]);

        $participantCode = $this->extractParticipantCode($validated['payload']);

        if (!$participantCode) {
            return $this->scanErrorResponse($request, 'QR tidak valid atau ID peserta tidak ditemukan.', 422);
        }

        $user = User::where('participant_code', $participantCode)->first();

        if (!$user) {
            return $this->scanErrorResponse($request, 'Peserta tidak ditemukan.', 404);
        }

        $data = [
            'user_id' => $user->id,
            'fitness_schedule_id' => $validated['fitness_schedule_id'],
            'status' => $validated['status'] ?? 'present',
            'notes' => null,
        ];

        $result = $this->upsertAttendance($data);

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'message' => $result['message'],
                'participant' => [
                    'name' => $user->name,
                    'participant_code' => $user->participant_code,
                ],
            ]);
        }

        return redirect()
            ->route('admin.attendance.index')
            ->with('success', $result['message'] . ' (' . $user->name . ')');
    }

    private function upsertAttendance(array $data): array
    {
        $exists = AttendanceRecord::where('user_id', $data['user_id'])
            ->where('fitness_schedule_id', $data['fitness_schedule_id'])
            ->first();

        if ($exists) {
            $exists->update($data);
            return ['message' => 'Absensi berhasil diperbarui'];
        }

        AttendanceRecord::create($data);
        return ['message' => 'Absensi berhasil dicatat'];
    }

    private function extractParticipantCode(string $payload): ?string
    {
        $payload = trim($payload);
        if ($payload === '') {
            return null;
        }

        if (filter_var($payload, FILTER_VALIDATE_URL)) {
            $query = parse_url($payload, PHP_URL_QUERY);
            if ($query) {
                parse_str($query, $params);
                if (!empty($params['payload'])) {
                    $payload = (string) $params['payload'];
                }
            }
        }

        if (preg_match('/ID=([^;]+)/', $payload, $matches)) {
            return trim($matches[1]);
        }

        return $payload;
    }

    private function scanErrorResponse(Request $request, string $message, int $status)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'ok' => false,
                'message' => $message,
            ], $status);
        }

        return back()->with('error', $message);
    }
}
