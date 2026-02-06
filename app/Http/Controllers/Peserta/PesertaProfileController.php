<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ParticipantBarcodeService;

class PesertaProfileController extends Controller
{
    public function show()
    {
        $user = auth('peserta')->user();
        return view('peserta.profile.show', compact('user'));
    }

    public function edit()
    {
        $user = auth('peserta')->user();
        return view('peserta.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth('peserta')->id(),
            'phone' => 'required|string|max:20',
            'school' => 'required|string|max:255',
            'age' => 'required|integer|min:5|max:30',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'guardian_name' => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:20'
        ]);

        $user = auth('peserta')->user();
        $user->update($validated);
        app(ParticipantBarcodeService::class)->refreshIfNeeded($user);

        return redirect()->route('peserta.profile.show')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
