<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BadgeController extends Controller
{
    public function index()
    {
        $badges = Badge::withCount('users')->paginate(15);
        return view('admin.badges.index', compact('badges'));
    }

    public function create()
    {
        return view('admin.badges.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:badges',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:100',
            'type' => 'required|in:kehadiran,kebugaran,psikososial,kesiapsiagaan',
            'requirement_count' => 'required|integer|min:1'
        ]);

        Badge::create($validated);
        return redirect()->route('admin.badges.index')
            ->with('success', 'Badge berhasil dibuat');
    }

    public function show(Badge $badge)
    {
        $badge->load('users');
        $peserta = User::where('role', 'peserta')->orderBy('name')->get();
        return view('admin.badges.show', compact('badge', 'peserta'));
    }

    public function edit(Badge $badge)
    {
        return view('admin.badges.edit', compact('badge'));
    }

    public function update(Request $request, Badge $badge)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:badges,name,' . $badge->id,
            'description' => 'required|string',
            'icon' => 'nullable|string|max:100',
            'type' => 'required|in:kehadiran,kebugaran,psikososial,kesiapsiagaan',
            'requirement_count' => 'required|integer|min:1'
        ]);

        $badge->update($validated);
        return redirect()->route('admin.badges.index')
            ->with('success', 'Badge berhasil diperbarui');
    }

    public function destroy(Badge $badge)
    {
        $badge->delete();
        return redirect()->route('admin.badges.index')
            ->with('success', 'Badge berhasil dihapus');
    }

    public function awardBadge(Request $request, Badge $badge)
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'peserta')
            ]
        ]);

        $user = User::find($validated['user_id']);
        $alreadyAwarded = $badge->users()->where('user_id', $user->id)->exists();
        if ($alreadyAwarded) {
            return redirect()->route('admin.badges.show', $badge)
                ->with('error', 'Badge sudah diberikan kepada peserta ini');
        }

        $badge->users()->attach($user->id, ['earned_date' => now()->toDateString()]);

        return redirect()->route('admin.badges.show', $badge)
            ->with('success', 'Badge berhasil diberikan kepada peserta');
    }
}
