<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Keranjang: boleh dibuka tanpa login
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang', [CartController::class, 'store'])->name('cart.store');
Route::patch('/keranjang/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/keranjang/{item}', [CartController::class, 'destroy'])->name('cart.destroy');

// Checkout dan pembayaran: wajib login
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/pembayaran/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/pembayaran/{order}/bayar', [PaymentController::class, 'pay'])->name('payment.pay');
    Route::get('/pembayaran/{order}/status', [PaymentController::class, 'poll'])->name('payment.poll');
    Route::post('/pembayaran/{order}/bukti', [PaymentController::class, 'uploadProof'])->name('payment.proof');
});

// Webhook Midtrans: dipanggil server Midtrans, tanpa login dan tanpa CSRF.
// Wajib dikecualikan dari CSRF di bootstrap/app.php (lihat CARA-PASANG-PAYMENT.md)
Route::post('/midtrans/notification', [PaymentController::class, 'notification'])->name('midtrans.notification');
