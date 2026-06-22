<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin() ? redirect()->route('admin.orders') : redirect()->route('menu.index');
        }
        return view('auth.admin-login');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin() ? redirect()->route('admin.orders') : redirect()->route('menu.index');
        }
        return view('auth.admin-register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('admin.orders')->with('success', 'Registrasi berhasil! Selamat datang di Dashboard Admin.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.orders')->with('success', 'Selamat datang di Dashboard Admin Seafood 2000!');
            }

            // If a standard user tries to login here, log them out and show error
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akses ditolak. Halaman ini hanya untuk Administrator.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Email atau password Admin salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda telah keluar dari Portal Admin.');
    }
}
