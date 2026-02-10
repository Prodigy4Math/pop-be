<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::guard('peserta')->check()) {
            return redirect()->route('peserta.dashboard');
        }

        return view('auth.login');
    }

    public function showRegisterForm()
    {
        $sports = Sport::orderBy('name')->get();
        return view('auth.register', compact('sports'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'age' => ['required', 'integer', 'min:5', 'max:30'],
            'school' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:Laki-laki,Perempuan'],
            'phone' => ['required', 'string', 'max:15'],
            'guardian_name' => ['required', 'string', 'max:255'],
            'guardian_phone' => ['required', 'string', 'max:15'],
            'sport_interest_id' => ['required', 'exists:sports,id'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'peserta',
            'age' => $validated['age'],
            'school' => $validated['school'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
            'guardian_name' => $validated['guardian_name'],
            'guardian_phone' => $validated['guardian_phone'],
            'sport_interest_id' => $validated['sport_interest_id'],
        ]);

        Auth::guard('peserta')->login($user);
        return redirect()->intended(route('peserta.dashboard'));
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $validated['email'])->first();
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'Kredensial salah.',
            ])->onlyInput('email');
        }

        if (! $user->is_active) {
            return back()->withErrors(['email' => 'Akun dinonaktifkan. Hubungi admin.']);
        }
        
        Auth::guard('admin')->logout();
        Auth::guard('peserta')->logout();

        $guard = $user->isAdmin() ? 'admin' : 'peserta';
        Auth::guard($guard)->login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        if ($guard === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('peserta.dashboard'));
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function logoutPeserta(Request $request)
    {
        Auth::guard('peserta')->logout();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
