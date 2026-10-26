# Checkout dan Pembayaran Percanesia (Laravel + Midtrans)

Alur: Keranjang -> Checkout (info, alamat, pengiriman) -> Pembayaran (pilih metode) -> Status/instruksi bayar.

## 1. Salin file ke project

Dari folder `percanesia-checkout` yang sudah di-extract (yang dalam), di PowerShell:

```
Copy-Item * C:\Users\user\Herd\percanesia -Recurse -Force
```

File lama dengan nama sama akan tertimpa (itu memang disengaja, karena beberapa file diperbarui).
`routes/web.php` TIDAK ikut tertimpa, jadi baris `require __DIR__.'/checkout.php';` dan route demo-mu tetap aman.

## 2. Jalankan migration

```
php artisan migrate
```

Dua migration baru hanya MENAMBAH kolom di tabel `orders` dan `payments`, data lama aman.
Pesanan tes lama (dari versi sebelumnya) bisa tampil aneh, hapus saja lewat `php artisan migrate:fresh --seed`
kalau database ini cuma untuk percobaan, lalu `php artisan db:seed --class=PercanesiaProductSeeder`.

## 3. Isi kunci Midtrans

1. Daftar di https://dashboard.sandbox.midtrans.com (gratis), masuk ke Settings > Access Keys.
2. Tambahkan di file `.env`:

```
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxx
MIDTRANS_IS_PRODUCTION=false
```

3. Jalankan `php artisan config:clear`.

Metode yang benar-benar muncul di popup (OVO, DANA, ShopeePay, GoPay, VA bank, kartu) tergantung
pengaturan dan aktivasi akun Midtrans-mu. Cek di dashboard: Settings > Snap Preferences / Payment Channels.

## 4. Webhook (supaya status otomatis update)

a. Di `bootstrap/app.php`, di dalam `->withMiddleware(function (Middleware $middleware) { ... })` tambahkan:

```php
$middleware->preventRequestForgery(except: [
    'midtrans/notification',
]);
```

b. Di dashboard Midtrans: Settings > Configuration > Payment Notification URL, isi
`https://DOMAIN-KAMU/midtrans/notification`.

Di komputer lokal webhook tidak bisa masuk (Midtrans tidak bisa menjangkau localhost), tapi itu tidak masalah untuk tes:
halaman status tetap menanyakan status ke Midtrans setiap dibuka dan setiap beberapa detik.
Webhook baru wajib saat sudah online.

## 5. Coba

1. Buka `/login-demo` lalu `/demo-isi-keranjang`, klik Checkout.
2. Pilih Bank/E-Wallet/Kartu, klik Bayar Sekarang, popup Midtrans muncul.
3. Di sandbox, simulator pembayaran ada di https://simulator.sandbox.midtrans.com
   (untuk VA, e-wallet). Untuk kartu pakai kartu tes dari dokumentasi Midtrans.

## 6. Yang perlu kamu ganti

- `config/shop.php`:
  - `payment_methods.intl_transfer.account`: data rekening Percanesia asli (nama bank, SWIFT, nomor rekening) untuk pembeli luar negeri.
  - `usd_rate`: kurs perkiraan untuk tampilan "approx USD".
  - `shipping_methods.international.cost`: tarif ekspedisi internasional.
  - `cod_cities`: kota yang bisa COD. `free_shipping_min`: isi angka kalau mau gratis ongkir.
- Logo bank/e-wallet/kartu: simpan file resmi di `public/images/payments/` dengan nama `bca.png`, `bri.png`, `bni.png`,
  `mandiri.png`, `ovo.png`, `dana.png`, `shopeepay.png`, `gopay.png`, `visa.png`, `mastercard.png`, `jcb.png`
  (svg/webp juga boleh). Selama belum ada, tampil sebagai label teks.
- `resources/views/layouts/percanesia.blade.php`: link menu (Shop, Collections, dll) masih `url('/shop')`, ganti dengan route tim.
- Pembayaran internasional lewat transfer bank belum ada halaman admin untuk memverifikasi bukti. Sementara,
  ubah `status` di tabel `payments` dan `orders` secara manual.

## Struktur singkat

- `app/Http/Controllers/CheckoutController.php`: simpan pesanan dari form checkout.
- `app/Http/Controllers/PaymentController.php`: pilih metode, token Snap, COD, transfer internasional, webhook, polling status.
- `app/Services/MidtransService.php`: komunikasi ke API Midtrans (tanpa package tambahan).
- `public/js/checkout.js`, `payment-select.js`, `payment-status.js`: interaksi halaman.
- `public/css/percanesia-checkout.css`, `public/fonts/`: tampilan dan font (sudah di-host sendiri).
