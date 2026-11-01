/* Percanesia - halaman Checkout (informasi, alamat, pengiriman, ringkasan) */
(function () {
    'use strict';

    var PC = window.PC, U = window.PCU;
    var form = document.getElementById('checkout-form');
    var STORE_KEY = 'pc_saved_info';
    var SAVED = ['recipient_name', 'phone', 'email', 'country', 'address', 'city', 'postal_code'];
    var items = PC.items.slice();
    var touched = {};
    var shipTouched = false;

    function el(name) { return form.elements[name]; }
    function fieldBox(name) { return form.querySelector('[data-field="' + name + '"]'); }
    function isDomestic() { return String(el('country').value).toLowerCase() === String(PC.homeCountry).toLowerCase(); }
    function norm(s) { return String(s || '').toLowerCase().replace(/\s+/g, ' ').trim(); }
    function subtotal() { return items.reduce(function (t, i) { return t + i.price * i.qty; }, 0); }
    function getShip() { var r = form.querySelector('input[name="shipping_method"]:checked'); return r ? r.value : ''; }
    function methodByKey(k) { return PC.shippingMethods.filter(function (m) { return m.key === k; })[0]; }

    /* ---------------------------------------------------------------- pengiriman */
    function isAvailable(m) {
        if (m.scope === 'international') { return !isDomestic(); }
        if (!isDomestic()) { return false; }
        if (m.onlyCities && m.onlyCities.length) { return m.onlyCities.indexOf(norm(el('city').value)) !== -1; }
        return true;
    }

    function shipCost(m) {
        if (m.scope === 'domestic' && PC.freeShippingMin !== null && subtotal() >= PC.freeShippingMin) { return 0; }
        return m.cost;
    }

    function renderShipping() {
        var current = getShip() || (PC.old && PC.old.shipping_method) || '';
        var list = PC.shippingMethods.filter(function (m) {
            // pembeli luar negeri hanya melihat pengiriman internasional, pembeli lokal hanya yang domestik
            return isDomestic() ? m.scope === 'domestic' : m.scope === 'international';
        });

        var cur = methodByKey(current);
        if (!cur || !isAvailable(cur)) {
            var first = list.filter(isAvailable)[0];
            current = first ? first.key : '';
        }

        document.getElementById('ship-list').innerHTML = list.map(function (m) {
            var ok = isAvailable(m);
            var cost = shipCost(m);
            return '<label class="option' + (m.key === current ? ' is-selected' : '') + (ok ? '' : ' is-disabled') + '">' +
                '<input type="radio" name="shipping_method" value="' + U.esc(m.key) + '"' + (m.key === current ? ' checked' : '') + (ok ? '' : ' disabled') + '>' +
                '<span class="radio"><i></i></span>' +
                '<span class="opt-icon">' + U.icon(m.icon === 'truck' ? 'van' : m.icon) + '</span>' +
                '<span class="opt-body"><strong>' + U.esc(m.label) + '</strong><small>' +
                (ok ? U.esc(m.desc) : 'Tidak tersedia untuk kota tujuanmu') + '</small></span>' +
                '<span class="opt-price">' + (cost === 0 ? 'Gratis' : U.rp(cost)) + '</span></label>';
        }).join('');

        renderSummary();
        updateStepper();
    }

    /* ---------------------------------------------------------------- ringkasan */
    function renderSummary(flash) {
        var sub = subtotal();
        var m = methodByKey(getShip());
        var ship = m ? shipCost(m) : 0;
        var shipText = m ? (ship === 0 ? 'Gratis' : U.rp(ship)) : '—';

        var rows = items.map(function (i) {
            return '<li class="sum-item" data-id="' + i.id + '">' +
                '<div class="thumb">' + U.thumb(i.image, i.name) + '</div>' +
                '<div class="info"><strong>' + U.esc(i.name) + '</strong>' +
                (i.variant ? '<span>Warna: ' + U.esc(i.variant) + '</span>' : '') +
                '<span>Qty: ' + i.qty + '</span></div>' +
                '<div class="right"><button type="button" class="icon-btn js-remove" data-id="' + i.id + '" aria-label="Hapus ' + U.esc(i.name) + '">' + U.icon('trash') + '</button>' +
                '<span class="price">' + U.rp(i.price * i.qty) + '</span></div></li>';
        }).join('');

        document.getElementById('summary').innerHTML =
            '<svg class="sprig sprig--tr" aria-hidden="true"><use href="#i-sprig"/></svg>' +
            '<header class="sum-head">' + U.icon('bag') + '<h2>Ringkasan Pesanan</h2></header>' +
            '<ul class="sum-items">' + rows + '</ul>' +
            '<dl class="sum-rows"><div><dt>Subtotal</dt><dd>' + U.rp(sub) + '</dd></div>' +
            '<div><dt>Ongkir</dt><dd class="' + (flash ? 'is-flash' : '') + '">' + shipText + '</dd></div></dl>' +
            '<div class="sum-total"><span>Total</span><strong class="' + (flash ? 'is-flash' : '') + '">' + U.rp(sub + ship) + '</strong></div>' +
            '<div class="notice">' + U.icon('shieldc') + '<p>Pesanan Anda akan diproses setelah pembayaran berhasil.</p></div>' +
            '<button type="submit" class="btn btn--primary" id="submit-btn">Lanjut ke Pembayaran ' + U.icon('arrow') + '</button>' +
            '<p class="secure">' + U.icon('lock') + 'Pembayaran aman dengan sistem enkripsi</p>';
    }

    /* ---------------------------------------------------------------- validasi */
    var rules = {
        recipient_name: function (v) { return v.trim().length >= 3 ? '' : 'Nama lengkap wajib diisi.'; },
        phone: function (v) { return /^[0-9+\-\s]{8,20}$/.test(v.trim()) ? '' : 'Nomor WhatsApp tidak valid.'; },
        email: function (v) { return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v.trim()) ? '' : 'Format email tidak valid.'; },
        country: function (v) { return v ? '' : 'Pilih negara tujuan.'; },
        address: function (v) { return v.trim().length >= 8 ? '' : 'Alamat lengkap wajib diisi.'; },
        city: function (v) { return v.trim().length >= 2 ? '' : 'Kota / kabupaten wajib diisi.'; },
        postal_code: function (v) {
            v = v.trim();
            if (isDomestic()) { return /^\d{5}$/.test(v) ? '' : 'Kode pos harus 5 digit.'; }
            return /^[A-Za-z0-9\- ]{3,10}$/.test(v) ? '' : 'Kode pos tidak valid.';
        }
    };

    function check(name) { return rules[name](String(el(name).value || '')); }

    function showError(name, msg) {
        var box = fieldBox(name);
        if (!box) { return; }
        box.classList.toggle('has-error', !!msg);
        box.querySelector('.err').textContent = msg || '';
    }

    function validateField(name) { var m = check(name); showError(name, m); return !m; }

    function infoOk() { return ['recipient_name', 'phone', 'email'].every(function (n) { return !check(n); }); }
    function addrOk() { return ['country', 'address', 'city', 'postal_code'].every(function (n) { return !check(n); }) && !!getShip(); }

    function updateStepper() {
        var a = infoOk(), b = addrOk();
        var state = [a ? 'done' : 'active', b ? 'done' : (a ? 'active' : 'todo'), (a && b) ? 'active' : 'todo', 'todo'];
        U.stepper(document.getElementById('stepper'), [
            { label: 'Informasi', state: state[0] },
            { label: 'Pengiriman', state: state[1] },
            { label: 'Pembayaran', state: state[2] },
            { label: 'Ringkasan', state: state[3] }
        ]);
    }

    /* ---------------------------------------------------------------- negara / kota */
    function fillCountries() {
        var sel = el('country');
        sel.innerHTML = PC.countries.map(function (c) {
            return '<option value="' + U.esc(c) + '">' + U.esc(c) + '</option>';
        }).join('');
    }

    function syncCountry() {
        var dom = isDomestic();
        var list = document.getElementById('city-list');
        list.innerHTML = dom ? PC.cities.map(function (c) { return '<option value="' + U.esc(c) + '"></option>'; }).join('') : '';
        el('city').placeholder = dom ? 'Pilih atau ketik kota/kabupaten' : 'City';
        el('city').setAttribute('list', dom ? 'city-list' : '');
        document.getElementById('city-chev').style.display = dom ? '' : 'none';
        el('postal_code').placeholder = dom ? 'Cth: 65145' : 'Postal / ZIP code';
        el('postal_code').inputMode = dom ? 'numeric' : 'text';
        el('address').placeholder = dom ? 'Jl. Contoh No. 123, Kel. Contoh, Kec. Contoh' : 'Street address, building, apartment';
    }

    /* ---------------------------------------------------------------- simpan info di browser */
    function loadSaved() {
        try { return JSON.parse(localStorage.getItem(STORE_KEY) || 'null'); } catch (e) { return null; }
    }

    function persist() {
        try {
            if (document.getElementById('save-info').checked) {
                var data = {};
                SAVED.forEach(function (n) { data[n] = el(n).value; });
                localStorage.setItem(STORE_KEY, JSON.stringify(data));
            } else {
                localStorage.removeItem(STORE_KEY);
            }
        } catch (e) { /* mode privat: abaikan */ }
    }

    function prefill() {
        var saved = loadSaved();
        var old = PC.old || {};
        var hasOld = Object.keys(old).length > 0;

        SAVED.forEach(function (n) {
            var v = hasOld ? old[n] : (saved && saved[n]);
            if (v === undefined || v === null || v === '') {
                if (n === 'recipient_name') { v = PC.user.name; }
                if (n === 'email') { v = PC.user.email; }
                if (n === 'country') { v = PC.homeCountry; }
            }
            if (v !== undefined && v !== null) { el(n).value = v; }
        });

        if (!el('country').value) { el('country').value = PC.homeCountry; }
        if (!saved && !hasOld) { document.getElementById('save-info').checked = true; }
    }

    /* ---------------------------------------------------------------- aksi */
    function removeItem(id) {
        var row = document.querySelector('.sum-item[data-id="' + id + '"]');
        var item = items.filter(function (i) { return String(i.id) === String(id); })[0];
        if (!item) { return; }
        if (row) { row.classList.add('is-removing'); }

        fetch(item.removeUrl, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': PC.csrf },
            credentials: 'same-origin'
        }).then(function (res) {
            if (!res.ok) { throw new Error(); }
            return res.json();
        }).then(function (data) {
            items = items.filter(function (i) { return String(i.id) !== String(id); });
            if (data.empty || items.length === 0) { window.location.href = PC.cartUrl; return; }
            setTimeout(function () { renderShipping(); U.toast('Produk dihapus dari pesanan'); }, 180);
        }).catch(function () {
            if (row) { row.classList.remove('is-removing'); }
            U.toast('Gagal menghapus produk. Coba lagi.', 'err');
        });
    }

    function showServerErrors() {
        var errs = PC.errors || {};
        var first = null;
        Object.keys(errs).forEach(function (name) {
            var msg = Array.isArray(errs[name]) ? errs[name][0] : errs[name];
            if (name === 'shipping_method') { document.getElementById('ship-err').textContent = msg; first = first || document.getElementById('sec-shipping'); return; }
            touched[name] = true;
            showError(name, msg);
            first = first || fieldBox(name);
        });
        if (first) { first.scrollIntoView({ behavior: 'smooth', block: 'center' }); }
    }

    /* ---------------------------------------------------------------- pasang event */
    fillCountries();
    prefill();
    syncCountry();
    renderShipping();
    showServerErrors();

    form.addEventListener('input', function (e) {
        var n = e.target.name;
        if (n === 'phone') { e.target.value = e.target.value.replace(/[^0-9+\-\s]/g, ''); }
        if (n === 'postal_code' && isDomestic()) { e.target.value = e.target.value.replace(/\D/g, '').slice(0, 5); }
        if (rules[n]) {
            if (touched[n]) { validateField(n); } else { showError(n, ''); }
            if (n === 'city') { renderShipping(); } else { updateStepper(); }
        }
    });

    form.addEventListener('focusout', function (e) {
        var n = e.target.name;
        if (rules[n]) { touched[n] = true; validateField(n); updateStepper(); }
    });

    form.addEventListener('change', function (e) {
        var n = e.target.name;
        if (n === 'country') {
            syncCountry();
            if (touched.postal_code) { validateField('postal_code'); }
            renderShipping();
        }
        if (n === 'shipping_method') {
            shipTouched = true;
            document.getElementById('ship-err').textContent = '';
            form.querySelectorAll('.option').forEach(function (o) { o.classList.toggle('is-selected', o.querySelector('input').checked); });
            renderSummary(true);
            updateStepper();
        }
        if (n === 'city') { renderShipping(); }
    });

    form.addEventListener('click', function (e) {
        var btn = e.target.closest('.js-remove');
        if (btn) { e.preventDefault(); removeItem(btn.dataset.id); }
    });

    form.addEventListener('submit', function (e) {
        var bad = null;
        Object.keys(rules).forEach(function (n) {
            touched[n] = true;
            if (!validateField(n) && !bad) { bad = n; }
        });

        var noShip = !getShip();
        document.getElementById('ship-err').textContent = noShip ? 'Pilih metode pengiriman.' : '';

        if (bad || noShip) {
            e.preventDefault();
            var target = bad ? el(bad) : document.getElementById('sec-shipping');
            target.scrollIntoView({ behavior: 'smooth', block: 'center' });
            if (bad) { setTimeout(function () { target.focus({ preventScroll: true }); }, 350); }
            U.toast('Lengkapi data yang masih kosong ya', 'err');
            return;
        }

        persist();
        var btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.classList.add('is-loading');
        btn.innerHTML = '<span class="spinner"></span> Memproses...';
    });
})();
