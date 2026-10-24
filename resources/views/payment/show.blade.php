@extends('layouts.percanesia')

@section('title', 'Pembayaran ' . $order->order_number . ' - Percanesia')

@section('content')
    @inject('money', 'App\Support\Money')

    @php
        $method = $payment->method_config;
        $statusClass = match ($payment->status) {
            'berhasil' => 'is-ok',
            'menunggu_verifikasi' => 'is-wait',
            'ditolak', 'kedaluwarsa' => 'is-bad',
            default => '',
        };
        $statusText = match ($payment->status) {
            'pending' => 'Menunggu pembayaran',
            'menunggu_verifikasi' => 'Menunggu verifikasi',
            'berhasil' => 'Pembayaran berhasil',
            'ditolak' => 'Bukti ditolak, upload ulang',
            'kedaluwarsa' => 'Kedaluwarsa',
            default => $payment->status,
        };
    @endphp

    <nav class="pc-breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span>Pembayaran</nav>
    <h1 class="pc-title">Pembayaran</h1>
    <p class="pc-sub">Nomor pesanan <strong>{{ $order->order_number }}</strong> &nbsp; <span class="status {{ $statusClass }}">{{ $statusText }}</span></p>

    <div class="pc-layout">
        <section class="pc-card pc-card__pad">
            @if ($payment->status === 'kedaluwarsa')
                <h2>Waktu pembayaran habis</h2>
                <p>Pesanan ini dibatalkan karena belum dibayar sampai batas waktu. Kamu bisa membuat pesanan baru dari keranjang.</p>
                <a href="{{ url('/shop') }}" class="btn btn--inline">Kembali Belanja</a>

            @elseif ($payment->status === 'berhasil')
                <h2>Pembayaran diterima</h2>
                <p>Terima kasih, pesananmu sedang kami siapkan.</p>

            @else
                <h2>Selesaikan Pembayaran</h2>

                <div class="label" style="color:var(--muted); font-size:14px;">Total yang harus dibayar</div>
                <div class="pay-total">{{ $money->rp($payment->amount) }}</div>
                @if ($payment->status === 'pending' || $payment->status === 'ditolak')
                    <small style="color:var(--muted)">Bayar sebelum {{ $payment->expires_at->timezone(config('app.timezone'))->translatedFormat('d F Y, H:i') }}</small>
                @endif

                <div class="pay-box">
                    <div class="label">{{ $method['label'] ?? $payment->method }}</div>

                    @if (($method['type'] ?? null) === 'qris')
                        <img class="qris" src="{{ asset($method['image']) }}" alt="QRIS Percanesia">
                    @else
                        <div class="number" id="acc-number">{{ $method['account_number'] ?? '-' }}
                            <button type="button" class="copy-btn" data-copy="{{ $method['account_number'] ?? '' }}">Salin</button>
                        </div>
                        <div class="label">a.n. {{ $method['account_name'] ?? '' }}</div>
                    @endif
                </div>

                @if ($payment->status === 'menunggu_verifikasi')
                    <p>Bukti pembayaranmu sudah kami terima dan sedang dicek. Biasanya selesai dalam 1x24 jam.</p>
                @else
                    <ol class="steps">
                        <li>Bayar sesuai nominal di atas (tanpa dibulatkan).</li>
                        <li>Simpan bukti transfer atau screenshot pembayaran.</li>
                        <li>Upload buktinya di bawah ini.</li>
                    </ol>

                    <form method="POST" action="{{ route('payment.proof', $order) }}" enctype="multipart/form-data" class="upload-form">
                        @csrf
                        <label for="proof"><strong>Upload bukti pembayaran</strong></label>
                        <input id="proof" type="file" name="proof" accept=".jpg,.jpeg,.png,.pdf" required>
                        @error('proof')<div class="error-text" style="margin:-6px 0 12px">{{ $message }}</div>@enderror
                        <button type="submit" class="btn btn--inline">Kirim Bukti <svg class="icon"><use href="#i-arrow"/></svg></button>
                    </form>
                @endif
            @endif
        </section>

        <aside class="pc-card pc-card__pad summary">
            <svg class="sprig sprig--top"><use href="#i-sprig"/></svg>

            <h2>Detail Pesanan</h2>

            @foreach ($order->items as $item)
                <div class="mini-item">
                    @if ($item->product && $item->product->image_url)
                        <img src="{{ $item->product->image_url }}" alt="">
                    @else
                        <div class="noimg"></div>
                    @endif
                    <div class="grow">
                        <div class="name">{{ $item->product_name }}</div>
                        <small>@if ($item->variant){{ $item->variant }} &middot; @endif{{ $item->quantity }} &times; {{ $money->rp($item->price) }}</small>
                    </div>
                    <div>{{ $money->rp($item->subtotal) }}</div>
                </div>
            @endforeach

            <div class="summary__row" style="margin-top:12px"><span>Subtotal</span><span>{{ $money->rp($order->subtotal) }}</span></div>
            <div class="summary__row">
                <span>Ongkir</span>
                @if ((int) $order->shipping_cost === 0)
                    <span class="summary__free">Gratis</span>
                @else
                    <span>{{ $money->rp($order->shipping_cost) }}</span>
                @endif
            </div>
            <div class="summary__row is-total"><span>Total</span><span>{{ $money->rp($order->total) }}</span></div>

            <h3 style="margin-top:26px">Dikirim ke</h3>
            <div style="font-size:15px">
                <strong>{{ $order->recipient_name }}</strong> ({{ $order->phone }})<br>
                {{ $order->address }}<br>
                {{ $order->city }} {{ $order->postal_code }}
            </div>
        </aside>
    </div>

    @include('partials.perks')
@endsection

@push('scripts')
<script>
    // tombol "Salin" nomor rekening
    document.querySelectorAll('[data-copy]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            navigator.clipboard.writeText(btn.dataset.copy).then(function () {
                var old = btn.textContent;
                btn.textContent = 'Tersalin';
                setTimeout(function () { btn.textContent = old; }, 1500);
            });
        });
    });
</script>
@endpush
