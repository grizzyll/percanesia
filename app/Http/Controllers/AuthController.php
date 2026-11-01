<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('pages.auth.login');
    }

    /**
     * Memproses Login Nyata dari Database
     */
    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Jika yang login adalah ADMIN -> langsung ke Dashboard Admin
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            // Jika yang login adalah PELANGGAN -> kembali ke Checkout jika tadi mau order
            return redirect()->intended('/checkout');
        }

        return back()->with('error', 'Email atau password yang Anda masukkan salah.')->withInput();
    }

    public function showRegister()
    {
        return view('pages.auth.register');
    }

    /**
     * Memproses Pendaftaran Pelanggan Baru ke Database
     */
    public function processRegister(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'phone'    => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'role'     => 'customer',
            'password' => Hash::make($request->password),
        ]);

        // Otomatis login setelah register
        Auth::login($user);

        return redirect()->route('checkout')->with('success', 'Akun berhasil dibuat! Silakan lanjutkan pesanan Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah keluar.');
    }
}