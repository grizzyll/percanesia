<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Menampilkan Halaman Tentang Kami (About Us)
     */
    public function index()
    {
        return view('pages.about.index');
    }
}