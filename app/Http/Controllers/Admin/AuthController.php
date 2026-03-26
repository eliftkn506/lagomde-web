<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && (Auth::user()->rol === 'admin' || Auth::user()->uyelik_tipi === 'admin')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = \App\Models\Kullanici::where('eposta', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Bu e-posta kayıtlı değil.']);
        }

        if (!Hash::check($credentials['password'], $user->sifre)) {
            return back()->withErrors(['email' => 'Şifre hatalı.']);
        }

        if ($user->rol !== 'admin' && $user->uyelik_tipi !== 'admin') {
            return back()->withErrors(['email' => 'Admin yetkisine sahip değilsiniz.']);
        }

        Auth::login($user, $request->remember);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}