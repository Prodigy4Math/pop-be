<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EquipmentLoanRequest;
use App\Models\Notification;
use Illuminate\Http\Request;

class EquipmentLoanController extends Controller
{
    public function index()
    {
        $requests = EquipmentLoanRequest::with(['user', 'sport'])
            ->latest()
            ->paginate(15);

        return view('admin.loans.index', compact('requests'));
    }

    public function show(EquipmentLoanRequest $request)
    {
        $request->load(['user', 'sport']);
        return view('admin.loans.show', [
            'loan' => $request,
        ]);
    }

    public function approve(Request $request, EquipmentLoanRequest $loan)
    {
        $validated = $request->validate([
            'admin_comment' => ['nullable', 'string'],
        ]);

        $loan->update([
            'status' => 'approved',
            'admin_comment' => $validated['admin_comment'] ?? null,
            'reviewed_by' => auth('admin')->id(),
            'reviewed_at' => now(),
        ]);

        Notification::create([
            'user_id' => $loan->user_id,
            'title' => 'Peminjaman Alat Disetujui',
            'message' => 'Permintaan peminjaman "' . $loan->item_name . '" telah disetujui.',
            'type' => 'success',
            'category' => 'peminjaman-alat',
            'related_model' => EquipmentLoanRequest::class,
            'related_id' => $loan->id,
        ]);

        return redirect()
            ->route('admin.loans.show', $loan)
            ->with('success', 'Permintaan berhasil disetujui.');
    }

    public function reject(Request $request, EquipmentLoanRequest $loan)
    {
        $validated = $request->validate([
            'admin_comment' => ['required', 'string'],
        ]);

        $loan->update([
            'status' => 'rejected',
            'admin_comment' => $validated['admin_comment'],
            'reviewed_by' => auth('admin')->id(),
            'reviewed_at' => now(),
        ]);

        Notification::create([
            'user_id' => $loan->user_id,
            'title' => 'Peminjaman Alat Ditolak',
            'message' => 'Permintaan peminjaman "' . $loan->item_name . '" ditolak. Catatan: ' . $validated['admin_comment'],
            'type' => 'warning',
            'category' => 'peminjaman-alat',
            'related_model' => EquipmentLoanRequest::class,
            'related_id' => $loan->id,
        ]);

        return redirect()
            ->route('admin.loans.show', $loan)
            ->with('success', 'Permintaan berhasil ditolak.');
    }
}
