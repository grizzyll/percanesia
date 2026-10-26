/* Percanesia - halaman status pembayaran (menunggu, verifikasi, berhasil, gagal, COD) */
(function () {
    'use strict';

    var PC = window.PC, U = window.PCU;
    var app = document.getElementById('app');
    var o = PC.order;
    var busy = false;
    var msg = '';

    var dateFmt = new Intl.DateTimeFormat('id-ID', { dateStyle: 'long', timeStyle: 'short' });
    function p() { return PC.payment; }
    function when(iso) { return iso ? dateFmt.format(new Date(iso)) : ''; }

    /* ------------------------------------------------------------ kartu utama per status */
    function copyRow(label, value, big, copyValue) {
        var toCopy = copyValue !== undefined ? copyValue : String(value).replace(/\s+/g, '');
        return '<div class="copy-row"><div><span class="k">' + U.esc(label) + '</span>' +
            '<span class="v' + (big ? ' v--big' : '') + '">' + U.esc(value) + '</span></div>' +
            '<button type="button" class="copy-btn" data-copy="' + U.esc(toCopy) + '" aria-label="Salin ' + U.esc(label) + '">' + U.icon('copy') + '<span>Salin</span></button></div>';
    }

    function deadlineHtml() {
        if (!p().expiresAt) { return ''; }
        return '<p class="deadline">' + U.icon('clock') + '<span>Selesaikan sebelum <strong>' + when(p().expiresAt) + '</strong> &middot; sisa <b data-countdown="' + U.esc(p().expiresAt) + '"></b></span></p>';
    }

    function amountHtml() {
        return copyRow('Total pembayaran', U.rp(p().amount), true, String(p().amount));
    }

    function mainCard() {
        var s = p().state, i = p().info;

        if (s === 'berhasil') {
            return stateCard('ok', 'check', 'Pembayaran Diterima', 'Terima kasih! Pesanan <strong>' + U.esc(o.number) + '</strong> sedang kami siapkan. Detail pesanan juga dikirim ke ' + U.esc(o.email) + '.',
                '<div class="btn-row"><a class="btn btn--primary btn--auto" href="' + U.esc(PC.urls.shop) + '">Lanjut Belanja ' + U.icon('arrow') + '</a></div>');
        }

        if (s === 'cod') {
            return stateCard('ok', 'cash', 'Pesanan Dikonfirmasi (COD)', 'Pesanan <strong>' + U.esc(o.number) + '</strong> kami proses. Siapkan uang pas <strong>' + U.rp(p().amount) + '</strong> dan bayar langsung ke kurir saat pesanan sampai di ' + U.esc(o.city) + '.',
                '<div class="btn-row"><a class="btn btn--primary btn--auto" href="' + U.esc(PC.urls.shop) + '">Lanjut Belanja ' + U.icon('arrow') + '</a></div>');
        }

        if (s === 'verifikasi') {
            return stateCard('wait', 'clock', 'Bukti Transfer Diterima', 'Kami sedang memeriksa bukti transfermu. Biasanya selesai dalam 1–2 hari kerja, dan kamu akan dikabari lewat email.', '');
        }

        if (s === 'gagal') {
            return stateCard('bad', 'alert', 'Pembayaran Gagal', 'Pembayaran ditolak atau dibatalkan, jadi pesanan ini dibatalkan. Kamu bisa membuat pesanan baru dari keranjang.',
                '<div class="btn-row"><a class="btn btn--primary btn--auto" href="' + U.esc(PC.urls.cart) + '">Kembali ke Keranjang</a></div>');
        }

        if (s === 'kedaluwarsa') {
            return stateCard('bad', 'clock', 'Waktu Pembayaran Habis', 'Pesanan ini dibatalkan karena belum dibayar sampai batas waktu. Silakan buat pesanan baru dari keranjang.',
                '<div class="btn-row"><a class="btn btn--primary btn--auto" href="' + U.esc(PC.urls.shop) + '">Kembali Belanja</a></div>');
        }

        if (s === 'manual') { return manualCard(); }

        // menunggu pembayaran lewat Midtrans
        var body = '';
        if (i && i.type === 'va') {
            body += copyRow('Nomor Virtual Account ' + (i.bank || ''), i.number, true);
        } else if (i && i.type === 'bill') {
            body += copyRow('Kode Perusahaan (Biller Code)', i.biller_code, false) + copyRow('Kode Pembayaran (Bill Key)', i.bill_key, true);
        } else {
            body += '<p class="plain">Pembayaranmu belum selesai. Tekan <strong>Lanjutkan Pembayaran</strong> untuk membuka jendela pembayaran' + (p().channelLabel ? ' ' + U.esc(p().channelLabel) : '') + '.</p>';
        }
        body += amountHtml() + deadlineHtml();

        var actions = '<div class="btn-row"><button type="button" class="btn btn--primary btn--auto" id="resume-btn"' + (busy ? ' disabled' : '') + '>' +
            (busy ? '<span class="spinner"></span> Membuka...' : 'Lanjutkan Pembayaran ' + U.icon('arrow')) + '</button>' +
            (p().canChange ? '<a class="btn btn--soft btn--auto" href="' + U.esc(PC.urls.change) + '">Ganti Metode Pembayaran</a>' : '') + '</div>';

        return stateCard('wait', 'clock', 'Menunggu Pembayaran',
            'Metode: <strong>' + U.esc(p().methodLabel) + (p().channelLabel && p().method !== 'card' ? ' · ' + U.esc(p().channelLabel) : '') + '</strong>. Status akan diperbarui otomatis setelah pembayaranmu masuk.',
            '<div class="pay-info">' + body + '</div>' + (msg ? '<p class="alert" role="alert">' + U.icon('alert') + '<span>' + U.esc(msg) + '</span></p>' : '') + actions);
    }

    function manualCard() {
        var a = p().account || {};
        var usd = PC.usdRate ? (p().amount / PC.usdRate) : 0;
        var body = '<div class="pay-info">' +
            copyRow('Bank', a.bank_name, false) + copyRow('Account name', a.account_name, false) +
            copyRow('Account number', a.account_number, true) + copyRow('SWIFT / BIC', a.swift_code, false) +
            (a.bank_address ? '<p class="plain plain--sm">' + U.esc(a.bank_address) + '</p>' : '') +
            copyRow('Amount (IDR)', U.rp(p().amount), true, String(p().amount)) +
            (usd ? '<p class="plain plain--sm">Approx. USD ' + usd.toFixed(2) + ' (estimated rate, please check with your bank). Bank fees are paid by the sender.</p>' : '') +
            deadlineHtml() + '</div>' +
            '<form class="upload" id="proof-form"><p class="detail-label">Upload transfer receipt</p>' +
            '<label class="dropzone" for="proof-file">' + U.icon('upload') + '<span id="proof-name">Choose a JPG, PNG, or PDF file (max 4 MB)</span></label>' +
            '<input type="file" id="proof-file" name="proof" accept=".jpg,.jpeg,.png,.pdf" hidden>' +
            (msg ? '<p class="alert" role="alert">' + U.icon('alert') + '<span>' + U.esc(msg) + '</span></p>' : '') +
            '<div class="btn-row"><button type="submit" class="btn btn--primary btn--auto" id="proof-btn"' + (busy ? ' disabled' : '') + '>' +
            (busy ? '<span class="spinner"></span> Uploading...' : 'Send Receipt ' + U.icon('arrow')) + '</button></div></form>';

        return stateCard('wait', 'clock', 'Waiting for Your Transfer',
            'Please transfer the exact amount below, then upload your receipt so we can verify it.', body);
    }

    function stateCard(tone, icon, title, text, extra) {
        return '<section class="pc-card state-card">' +
            '<div class="state-head"><span class="state-ico state-ico--' + tone + '">' + U.icon(icon) + '</span>' +
            '<div><h2>' + U.esc(title) + '</h2><p>' + text + '</p></div></div>' + (extra || '') + '</section>';
    }

    /* ------------------------------------------------------------ ringkasan pesanan */
    function summaryHtml() {
        var items = o.items.map(function (i) {
            return '<li class="sum-item"><div class="thumb">' + U.thumb(i.image, i.name) + '</div>' +
                '<div class="info"><strong>' + U.esc(i.name) + '</strong>' +
                (i.variant ? '<span>Warna: ' + U.esc(i.variant) + '</span>' : '') +
                '<span>Qty: ' + i.qty + '</span></div>' +
                '<div class="right"><span class="price">' + U.rp(i.subtotal) + '</span></div></li>';
        }).join('');

        return '<aside class="pc-card summary-card">' +
            '<svg class="sprig sprig--tr" aria-hidden="true"><use href="#i-sprig"/></svg>' +
            '<header class="sum-head"><h2>Detail Pesanan</h2></header>' +
            '<ul class="sum-items">' + items + '</ul>' +
            '<dl class="sum-rows"><div><dt>Subtotal</dt><dd>' + U.rp(o.subtotal) + '</dd></div>' +
            '<div><dt>Ongkir</dt><dd>' + (o.shipping === 0 ? 'Gratis' : U.rp(o.shipping)) + '</dd></div></dl>' +
            '<div class="sum-total"><span>Total</span><strong>' + U.rp(o.total) + '</strong></div>' +
            '<div class="ship-block"><h3>Dikirim ke</h3><p><strong>' + U.esc(o.recipient) + '</strong> &middot; ' + U.esc(o.phone) + '<br>' +
            U.esc(o.address) + '<br>' + U.esc(o.city) + ' ' + U.esc(o.postalCode) + ', ' + U.esc(o.country) + '<br>' +
            '<span class="muted">' + U.esc(o.shippingLabel || '') + '</span></p></div></aside>';
    }

    function render() {
        app.innerHTML = mainCard() + summaryHtml();
        document.getElementById('order-sub').innerHTML = 'Nomor pesanan <strong>' + U.esc(o.number) + '</strong>';

        var s = p().state;
        var done = ['berhasil', 'cod', 'verifikasi'].indexOf(s) !== -1;
        U.stepper(document.getElementById('stepper'), [
            { label: 'Keranjang', state: 'done' },
            { label: 'Pengiriman', state: 'done' },
            { label: 'Pembayaran', state: done ? 'done' : 'active' },
            { label: 'Selesai', state: done ? 'active' : 'todo' }
        ]);
        tick();
    }

    /* ------------------------------------------------------------ hitung mundur dan polling */
    function tick() {
        document.querySelectorAll('[data-countdown]').forEach(function (n) {
            var left = Math.floor((new Date(n.dataset.countdown) - Date.now()) / 1000);
            if (left <= 0) { n.textContent = 'habis'; return; }
            var d = Math.floor(left / 86400), h = Math.floor(left % 86400 / 3600), m = Math.floor(left % 3600 / 60), sec = left % 60;
            n.textContent = (d ? d + ' hari ' : '') + String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
        });
    }
    setInterval(tick, 1000);

    function poll() {
        if (['menunggu', 'verifikasi', 'manual'].indexOf(p().state) === -1 || busy) { return; }
        fetch(PC.urls.poll, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
            .then(function (r) { return r.ok ? r.json() : null; })
            .then(function (data) {
                if (!data) { return; }
                var changed = data.state !== p().state || JSON.stringify(data.info) !== JSON.stringify(p().info);
                PC.payment = data;
                if (changed) { if (data.state === 'berhasil') { U.toast('Pembayaran diterima'); } render(); }
            }).catch(function () { /* abaikan, coba lagi nanti */ });
    }
    setInterval(poll, 6000);

    /* ------------------------------------------------------------ aksi */
    function resume() {
        busy = true; msg = ''; render();
        function fail(err) { busy = false; msg = err.message; render(); }
        U.postJson(PC.urls.pay, PC.csrf, { method: p().method, channel: p().channel }).then(function (res) {
            if (res.type === 'snap') {
                U.openSnap(PC, res.token, function () { busy = false; poll(); render(); }, fail);
            } else { window.location.reload(); }
        }).catch(fail);
    }

    function upload(form) {
        var file = form.querySelector('#proof-file').files[0];
        if (!file) { msg = 'Choose your transfer receipt first.'; render(); return; }
        busy = true; msg = ''; render();

        var fd = new FormData();
        fd.append('proof', file);
        fetch(PC.urls.proof, { method: 'POST', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': PC.csrf }, body: fd, credentials: 'same-origin' })
            .then(function (r) { return r.json().catch(function () { return {}; }).then(function (d) { if (!r.ok) { throw new Error(d.message || (d.errors && d.errors.proof && d.errors.proof[0]) || 'Upload failed.'); } }); })
            .then(function () { window.location.reload(); })
            .catch(function (e) { busy = false; msg = e.message; render(); });
    }

    app.addEventListener('click', function (e) {
        var c = e.target.closest('.copy-btn');
        if (c) { U.copy(c.dataset.copy, c); return; }
        if (e.target.closest('#resume-btn')) { resume(); }
    });

    app.addEventListener('change', function (e) {
        if (e.target.id === 'proof-file') {
            var f = e.target.files[0];
            document.getElementById('proof-name').textContent = f ? f.name : 'Choose a JPG, PNG, or PDF file (max 4 MB)';
            document.querySelector('.dropzone').classList.toggle('has-file', !!f);
        }
    });

    app.addEventListener('submit', function (e) {
        if (e.target.id === 'proof-form') { e.preventDefault(); upload(e.target); }
    });

    render();
})();
