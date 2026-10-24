@extends('layouts.percanesia')

@section('title', 'Checkout - Percanesia')

@section('content')
    @inject('money', 'App\Support\Money')

    <nav class="pc-breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span><a href="{{ route('cart.index') }}">Keranjang</a><span>/</span>Checkout</nav>
    <h1 class="pc-title">Checkout</h1>
    <p class="pc-sub">Isi data pengiriman dan pilih cara pembayaran.</p>

    <form method="POST" action="{{ route('checkout.store') }}" class="pc-layout">
        @csrf

        <div style="display:grid; gap:20px;">
            <section class="pc-card pc-card__pad">
                <h2>Data Penerima</h2>

                <div class="form-grid">
                    <div class="field @error('recipient_name') has-error @enderror">
                        <label for="recipient_name">Nama penerima</label>
                        <input id="recipient_name" type="text" name="recipient_name" value="{{ old('recipient_name', $user->name ?? '') }}" required>
                        @error('recipient_name')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="field @error('phone') has-error @enderror">
                        <label for="phone">No. telepon / WhatsApp</label>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
                        @error('phone')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="field full @error('address') has-error @enderror">
                        <label for="address">Alamat lengkap</label>
                        <textarea id="address" name="address" placeholder="Nama jalan, RT/RW, kelurahan, kecamatan" required>{{ old('address') }}</textarea>
                        @error('address')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="field @error('city') has-error @enderror">
                        <label for="city">Kota / kabupaten</label>
                        <input id="city" type="text" name="city" value="{{ old('city') }}" required>
                        @error('city')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="field @error('postal_code') has-error @enderror">
                        <label for="postal_code">Kode pos</label>
                        <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code') }}" inputmode="numeric" maxlength="5" required>
                        @error('postal_code')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="field full @error('note') has-error @enderror">
                        <label for="note">Catatan untuk penjual (opsional)</label>
                        <textarea id="note" name="note" style="min-height:64px">{{ old('note') }}</textarea>
                        @error('note')<div class="error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </section>

            <section class="pc-card pc-card__pad">
                <h2>Metode Pembayaran</h2>

                <div class="methods">
                    @foreach ($methods as $key => $method)
                        <label class="method">
                            <input type="radio" name="payment_method" value="{{ $key }}" @checked(old('payment_method') === $key) required>
                            <span>
                                <strong>{{ $method['label'] }}</strong>
                                <small>
                                    @if ($method['type'] === 'bank') Transfer manual, lalu upload bukti
                                    @elseif ($method['type'] === 'qris') Scan kode QR dari aplikasi apa saja
                                    @else Kirim ke nomor e-wallet, lalu upload bukti
                                    @endif
                                </small>
                            </span>
                        </label>
                    @endforeach
                </div>
                @error('payment_method')<div class="error-text">{{ $message }}</div>@enderror
            </section>
        </div>

        <aside class="pc-card pc-card__pad summary">
            <svg class="sprig sprig--top"><use href="#i-sprig"/></svg>

            <h2>Ringkasan Pesanan</h2>

            @foreach ($cart->items as $item)
                <div class="mini-item">
                    @if ($item->product->image_url)
                        <img src="{{ $item->product->image_url }}" alt="">
                    @else
                        <div class="noimg"></div>
                    @endif
                    <div class="grow">
                        <div class="name">{{ $item->product->name }}</div>
                        <small>@if ($item->variant){{ $item->variant }} &middot; @endif{{ $item->quantity }} &times; {{ $money->rp($item->product->price) }}</small>
                    </div>
                    <div>{{ $money->rp($item->subtotal) }}</div>
                </div>
            @endforeach

            <div class="summary__row" style="margin-top:12px"><span>Subtotal</span><span>{{ $money->rp($cart->subtotal()) }}</span></div>
            <div class="summary__row">
                <span>Ongkir</span>
                @if ($cart->shippingCost() === 0)
                    <span class="summary__free">Gratis</span>
                @else
                    <span>{{ $money->rp($cart->shippingCost()) }}</span>
                @endif
            </div>
            <div class="summary__row is-total"><span>Total</span><span>{{ $money->rp($cart->total()) }}</span></div>
            <p class="summary__note">*Belum termasuk pajak.</p>

            <button type="submit" class="btn">Buat Pesanan <svg class="icon"><use href="#i-arrow"/></svg></button>
            <p style="text-align:center; margin:14px 0 0;"><a href="{{ route('cart.index') }}" style="color:var(--muted); font-size:14px;">&larr; Kembali ke keranjang</a></p>
        </aside>
    </form>

    @include('partials.perks')
@endsection
