<?php

return [

    // Negara asal toko. Pembeli dari negara lain otomatis memakai pengiriman internasional.
    'home_country' => 'Indonesia',

    // Gratis ongkir untuk pengiriman dalam negeri kalau subtotal >= angka ini (isi null kalau tidak dipakai).
    'free_shipping_min' => null,
    'free_shipping_label' => 'Min. belanja Rp150.000', // teks di pita "Gratis Ongkir"

    // Estimasi kurs untuk menampilkan perkiraan nominal USD di transfer internasional. Ganti sesuai kurs.
    'usd_rate' => 16000,

    // Batas waktu bayar (jam)
    'payment_expiry_hours' => 24,
    'intl_expiry_hours' => 72, // transfer internasional butuh waktu lebih lama

    // Daftar negara tujuan: nama => kode ISO 3 huruf (dipakai Midtrans)
    'countries' => [
        'Indonesia' => 'IDN',
        'Malaysia' => 'MYS',
        'Singapore' => 'SGP',
        'Brunei' => 'BRN',
        'Thailand' => 'THA',
        'Philippines' => 'PHL',
        'Vietnam' => 'VNM',
        'Japan' => 'JPN',
        'South Korea' => 'KOR',
        'China' => 'CHN',
        'Hong Kong' => 'HKG',
        'Taiwan' => 'TWN',
        'India' => 'IND',
        'Australia' => 'AUS',
        'New Zealand' => 'NZL',
        'United Arab Emirates' => 'ARE',
        'Saudi Arabia' => 'SAU',
        'Netherlands' => 'NLD',
        'Germany' => 'DEU',
        'France' => 'FRA',
        'Italy' => 'ITA',
        'Spain' => 'ESP',
        'United Kingdom' => 'GBR',
        'United States' => 'USA',
        'Canada' => 'CAN',
        'Other' => 'IDN',
    ],

    // Metode pengiriman. scope: domestic (dalam negeri) atau international.
    // only_cities: huruf kecil semua. Kalau diisi, metode hanya muncul untuk kota itu.
    'shipping_methods' => [
        'reguler' => [
            'label' => 'Reguler (2–3 hari)',
            'desc' => 'Pengiriman 2–3 hari kerja',
            'cost' => 15000,
            'icon' => 'truck',
            'scope' => 'domestic',
        ],
        'express' => [
            'label' => 'Express (1–2 hari)',
            'desc' => 'Pengiriman 1–2 hari kerja',
            'cost' => 25000,
            'icon' => 'plane',
            'scope' => 'domestic',
        ],
        'sameday' => [
            'label' => 'Same Day (Kota Malang)',
            'desc' => 'Pengiriman di hari yang sama (Kota Malang)',
            'cost' => 35000,
            'icon' => 'clock',
            'scope' => 'domestic',
            'only_cities' => ['malang', 'kota malang'],
        ],
        'international' => [
            'label' => 'International (7–14 days)',
            'desc' => 'Pengiriman ke luar negeri / International shipping',
            'cost' => 150000, // ganti sesuai tarif ekspedisi
            'icon' => 'globe',
            'scope' => 'international',
        ],
    ],

    // Kota yang boleh COD (huruf kecil semua)
    'cod_cities' => ['malang', 'kota malang'],

    // Saran kota untuk isian kota/kabupaten (pembeli tetap bisa mengetik kota lain)
    'cities' => [
        'Kota Malang', 'Kabupaten Malang', 'Kota Batu', 'Surabaya', 'Sidoarjo', 'Gresik', 'Pasuruan', 'Probolinggo',
        'Kediri', 'Blitar', 'Jember', 'Banyuwangi', 'Madiun', 'Mojokerto', 'Jombang', 'Lumajang', 'Tulungagung',
        'Jakarta Pusat', 'Jakarta Selatan', 'Jakarta Barat', 'Jakarta Timur', 'Jakarta Utara', 'Bogor', 'Depok',
        'Tangerang', 'Tangerang Selatan', 'Bekasi', 'Bandung', 'Cimahi', 'Cirebon', 'Sukabumi', 'Garut', 'Tasikmalaya',
        'Semarang', 'Surakarta', 'Pekalongan', 'Tegal', 'Magelang', 'Salatiga', 'Kudus', 'Purwokerto', 'Cilacap',
        'Yogyakarta', 'Sleman', 'Bantul', 'Denpasar', 'Badung', 'Gianyar', 'Mataram', 'Kupang',
        'Medan', 'Binjai', 'Pematangsiantar', 'Banda Aceh', 'Padang', 'Bukittinggi', 'Pekanbaru', 'Batam',
        'Jambi', 'Palembang', 'Bandar Lampung', 'Bengkulu', 'Pangkalpinang', 'Tanjungpinang',
        'Pontianak', 'Banjarmasin', 'Balikpapan', 'Samarinda', 'Palangkaraya', 'Tarakan',
        'Makassar', 'Manado', 'Palu', 'Kendari', 'Gorontalo', 'Ambon', 'Ternate', 'Jayapura', 'Sorong',
    ],

    /*
     * Metode pembayaran. type:
     *  - gateway : lewat Midtrans (Snap). Metode apa saja yang aktif diatur di dashboard Midtrans.
     *  - cod     : bayar di tempat
     *  - manual  : transfer manual + upload bukti (untuk transfer internasional)
     * snap = kode metode di Midtrans (enabled_payments).
     */
    'payment_methods' => [
        'bank' => [
            'type' => 'gateway',
            'label' => 'Transfer Bank',
            'desc' => 'Bayar melalui virtual account atau transfer bank. Pesanan akan diproses setelah pembayaran terkonfirmasi.',
            'brands' => ['bca', 'bri', 'bni', 'mandiri'],
            'channels' => [
                'bca' => ['label' => 'BCA', 'snap' => 'bca_va'],
                'bri' => ['label' => 'BRI', 'snap' => 'bri_va'],
                'bni' => ['label' => 'BNI', 'snap' => 'bni_va'],
                'mandiri' => ['label' => 'Mandiri', 'snap' => 'echannel'],
            ],
        ],
        'ewallet' => [
            'type' => 'gateway',
            'label' => 'E-Wallet',
            'desc' => 'Bayar dengan e-wallet favoritmu.',
            'brands' => ['ovo', 'dana', 'shopeepay', 'gopay'],
            'channels' => [
                'ovo' => ['label' => 'OVO', 'snap' => 'ovo'],
                'dana' => ['label' => 'DANA', 'snap' => 'dana'],
                'shopeepay' => ['label' => 'ShopeePay', 'snap' => 'shopeepay'],
                'gopay' => ['label' => 'GoPay', 'snap' => 'gopay'],
            ],
        ],
        'card' => [
            'type' => 'gateway',
            'label' => 'Kartu Kredit / Debit',
            'desc' => 'Bayar dengan kartu Visa, Mastercard, atau JCB. Kartu dari luar negeri juga bisa dipakai.',
            'brands' => ['visa', 'mastercard', 'jcb'],
            'channels' => [
                'card' => ['label' => 'Kartu Kredit / Debit', 'snap' => 'credit_card'],
            ],
        ],
        'intl_transfer' => [
            'type' => 'manual',
            'label' => 'International Bank Transfer',
            'desc' => 'For buyers outside Indonesia: pay by international bank transfer (SWIFT), then upload your transfer receipt.',
            'brands' => ['swift'],
            'channels' => [
                'swift' => ['label' => 'Bank Transfer (SWIFT)'],
            ],
            // GANTI dengan rekening asli Percanesia yang menerima transfer internasional
            'account' => [
                'bank_name' => 'Nama Bank',
                'account_name' => 'Percanesia',
                'account_number' => '0000000000',
                'swift_code' => 'XXXXIDJA',
                'bank_address' => 'Alamat bank, Indonesia',
            ],
        ],
        'cod' => [
            'type' => 'cod',
            'label' => 'COD (Bayar di Tempat)',
            'desc' => 'Bayar langsung saat pesanan sampai di alamatmu.',
            'badge' => 'Tersedia untuk area tertentu',
            'brands' => [],
            'channels' => [],
        ],
    ],

    // Nama tampilan untuk chip merek di pilihan metode
    'brand_labels' => [
        'bca' => 'BCA', 'bri' => 'BRI', 'bni' => 'BNI', 'mandiri' => 'mandiri',
        'ovo' => 'OVO', 'dana' => 'DANA', 'shopeepay' => 'ShopeePay', 'gopay' => 'GoPay',
        'visa' => 'VISA', 'mastercard' => 'Mastercard', 'jcb' => 'JCB', 'swift' => 'SWIFT',
    ],
];
