<?php
/**
 * sidebar.php
 * -----------------------------------------------------------------
 * Sidebar untuk Dashboard Admin. Set $active_sidebar di halaman
 * pemanggil SEBELUM include file ini, nilai valid:
 * 'dashboard','produk','workshop','artikel','pesanan','pengguna','pengaturan'
 * -----------------------------------------------------------------
 */

$sidebar_items = [
    'dashboard'  => ['label' => 'Dashboard',   'icon' => 'bi-grid-1x2',      'url' => '/admin/dashboard.php'],
    'produk'     => ['label' => 'Produk',      'icon' => 'bi-box-seam',      'url' => '/admin/produk.php'],
    'workshop'   => ['label' => 'Workshop',    'icon' => 'bi-easel',         'url' => '/admin/workshop.php'],
    'artikel'    => ['label' => 'Artikel',     'icon' => 'bi-journal-text',  'url' => '/admin/artikel.php'],
    'pesanan'    => ['label' => 'Pesanan',     'icon' => 'bi-receipt',       'url' => '/admin/pesanan.php'],
    'pengguna'   => ['label' => 'Pengguna',    'icon' => 'bi-people',        'url' => '/admin/pengguna.php'],
    'pengaturan' => ['label' => 'Pengaturan',  'icon' => 'bi-gear',          'url' => '/admin/pengaturan.php'],
];
?>
<aside class="pc-sidebar" id="pcSidebar">
    <div class="pc-sidebar__header">
        <a href="<?= BASE_URL ?>/admin/dashboard.php" class="pc-sidebar__logo">
            <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="<?= SITE_NAME ?>" onerror="this.style.display='none'">
            <span class="pc-sidebar__logo-text">Percanesia</span>
        </a>
        <button class="pc-sidebar__collapse-btn" id="pcSidebarCollapseBtn" title="Collapse/Expand Sidebar">
            <i class="bi bi-chevron-left"></i>
        </button>
    </div>

    <ul class="pc-sidebar__menu">
        <?php foreach ($sidebar_items as $key => $item): ?>
            <li class="pc-sidebar__item">
                <a href="<?= BASE_URL . $item['url'] ?>"
                   class="pc-sidebar__link <?= ($active_sidebar === $key) ? 'active' : '' ?>"
                   data-bs-toggle="tooltip" data-bs-placement="right" title="<?= $item['label'] ?>">
                    <i class="bi <?= $item['icon'] ?>"></i>
                    <span class="pc-sidebar__label"><?= $item['label'] ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="pc-sidebar__footer">
        <a href="<?= BASE_URL ?>/index.php" class="pc-sidebar__link">
            <i class="bi bi-box-arrow-left"></i>
            <span class="pc-sidebar__label">Kembali ke Situs</span>
        </a>
    </div>
</aside>

<!-- Tombol toggle sidebar khusus tampilan mobile -->
<button class="pc-sidebar__mobile-toggle d-lg-none" id="pcSidebarMobileToggle">
    <i class="bi bi-list"></i>
</button>
