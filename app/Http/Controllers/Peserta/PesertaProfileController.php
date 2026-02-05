<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PesertaProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('peserta.profile.show', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('peserta.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'school' => 'nullable|string|max:255',
            'age' => 'required|integer|min:5|max:100',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:20'
        ]);

        auth()->user()->update($validated);
        return redirect()->route('peserta.profile.show')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
