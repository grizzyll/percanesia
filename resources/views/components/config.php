<?php
/**
 * config.php
 * -----------------------------------------------------------------
 * Konfigurasi global untuk seluruh halaman Percanesia.
 * File ini WAJIB di-include paling atas pada setiap halaman
 * SEBELUM memanggil header.php / navbar.php / sidebar.php / footer.php,
 * karena berisi BASE_URL dan variabel $active_menu yang dipakai
 * komponen lain untuk highlight menu aktif.
 * -----------------------------------------------------------------
 */

// Hindari notice bila file ini ke-include dua kali
if (!defined('PERCANESIA_CONFIG')) {
    define('PERCANESIA_CONFIG', true);

    // Nama & identitas situs
    define('SITE_NAME', 'Percanesia');
    define('SITE_TAGLINE', 'Sustainable Textile & Handmade Craft');

    // Base URL otomatis mengikuti folder project
    // Contoh hasil: http://localhost/percanesia
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $script   = str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_NAME']))); // naik 1 level dari /pages
    $base     = rtrim($script, '/');
    define('BASE_URL', $protocol . $_SERVER['HTTP_HOST'] . $base);

    // Kontak (dipakai di footer & header)
    define('WA_NUMBER', '+62 857 5552 7187');
    define('WA_NUMBER_LINK', '6285755527187'); // format untuk wa.me
    define('EMAIL_CONTACT', 'percanesia22@gmail.com');
    define('INSTAGRAM_URL', 'https://www.instagram.com/percanesia');
    define('ADDRESS_LINE', 'Jl. Terusan Kayan A-6, Malang, East Java, Indonesia');

    /**
     * $active_menu diset di setiap halaman SEBELUM include navbar.php
     * agar navbar tahu menu mana yang harus diberi class "active".
     * Contoh di pages/product.php:  $active_menu = 'produk';
     */
    if (!isset($active_menu)) {
        $active_menu = '';
    }

    // Untuk halaman admin, set $active_sidebar sebelum include sidebar.php
    if (!isset($active_sidebar)) {
        $active_sidebar = '';
    }
}
