<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KatalogController;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

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

// 3. Autentikasi (Login, Register & Logout)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login/process', [AuthController::class, 'processLogin'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register/process', [AuthController::class, 'processRegister'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 4. Admin Panel Studio
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/produk', [AdminController::class, 'produk'])->name('admin.produk');
Route::get('/admin/pesanan', [AdminController::class, 'pesanan'])->name('admin.pesanan');
Route::get('/admin/pesan-masuk', [AdminController::class, 'pesanMasuk'])->name('admin.pesan_masuk');
Route::post('/admin/produk/store', [AdminController::class, 'storeProduct'])->name('admin.produk.store');

// 5. Keranjang, Checkout & Pembayaran (modul baru: keranjang, checkout, pembayaran/*, midtrans/notification)
require __DIR__.'/checkout.php';

// Alamat lama /cart diarahkan ke /keranjang supaya bookmark/link lama tidak 404
Route::redirect('/cart', '/keranjang');
Route::redirect('/shop', '/katalog');

// 6. DEMO: hanya untuk development lokal
if (app()->environment('local')) {
    Route::get('/demo-isi-keranjang', function () {
        $cart = Cart::current();

        $contoh = [
            ['patchwork-tote-bag', 'Sage Mix', 1],
            ['dompet-perca', 'Peach Blue', 1],
            ['sarung-bantal-perca', 'Coastal Haze', 2],
        ];

        foreach ($contoh as [$slug, $variant, $qty]) {
            $p = Product::where('slug', $slug)->firstOrFail();
            $cart->items()->updateOrCreate(
                ['product_id' => $p->id, 'variant' => $variant],
                ['quantity' => $qty]
            );
        }

        return redirect()->route('cart.index');
    });
}
