<?php

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/checkout.php';

// DEMO: login otomatis (dinamai 'login' supaya checkout langsung masuk ke sini)
Route::get('/login-demo', function () {
    $user = User::firstOrCreate(
        ['email' => 'demo@percanesia.test'],
        ['name' => 'Demo', 'password' => bcrypt('password')]
    );
    Auth::login($user);

    return redirect('/checkout');
})->name('login');

// DEMO: isi keranjang dengan 3 produk contoh dari desain
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