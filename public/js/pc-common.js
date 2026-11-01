/* Percanesia - fungsi bantu yang dipakai halaman checkout, pembayaran, dan status */
(function (w) {
    'use strict';

    var nf = new Intl.NumberFormat('id-ID');

    var PCU = {
        /** 185000 -> "Rp 185.000" */
        rp: function (n) { return 'Rp ' + nf.format(Math.round(Number(n) || 0)); },

        /** amankan teks sebelum disisipkan ke HTML */
        esc: function (s) {
            return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
            });
        },

        icon: function (name, cls) {
            return '<svg class="icon ' + (cls || '') + '" aria-hidden="true"><use href="#i-' + name + '"/></svg>';
        },

        /** Gambar produk, atau kotak abu-abu bergambar kalau belum ada foto */
        thumb: function (src, alt) {
            if (src) { return '<img src="' + PCU.esc(src) + '" alt="' + PCU.esc(alt || '') + '" loading="lazy">'; }
            return '<span class="thumb-ph">' + PCU.icon('image') + '</span>';
        },

        /** Logo merek kalau file-nya ada, kalau tidak tampil sebagai teks */
        brand: function (b) {
            if (b.logo) { return '<img class="brand-logo" src="' + PCU.esc(b.logo) + '" alt="' + PCU.esc(b.label) + '" loading="lazy">'; }
            return '<span class="brand-chip">' + PCU.esc(b.label) + '</span>';
        },

        /**
         * Gambar langkah-langkah di bagian atas halaman.
         * steps: [{label, state: 'done' | 'active' | 'todo'}]
         */
        stepper: function (el, steps) {
            if (!el) { return; }
            var html = '';
            steps.forEach(function (s, i) {
                if (i > 0) { html += '<span class="step-line' + (steps[i - 1].state === 'done' ? ' is-done' : '') + '"></span>'; }
                html += '<div class="step is-' + s.state + '"' + (s.state === 'active' ? ' aria-current="step"' : '') + '>' +
                    '<span class="dot">' + (s.state === 'done' ? PCU.icon('check') : (i + 1)) + '</span>' +
                    '<span class="lbl">' + PCU.esc(s.label) + '</span></div>';
            });
            el.innerHTML = html;
        },

        toast: function (msg, type) {
            var host = document.getElementById('toasts');
            if (!host) {
                host = document.createElement('div');
                host.id = 'toasts';
                host.setAttribute('aria-live', 'polite');
                document.body.appendChild(host);
            }
            var t = document.createElement('div');
            t.className = 'toast toast--' + (type || 'ok');
            t.textContent = msg;
            host.appendChild(t);
            requestAnimationFrame(function () { t.classList.add('is-in'); });
            setTimeout(function () {
                t.classList.remove('is-in');
                setTimeout(function () { t.remove(); }, 300);
            }, 2400);
        },

        /** Salin teks ke clipboard (dengan cadangan untuk browser lama) */
        copy: function (text, btn) {
            function done() {
                PCU.toast('Tersalin');
                if (btn) {
                    btn.classList.add('is-copied');
                    setTimeout(function () { btn.classList.remove('is-copied'); }, 1500);
                }
            }
            if (navigator.clipboard && w.isSecureContext) {
                navigator.clipboard.writeText(text).then(done, fallback);
            } else { fallback(); }
            function fallback() {
                var ta = document.createElement('textarea');
                ta.value = text; ta.style.position = 'fixed'; ta.style.opacity = '0';
                document.body.appendChild(ta); ta.select();
                try { document.execCommand('copy'); done(); } catch (e) { PCU.toast('Gagal menyalin', 'err'); }
                ta.remove();
            }
        },

        loadScript: function (src, attrs) {
            return new Promise(function (resolve, reject) {
                var existing = document.querySelector('script[src="' + src + '"]');
                if (existing && existing.dataset.loaded) { return resolve(); }
                var s = existing || document.createElement('script');
                s.src = src;
                Object.keys(attrs || {}).forEach(function (k) { s.setAttribute(k, attrs[k]); });
                s.onload = function () { s.dataset.loaded = '1'; resolve(); };
                s.onerror = function () { reject(new Error('Gagal memuat ' + src)); };
                if (!existing) { document.head.appendChild(s); }
            });
        },

        postJson: function (url, csrf, body) {
            return fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                body: JSON.stringify(body || {}),
                credentials: 'same-origin'
            }).then(function (res) {
                return res.json().catch(function () { return {}; }).then(function (data) {
                    if (!res.ok) {
                        var msg = data.message;
                        if (data.errors) { msg = Object.keys(data.errors).map(function (k) { return data.errors[k][0]; })[0]; }
                        var err = new Error(msg || 'Terjadi kesalahan. Coba lagi.');
                        err.status = res.status;
                        throw err;
                    }
                    return data;
                });
            });
        },

        /**
         * Buka popup pembayaran Midtrans.
         * onDone dipanggil setelah pembeli selesai atau menutup popup (arahkan ke halaman status).
         */
        openSnap: function (cfg, token, onDone, onError) {
            if (!cfg.clientKey) {
                onError(new Error('MIDTRANS_CLIENT_KEY belum diisi di file .env'));
                return;
            }
            PCU.loadScript(cfg.snapJs, { 'data-client-key': cfg.clientKey }).then(function () {
                w.snap.pay(token, {
                    onSuccess: onDone,
                    onPending: onDone,
                    onClose: onDone,
                    onError: function () { onError(new Error('Pembayaran gagal. Silakan coba lagi.')); }
                });
            }).catch(onError);
        }
    };

    w.PCU = PCU;
})(window);
