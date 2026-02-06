<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AchievementSubmission;
use App\Models\Badge;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementSubmissionController extends Controller
{
    public function index()
    {
        $submissions = AchievementSubmission::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.achievements.index', compact('submissions'));
    }

    public function show(AchievementSubmission $submission)
    {
        $submission->load('user');
        $badges = Badge::orderBy('name')->get();

        return view('admin.achievements.show', compact('submission', 'badges'));
    }

    public function download(AchievementSubmission $submission)
    {
        if (!$submission->attachment_path || !Storage::exists($submission->attachment_path)) {
            return redirect()
                ->route('admin.achievements.show', $submission)
                ->with('error', 'Lampiran tidak ditemukan.');
        }

        return Storage::download($submission->attachment_path, $submission->attachment_name);
    }

    public function approve(Request $request, AchievementSubmission $submission)
    {
        $validated = $request->validate([
            'admin_comment' => ['nullable', 'string'],
            'badge_id' => ['nullable', 'exists:badges,id'],
        ]);

        $submission->update([
            'status' => 'approved',
            'admin_comment' => $validated['admin_comment'] ?? null,
            'reviewed_by' => auth('admin')->id(),
            'reviewed_at' => now(),
        ]);

        if (!empty($validated['badge_id'])) {
            $submission->user->badges()->syncWithoutDetaching([
                $validated['badge_id'] => ['earned_date' => now()->toDateString()],
            ]);
        }

        Notification::create([
            'user_id' => $submission->user_id,
            'title' => 'Prestasi/Proposal Disetujui',
            'message' => 'Pengajuan "' . $submission->title . '" telah disetujui oleh admin.',
            'type' => 'success',
            'category' => 'prestasi-proposal',
            'related_model' => AchievementSubmission::class,
            'related_id' => $submission->id,
        ]);

        return redirect()
            ->route('admin.achievements.show', $submission)
            ->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function reject(Request $request, AchievementSubmission $submission)
    {
        $validated = $request->validate([
            'admin_comment' => ['required', 'string'],
        ]);

        $submission->update([
            'status' => 'rejected',
            'admin_comment' => $validated['admin_comment'],
            'reviewed_by' => auth('admin')->id(),
            'reviewed_at' => now(),
        ]);

        Notification::create([
            'user_id' => $submission->user_id,
            'title' => 'Prestasi/Proposal Ditolak',
            'message' => 'Pengajuan "' . $submission->title . '" ditolak. Catatan: ' . $validated['admin_comment'],
            'type' => 'warning',
            'category' => 'prestasi-proposal',
            'related_model' => AchievementSubmission::class,
            'related_id' => $submission->id,
        ]);

        return redirect()
            ->route('admin.achievements.show', $submission)
            ->with('success', 'Pengajuan berhasil ditolak.');
    }
}
