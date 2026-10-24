# Keranjang, Checkout, dan Payment Percanesia (Laravel)

Struktur folder sama dengan project Laravel, jadi tinggal disalin ke project rifold.id.
Perhatikan kalau ada file yang namanya sama (misalnya model Product atau layout), jangan ditimpa begitu saja.

## Langkah pasang

1. Salin isi folder ini ke root project.
2. Di `routes/web.php`, tambahkan satu baris:
   `require __DIR__.'/checkout.php';`
3. Kalau tabel `products` dan model `Product` sudah dibuat teman tim, hapus
   `database/migrations/2026_10_14_000001_create_products_table.php` dan `app/Models/Product.php`.
   Yang dipakai keranjang hanya kolom `name`, `price` (rupiah, integer), `image`.
   Kalau ada accessor `image_url`, pastikan ada di Product milik tim.
4. Jalankan:
   ```
   php artisan migrate
   php artisan storage:link
   php artisan db:seed --class=PercanesiaProductSeeder
   ```
   Seeder hanya data contoh dari desain, boleh dilewati.
5. Isi nomor rekening di `config/shop.php`. Untuk QRIS, taruh gambarnya di `public/images/qris.png`.

## Menambah produk ke keranjang

Dari halaman produk, kirim form POST ke `route('cart.store')`:

```
<form method="POST" action="{{ route('cart.store') }}">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="hidden" name="variant" value="Sage Mix">
    <input type="number" name="quantity" value="1" min="1">
    <button type="submit">Tambah ke Keranjang</button>
</form>
```

## Alur

Keranjang (`/keranjang`) -> Checkout (`/checkout`, wajib login) -> Pembayaran (`/pembayaran/{nomor-order}`) -> upload bukti.
Status pembayaran berubah jadi "menunggu verifikasi". Verifikasi oleh admin belum dibuat (di luar bagian ini).

## Yang perlu disesuaikan

- `resources/views/layouts/percanesia.blade.php` adalah layout sendiri. Kalau rifold.id punya layout utama, ganti `@extends('layouts.percanesia')` di semua view dan pindahkan link CSS-nya.
- Link menu (Shop, Collections, dll) di layout masih `url('/shop')` dan sejenisnya, ganti dengan route milik tim.
- Checkout memakai middleware `auth`, jadi harus ada route bernama `login`.
- Gratis ongkir dan ongkir flat diatur di `config/shop.php`.
