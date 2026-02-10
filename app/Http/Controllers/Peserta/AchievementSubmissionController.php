<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\AchievementSubmission;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementSubmissionController extends Controller
{
    public function index()
    {
        $submissions = AchievementSubmission::where('user_id', auth('peserta')->id())
            ->latest()
            ->paginate(10);

        return view('peserta.achievements.index', compact('submissions'));
    }

    public function create()
    {
        return view('peserta.achievements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:prestasi,proposal'],
            'description' => ['required', 'string'],
            'event_date' => ['required', 'date'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        $attachmentPath = null;
        $attachmentName = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentName = $file->getClientOriginalName();
            $attachmentPath = $file->store('achievement-attachments');
        }

        $submission = AchievementSubmission::create([
            'user_id' => auth('peserta')->id(),
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'event_date' => $validated['event_date'],
            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
            'status' => 'pending',
        ]);

        $admins = User::where('role', 'admin')->get(['id']);
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Pengajuan Prestasi/Proposal Baru',
                'message' => 'Peserta ' . auth('peserta')->user()->name . ' mengirim ' . $validated['category'] . ' untuk verifikasi.',
                'type' => 'info',
                'category' => 'achievement-submission',
                'related_model' => AchievementSubmission::class,
                'related_id' => $submission->id,
            ]);
        }

        return redirect()
            ->route('peserta.achievements.index')
            ->with('success', 'Prestasi/Proposal berhasil dikirim.');
    }
}
