<?php
/**
 * header.php
 * -----------------------------------------------------------------
 * Top bar: Logo + Tombol "Belanja Sekarang" & "Hubungi Kami"
 * Sticky di atas navbar, mendapat shadow otomatis saat discroll
 * (lihat assets/js/script.js -> handleHeaderShadow()).
 * -----------------------------------------------------------------
 */
?>
<header class="pc-header" id="pcHeader">
    <div class="container">
        <div class="pc-header__inner">

            <!-- Logo -->
            <a href="<?= BASE_URL ?>/index.php" class="pc-header__logo">
                <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="<?= SITE_NAME ?>" class="pc-header__logo-img" onerror="this.style.display='none'">
                <span class="pc-header__logo-text">
                    Perca<span>nesia</span>
                </span>
            </a>

            <!-- CTA Buttons -->
            <div class="pc-header__actions">
                <a href="<?= BASE_URL ?>/pages/product.php" class="btn btn-pc-primary d-none d-md-inline-flex">
                    <i class="bi bi-bag-heart"></i> Belanja Sekarang
                </a>
                <a href="https://wa.me/<?= WA_NUMBER_LINK ?>" target="_blank" rel="noopener" class="btn btn-pc-secondary d-none d-sm-inline-flex">
                    <i class="bi bi-whatsapp"></i> Hubungi Kami
                </a>
            </div>

        </div>
    </div>
</header>
