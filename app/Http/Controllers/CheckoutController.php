<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function cart()
    {
        return view('pages.checkout.cart');
    }

    public function index()
    {
        // JIKA USER BELUM LOGIN, PAKSA LOGIN DULU!
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan masuk atau daftar akun terlebih dahulu untuk menyelesaikan pesanan Anda.');
        }

        return view('pages.checkout.index');
    }

    public function process(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return redirect()->route('home')->with('success', 'Terima kasih! Pesanan Anda telah berhasil dibuat.');
    }
}