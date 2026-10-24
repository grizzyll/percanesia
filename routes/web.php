<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes Percanesia
|--------------------------------------------------------------------------
*/

// 1. Publik / Frontend
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// 2. Katalog & Detail Produk
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');
Route::get('/katalog/detail/{id}', [KatalogController::class, 'detail'])->name('katalog.detail');

// 3. Keranjang Belanja & Checkout (Checkout Wajib Login)
Route::get('/cart', [CheckoutController::class, 'cart'])->name('cart');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

// 4. Autentikasi (Login, Register & Logout)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login/process', [AuthController::class, 'processLogin'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register/process', [AuthController::class, 'processRegister'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 5. Admin Panel Studio
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/produk', [AdminController::class, 'produk'])->name('admin.produk');
Route::get('/admin/pesanan', [AdminController::class, 'pesanan'])->name('admin.pesanan');
Route::get('/admin/pesan-masuk', [AdminController::class, 'pesanMasuk'])->name('admin.pesan_masuk');
Route::post('/admin/produk/store', [AdminController::class, 'storeProduct'])->name('admin.produk.store');