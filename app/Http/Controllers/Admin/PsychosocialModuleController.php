<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PsychosocialActivity;
use App\Models\PsychosocialNote;
use App\Models\User;
use Illuminate\Http\Request;

class PsychosocialModuleController extends Controller
{
    // ACTIVITIES MANAGEMENT
    public function indexActivities(Request $request)
    {
        $query = PsychosocialActivity::query();

        if ($request->filled('q')) {
            $keyword = $request->input('q');
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('status')) {
            $status = $request->input('status') === 'active';
            $query->where('is_active', $status);
        }

        if ($request->filled('duration_min')) {
            $query->where('duration_minutes', '>=', (int) $request->input('duration_min'));
        }

        if ($request->filled('duration_max')) {
            $query->where('duration_minutes', '<=', (int) $request->input('duration_max'));
        }

        $sort = $request->input('sort', 'latest');
        if ($sort === 'duration_asc') {
            $query->orderBy('duration_minutes', 'asc');
        } elseif ($sort === 'duration_desc') {
            $query->orderBy('duration_minutes', 'desc');
        } elseif ($sort === 'name_asc') {
            $query->orderBy('name', 'asc');
        } elseif ($sort === 'name_desc') {
            $query->orderBy('name', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $statsQuery = clone $query;
        $stats = [
            'total' => (clone $statsQuery)->count(),
            'active' => (clone $statsQuery)->where('is_active', true)->count(),
            'avg_duration' => (clone $statsQuery)->avg('duration_minutes'),
            'category_count' => (clone $statsQuery)->distinct('category')->count('category'),
        ];

        $activities = $query->paginate(15)->withQueryString();

        return view('admin.psychosocial.activities.index', compact('activities', 'stats'));
    }

    public function createActivity()
    {
        return view('admin.psychosocial.activities.create');
    }

    public function storeActivity(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|min:10',
                'category' => 'required|in:Stres Manajemen,Trauma Healing,Resiliensi,Sosial Emosional',
                'duration_minutes' => 'required|integer|min:15|max:180',
                'is_active' => 'nullable'
            ], [
                'name.required' => 'Nama kegiatan wajib diisi',
                'description.required' => 'Deskripsi kegiatan wajib diisi',
                'description.min' => 'Deskripsi minimal 10 karakter',
                'category.required' => 'Kategori wajib dipilih',
                'duration_minutes.required' => 'Durasi wajib diisi',
                'duration_minutes.min' => 'Durasi minimal 15 menit',
                'duration_minutes.max' => 'Durasi maksimal 180 menit',
            ]);

            $validated['is_active'] = $request->has('is_active') ? true : false;
            PsychosocialActivity::create($validated);
            return redirect()->route('admin.psychosocial.activities.index')
                ->with('success', 'Kegiatan psikososial berhasil dibuat');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function editActivity(PsychosocialActivity $activity)
    {
        return view('admin.psychosocial.activities.edit', compact('activity'));
    }

    public function updateActivity(Request $request, PsychosocialActivity $activity)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|min:10',
                'category' => 'required|in:Stres Manajemen,Trauma Healing,Resiliensi,Sosial Emosional',
                'duration_minutes' => 'required|integer|min:15|max:180',
                'is_active' => 'nullable'
            ], [
                'name.required' => 'Nama kegiatan wajib diisi',
                'description.required' => 'Deskripsi kegiatan wajib diisi',
                'description.min' => 'Deskripsi minimal 10 karakter',
                'category.required' => 'Kategori wajib dipilih',
                'duration_minutes.required' => 'Durasi wajib diisi',
                'duration_minutes.min' => 'Durasi minimal 15 menit',
                'duration_minutes.max' => 'Durasi maksimal 180 menit',
            ]);

            $validated['is_active'] = $request->has('is_active') ? true : false;
            $activity->update($validated);
            return redirect()->route('admin.psychosocial.activities.index')
                ->with('success', 'Kegiatan psikososial berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroyActivity(PsychosocialActivity $activity)
    {
        try {
            // Check if activity has notes
            if ($activity->notes()->count() > 0) {
                return redirect()->route('admin.psychosocial.activities.index')
                    ->with('error', 'Tidak dapat menghapus kegiatan yang sudah memiliki catatan. Silakan hapus catatan terlebih dahulu.');
            }
            
            $activity->delete();
            return redirect()->route('admin.psychosocial.activities.index')
                ->with('success', 'Kegiatan psikososial berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.psychosocial.activities.index')
                ->with('error', 'Terjadi kesalahan saat menghapus kegiatan: ' . $e->getMessage());
        }
    }

    // NOTES MANAGEMENT
    public function indexNotes()
    {
        $notes = PsychosocialNote::with('user', 'activity')
            ->paginate(15);
        return view('admin.psychosocial.notes.index', compact('notes'));
    }

    public function createNote()
    {
        $peserta = User::where('role', 'peserta')->get();
        $activities = PsychosocialActivity::where('is_active', true)->get();
        return view('admin.psychosocial.notes.create', compact('peserta', 'activities'));
    }

    public function storeNote(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'psychosocial_activity_id' => 'required|exists:psychosocial_activities,id',
                'notes' => 'required|string|min:10',
                'resilience_score' => 'required|integer|min:1|max:10',
                'mood' => 'required|in:Sangat Baik,Baik,Normal,Sedih,Sangat Sedih'
            ], [
                'user_id.required' => 'Peserta wajib dipilih',
                'user_id.exists' => 'Peserta tidak ditemukan',
                'psychosocial_activity_id.required' => 'Kegiatan wajib dipilih',
                'psychosocial_activity_id.exists' => 'Kegiatan tidak ditemukan',
                'notes.required' => 'Catatan wajib diisi',
                'notes.min' => 'Catatan minimal 10 karakter',
                'resilience_score.required' => 'Skor resiliensi wajib diisi',
                'resilience_score.min' => 'Skor minimal 1',
                'resilience_score.max' => 'Skor maksimal 10',
                'mood.required' => 'Mood wajib dipilih',
            ]);

            PsychosocialNote::create($validated);
            return redirect()->route('admin.psychosocial.notes.index')
                ->with('success', 'Catatan psikososial berhasil dibuat');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function editNote(PsychosocialNote $note)
    {
        $peserta = User::where('role', 'peserta')->get();
        $activities = PsychosocialActivity::where('is_active', true)->get();
        return view('admin.psychosocial.notes.edit', compact('note', 'peserta', 'activities'));
    }

    public function updateNote(Request $request, PsychosocialNote $note)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'psychosocial_activity_id' => 'required|exists:psychosocial_activities,id',
                'notes' => 'required|string|min:10',
                'resilience_score' => 'required|integer|min:1|max:10',
                'mood' => 'required|in:Sangat Baik,Baik,Normal,Sedih,Sangat Sedih'
            ], [
                'user_id.required' => 'Peserta wajib dipilih',
                'user_id.exists' => 'Peserta tidak ditemukan',
                'psychosocial_activity_id.required' => 'Kegiatan wajib dipilih',
                'psychosocial_activity_id.exists' => 'Kegiatan tidak ditemukan',
                'notes.required' => 'Catatan wajib diisi',
                'notes.min' => 'Catatan minimal 10 karakter',
                'resilience_score.required' => 'Skor resiliensi wajib diisi',
                'resilience_score.min' => 'Skor minimal 1',
                'resilience_score.max' => 'Skor maksimal 10',
                'mood.required' => 'Mood wajib dipilih',
            ]);

            $note->update($validated);
            return redirect()->route('admin.psychosocial.notes.index')
                ->with('success', 'Catatan psikososial berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroyNote(PsychosocialNote $note)
    {
        try {
            $note->delete();
            return redirect()->route('admin.psychosocial.notes.index')
                ->with('success', 'Catatan psikososial berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.psychosocial.notes.index')
                ->with('error', 'Terjadi kesalahan saat menghapus catatan: ' . $e->getMessage());
        }
    }
}
