<?php
/**
 * footer.php
 * -----------------------------------------------------------------
 * Footer 4 kolom: Tentang Kami, Navigasi, Kontak (card memanjang
 * dengan ikon bulat), dan Alamat.
 * -----------------------------------------------------------------
 */

$footer_menu = [
    ['label' => 'Home',        'url' => '/index.php'],
    ['label' => 'Tentang Kami', 'url' => '/pages/about.php'],
    ['label' => 'Produk',      'url' => '/pages/product.php'],
    ['label' => 'Workshop',    'url' => '/pages/workshop.php'],
    ['label' => 'Blog',        'url' => '/pages/blog.php'],
    ['label' => 'Kontak',      'url' => '/pages/contact.php'],
];

$footer_contacts = [
    ['icon' => 'bi-whatsapp',    'label' => 'WhatsApp', 'value' => WA_NUMBER, 'link' => 'https://wa.me/' . WA_NUMBER_LINK],
    ['icon' => 'bi-envelope',    'label' => 'Email',    'value' => EMAIL_CONTACT, 'link' => 'mailto:' . EMAIL_CONTACT],
    ['icon' => 'bi-instagram',   'label' => 'Instagram','value' => '@percanesia', 'link' => INSTAGRAM_URL],
    ['icon' => 'bi-geo-alt',     'label' => 'Alamat',   'value' => ADDRESS_LINE, 'link' => null],
];
?>
<footer class="pc-footer">
    <div class="container">
        <div class="row gy-5">

            <!-- Tentang Kami -->
            <div class="col-lg-3 col-md-6">
                <h5 class="pc-footer__title">Tentang Kami</h5>
                <p class="pc-footer__text">
                    Cerita mendalam di balik Percanesia, misi pemberdayaan pengrajin perempuan lokal,
                    dan edukasi seputar sustainable textile artistry.
                </p>
                <div class="pc-footer__social">
                    <a href="<?= INSTAGRAM_URL ?>" target="_blank" rel="noopener" aria-label="Instagram Percanesia">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://wa.me/<?= WA_NUMBER_LINK ?>" target="_blank" rel="noopener" aria-label="WhatsApp Percanesia">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <a href="mailto:<?= EMAIL_CONTACT ?>" aria-label="Email Percanesia">
                        <i class="bi bi-envelope"></i>
                    </a>
                </div>
            </div>

            <!-- Navigasi -->
            <div class="col-lg-2 col-md-6">
                <h5 class="pc-footer__title">Navigasi</h5>
                <ul class="pc-footer__links">
                    <?php foreach ($footer_menu as $item): ?>
                        <li><a href="<?= BASE_URL . $item['url'] ?>"><?= $item['label'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Kontak (card memanjang + ikon bulat) -->
            <div class="col-lg-7">
                <h5 class="pc-footer__title">Kontak Kami</h5>
                <div class="row g-3">
                    <?php foreach ($footer_contacts as $c): ?>
                        <div class="col-md-6">
                            <?php if ($c['link']): ?>
                                <a href="<?= $c['link'] ?>" target="_blank" rel="noopener" class="pc-footer__contact-card">
                            <?php else: ?>
                                <div class="pc-footer__contact-card">
                            <?php endif; ?>

                                <span class="pc-footer__contact-icon">
                                    <i class="bi <?= $c['icon'] ?>"></i>
                                </span>
                                <span class="pc-footer__contact-text">
                                    <small><?= $c['label'] ?></small>
                                    <strong><?= $c['value'] ?></strong>
                                </span>

                            <?php if ($c['link']): ?>
                                </a>
                            <?php else: ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

        <hr class="pc-footer__divider">

        <div class="pc-footer__bottom">
            <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?>. Seluruh hak cipta dilindungi.</p>
            <p class="pc-footer__bottom-tag"><?= SITE_TAGLINE ?></p>
        </div>
    </div>
</footer>
