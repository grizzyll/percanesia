<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Mengarahkan ke file layout utama di folder views/pages/admin/main.blade.php
        return view('pages.admin.main');
    }
}