<?php

return [

    // Ongkir flat. Gratis kalau subtotal >= free_shipping_min (isi null kalau tidak mau ada gratis ongkir)
    'shipping_cost' => 15000,
    'free_shipping_min' => 150000,

    // Batas waktu bayar setelah order dibuat (jam)
    'payment_expiry_hours' => 24,

    // Metode pembayaran manual. Ganti nomor rekening dengan milik Percanesia.
    'payment_methods' => [
        'bca' => [
            'label' => 'Transfer Bank BCA',
            'type' => 'bank',
            'account_number' => '0000000000',
            'account_name' => 'Percanesia',
        ],
        'bri' => [
            'label' => 'Transfer Bank BRI',
            'type' => 'bank',
            'account_number' => '0000000000000',
            'account_name' => 'Percanesia',
        ],
        'qris' => [
            'label' => 'QRIS',
            'type' => 'qris',
            // taruh gambar QRIS di public/images/qris.png
            'image' => 'images/qris.png',
        ],
        'dana' => [
            'label' => 'DANA',
            'type' => 'ewallet',
            'account_number' => '08000000000',
            'account_name' => 'Percanesia',
        ],
    ],
];
