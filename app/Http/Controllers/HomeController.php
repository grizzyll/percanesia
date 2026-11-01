<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan Halaman Home Percanesia
     */
    public function index()
    {
        return view('pages.home.index');
    }
}