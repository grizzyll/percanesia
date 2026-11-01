/* Percanesia - halaman Pembayaran (pilih metode, lalu Bayar Sekarang) */
(function () {
    'use strict';

    var PC = window.PC, U = window.PCU;
    var app = document.getElementById('app');
    var o = PC.order;

    var firstOk = PC.methods.filter(function (m) { return m.available; })[0];
    var state = { method: null, channel: null, loading: false, error: '' };

    // kalau pembeli menekan "ganti metode", mulai dari pilihan sebelumnya
    if (PC.current && PC.methods.some(function (m) { return m.key === PC.current.method && m.available; })) {
        state.method = PC.current.method;
        state.channel = PC.current.channel;
    } else if (firstOk) {
        state.method = firstOk.key;
        state.channel = firstOk.channels.length ? firstOk.channels[0].key : null;
    }

    function current() { return PC.methods.filter(function (m) { return m.key === state.method; })[0]; }
    function channelOf(m) { return m.channels.filter(function (c) { return c.key === state.channel; })[0]; }
    function ready() {
        var m = current();
        return !!m && m.available && (!m.channels.length || !!channelOf(m));
    }

    /* ------------------------------------------------------------ bagian-bagian tampilan */
    function methodsHtml() {
        return PC.methods.map(function (m) {
            var sel = m.key === state.method;
            var brands = m.brands.map(U.brand).join('');
            if (m.key === 'cod') { brands = '<span class="m-ico">' + U.icon('cash') + '</span>'; }
            return '<label class="method' + (sel ? ' is-selected' : '') + (m.available ? '' : ' is-disabled') + '">' +
                '<input type="radio" name="method" value="' + U.esc(m.key) + '"' + (sel ? ' checked' : '') + (m.available ? '' : ' disabled') + '>' +
                '<span class="radio"><i></i></span>' +
                '<span class="m-body"><strong>' + U.esc(m.label) + '</strong>' +
                '<span class="m-desc">' + U.esc(m.available ? m.desc : (m.note || m.desc)) + '</span></span>' +
                '<span class="m-brands">' + brands + (m.badge ? '<span class="badge">' + U.esc(m.badge) + '</span>' : '') + '</span></label>';
        }).join('');
    }

    function chipsHtml(m, title) {
        return '<p class="detail-label">' + title + '</p><div class="chips" role="radiogroup">' +
            m.channels.map(function (c) {
                var on = c.key === state.channel;
                return '<button type="button" class="chip' + (on ? ' is-on' : '') + '" role="radio" aria-checked="' + on + '" data-channel="' + U.esc(c.key) + '">' +
                    (on ? U.icon('check') : '') + U.brand(c) + '</button>';
            }).join('') + '</div>';
    }

    function totalLine() {
        return '<div class="detail-total"><span>Total pembayaran</span><strong>' + U.rp(o.total) + '</strong></div>';
    }

    function noteLine(text) {
        return '<p class="detail-note">' + U.icon('info') + '<span>' + text + '</span></p>';
    }

    function detailHtml() {
        var m = current();
        if (!m) { return '<p class="detail-note">' + U.icon('alert') + '<span>Belum ada metode pembayaran yang tersedia.</span></p>'; }

        if (m.key === 'bank') {
            var c = channelOf(m);
            return chipsHtml(m, 'Pilih bank') +
                noteLine('Kamu akan mendapat nomor virtual account ' + U.esc(c ? c.label : 'bank') + ' setelah menekan Bayar Sekarang. Pastikan nominal transfer sesuai total pembayaran. Pesanan akan diproses dalam 1×24 jam setelah pembayaran terkonfirmasi.') + totalLine();
        }
        if (m.key === 'ewallet') {
            var w = channelOf(m);
            return chipsHtml(m, 'Pilih e-wallet') +
                noteLine('Kamu akan diarahkan ke jendela pembayaran aman untuk menyelesaikan pembayaran lewat ' + U.esc(w ? w.label : 'e-wallet') + '. Pesanan diproses setelah pembayaran berhasil.') + totalLine();
        }
        if (m.key === 'card') {
            return noteLine('Masukkan data kartu di jendela pembayaran aman Midtrans. Kartu kredit/debit dari dalam dan luar negeri (Visa, Mastercard, JCB) bisa dipakai, dan beberapa bank meminta verifikasi 3-D Secure. Data kartumu tidak disimpan di toko ini.') + totalLine();
        }
        if (m.key === 'intl_transfer') {
            var a = m.account || {};
            var usd = PC.usdRate ? (o.total / PC.usdRate) : 0;
            return '<p class="detail-label">Transfer to</p>' +
                '<dl class="kv">' +
                '<div><dt>Bank</dt><dd>' + U.esc(a.bank_name) + '</dd></div>' +
                '<div><dt>Account name</dt><dd>' + U.esc(a.account_name) + '</dd></div>' +
                '<div><dt>Account number</dt><dd>' + U.esc(a.account_number) + '</dd></div>' +
                '<div><dt>SWIFT / BIC</dt><dd>' + U.esc(a.swift_code) + '</dd></div></dl>' +
                noteLine('Send the exact amount in IDR' + (usd ? ' (approx. USD ' + usd.toFixed(2) + ', based on an estimated rate, so please check the rate with your bank)' : '') +
                    '. Bank fees are paid by the sender. After you transfer, upload your receipt on the next page and we will verify it within 1–2 business days.') + totalLine();
        }
        if (m.key === 'cod') {
            return noteLine('Bayar tunai langsung ke kurir saat pesananmu sampai di ' + U.esc(o.city) + '. Siapkan uang pas sebesar total pembayaran.') + totalLine();
        }
        return totalLine();
    }

    function summaryHtml() {
        var items = o.items.map(function (i) {
            return '<li class="sum-item"><div class="thumb">' + U.thumb(i.image, i.name) + '</div>' +
                '<div class="info"><strong>' + U.esc(i.name) + '</strong>' +
                (i.variant ? '<span>Warna: ' + U.esc(i.variant) + '</span>' : '') +
                '<span>Qty: ' + i.qty + '</span></div>' +
                '<div class="right"><span class="price">' + U.rp(i.subtotal) + '</span></div></li>';
        }).join('');

        var btnLabel = state.loading ? '<span class="spinner"></span> Memproses...' : 'Bayar Sekarang ' + U.icon('arrow');
        var m = current();
        if (!state.loading && m && m.type === 'manual') { btnLabel = 'Lanjut ' + U.icon('arrow'); }
        if (!state.loading && m && m.type === 'cod') { btnLabel = 'Konfirmasi Pesanan ' + U.icon('arrow'); }

        return '<aside class="pc-card summary-card">' +
            '<svg class="sprig sprig--tr" aria-hidden="true"><use href="#i-sprig"/></svg>' +
            '<header class="sum-head"><h2>Ringkasan Pesanan</h2></header>' +
            '<ul class="sum-items">' + items + '</ul>' +
            '<dl class="sum-rows"><div><dt>Subtotal</dt><dd>' + U.rp(o.subtotal) + '</dd></div>' +
            '<div><dt>Ongkir</dt><dd>' + (o.shipping === 0 ? 'Gratis' : U.rp(o.shipping)) + '</dd></div></dl>' +
            '<div class="sum-total"><span>Total</span><strong>' + U.rp(o.total) + '</strong></div>' +
            '<div class="secure-box">' + U.icon('lock') + '<div><strong>Pembayaran Aman</strong><span>Data kamu dilindungi dengan enkripsi 256-bit.</span></div></div>' +
            (state.error ? '<p class="alert" role="alert">' + U.icon('alert') + '<span>' + U.esc(state.error) + '</span></p>' : '') +
            '<button type="button" class="btn btn--primary" id="pay-btn"' + ((ready() && !state.loading) ? '' : ' disabled') + '>' + btnLabel + '</button>' +
            '<p class="ship-to">' + U.icon('pin') + '<span>Dikirim ke <strong>' + U.esc(o.recipient) + '</strong>, ' + U.esc(o.city) + (o.country ? ', ' + U.esc(o.country) : '') + ' &middot; ' + U.esc(o.shippingLabel || '') + '</span></p>' +
            '</aside>';
    }

    function render() {
        app.innerHTML =
            '<section class="pc-card pay-card">' +
            '<h2 class="card-title">Metode Pembayaran</h2>' +
            '<div class="methods" role="radiogroup" aria-label="Metode pembayaran">' + methodsHtml() + '</div>' +
            '<h2 class="card-title card-title--sub">Detail Pembayaran</h2>' +
            '<div class="detail" id="detail">' + detailHtml() + '</div>' +
            '<a class="btn btn--soft" href="' + U.esc(PC.backUrl) + '">' + U.icon('left') + ' Kembali ke Pengiriman</a>' +
            '</section>' + summaryHtml();

        U.stepper(document.getElementById('stepper'), [
            { label: 'Keranjang', state: 'done' },
            { label: 'Pengiriman', state: 'done' },
            { label: 'Pembayaran', state: 'active' },
            { label: 'Selesai', state: 'todo' }
        ]);
    }

    /* ------------------------------------------------------------ aksi */
    function pay() {
        if (state.loading || !ready()) { return; }
        state.loading = true; state.error = '';
        render();

        function fail(err) { state.loading = false; state.error = err.message || 'Terjadi kesalahan. Coba lagi.'; render(); }

        U.postJson(PC.payUrl, PC.csrf, { method: state.method, channel: state.channel }).then(function (res) {
            if (res.type === 'snap') {
                U.openSnap(PC, res.token, function () { window.location.href = res.url; }, fail);
            } else {
                window.location.href = res.url;
            }
        }).catch(fail);
    }

    app.addEventListener('change', function (e) {
        if (e.target.name !== 'method') { return; }
        var m = PC.methods.filter(function (x) { return x.key === e.target.value; })[0];
        state.method = m.key;
        state.channel = m.channels.length ? m.channels[0].key : null;
        state.error = '';
        render();
    });

    app.addEventListener('click', function (e) {
        var chip = e.target.closest('.chip');
        if (chip) { state.channel = chip.dataset.channel; state.error = ''; render(); return; }
        if (e.target.closest('#pay-btn')) { pay(); }
    });

    render();
})();
