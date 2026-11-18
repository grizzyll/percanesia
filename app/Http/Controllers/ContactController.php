<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
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
     * Memproses Pengiriman Formulir Kontak dan Menyimpan ke Database
     */
    public function send(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'phone'   => 'nullable|string|max:25',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:2000',
        ]);

        // Simpan pesan ke database agar terbaca di Admin Panel
        ContactMessage::create($validated);

        return redirect()->back()->with('success', 'Terima kasih! Pesan Anda telah terkirim. Tim Percanesia akan segera merespons.');
    }
}
