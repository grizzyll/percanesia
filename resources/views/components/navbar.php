<?php
/**
 * navbar.php
 * -----------------------------------------------------------------
 * Menu navigasi utama. Set $active_menu di halaman pemanggil
 * SEBELUM include file ini agar menu aktif ter-highlight.
 * Nilai yang valid: 'home', 'tentang', 'produk', 'workshop', 'blog', 'kontak'
 * -----------------------------------------------------------------
 */

$menu_items = [
    'home'     => ['label' => 'Home',         'url' => '/index.php'],
    'tentang'  => ['label' => 'Tentang Kami',  'url' => '/pages/about.php'],
    'produk'   => ['label' => 'Produk',        'url' => '/pages/product.php'],
    'workshop' => ['label' => 'Workshop',      'url' => '/pages/workshop.php'],
    'blog'     => ['label' => 'Blog',          'url' => '/pages/blog.php'],
    'kontak'   => ['label' => 'Kontak',        'url' => '/pages/contact.php'],
];
?>
<nav class="pc-navbar navbar navbar-expand-lg" id="pcNavbar">
    <div class="container">

        <button class="navbar-toggler pc-navbar__toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#pcNavbarMenu"
                aria-controls="pcNavbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list"></i>
        </button>

        <div class="collapse navbar-collapse" id="pcNavbarMenu">
            <ul class="navbar-nav pc-navbar__nav mx-auto">
                <?php foreach ($menu_items as $key => $item): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($active_menu === $key) ? 'active' : '' ?>"
                           href="<?= BASE_URL . $item['url'] ?>">
                            <?= $item['label'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- CTA di dalam menu mobile (muncul saat header buttons disembunyikan di layar kecil) -->
            <div class="pc-navbar__mobile-actions d-lg-none">
                <a href="<?= BASE_URL ?>/pages/product.php" class="btn btn-pc-primary w-100 mb-2">
                    <i class="bi bi-bag-heart"></i> Belanja Sekarang
                </a>
                <a href="https://wa.me/<?= WA_NUMBER_LINK ?>" target="_blank" rel="noopener" class="btn btn-pc-secondary w-100">
                    <i class="bi bi-whatsapp"></i> Hubungi Kami
                </a>
            </div>
        </div>

    </div>
</nav>
