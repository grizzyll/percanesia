<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Menampilkan Halaman Kontak & Operasional Malang
     */
    public function index()
    {
        return view('pages.contact.index');
    }

    /**
     * Memproses Pengiriman Formulir Kontak
     */
    public function send(Request $request)
    {
        // Validasi input
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Pesan Anda telah terkirim. Tim Percanesia akan segera merespons.');
    }
}