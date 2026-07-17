<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;

Route::get('/', function () {
    return view('welcome');
});


// Route untuk halaman utama admin dashboard
Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');