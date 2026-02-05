<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'age' => ['nullable', 'integer', 'min:5', 'max:100'],
            'school' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'in:Laki-laki,Perempuan'],
            'phone' => ['nullable', 'string', 'max:15'],
            'guardian_name' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'peserta',
            'age' => $validated['age'] ?? null,
            'school' => $validated['school'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'guardian_name' => $validated['guardian_name'] ?? null,
        ]);

        Auth::login($user);
        return redirect()->intended(route('peserta.dashboard'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if (! $user->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun dinonaktifkan. Hubungi admin.']);
            }

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('peserta.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Kredensial salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
