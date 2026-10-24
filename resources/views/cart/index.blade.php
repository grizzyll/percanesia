@extends('layouts.percanesia')

@section('title', 'Keranjang Belanja - Percanesia')

@section('content')
    @inject('money', 'App\Support\Money')

    <nav class="pc-breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span>Keranjang</nav>
    <h1 class="pc-title">Keranjang Belanja</h1>
    <p class="pc-sub">Tinjau kembali pesananmu sebelum melanjutkan pembayaran.</p>

    @if ($cart->items->isEmpty())
        <div class="pc-card empty">
            <p>Keranjangmu masih kosong.</p>
            <a href="{{ url('/shop') }}" class="btn btn--inline">Mulai Belanja</a>
        </div>
    @else
        <div class="pc-layout">
            <section class="pc-card pc-card__pad">
                <div class="cart-head">
                    <span>Produk</span>
                    <span>Harga</span>
                    <span>Jumlah</span>
                    <span>Subtotal</span>
                    <span></span>
                </div>

                @foreach ($cart->items as $item)
                    <div class="cart-row">
                        <div class="cart-product">
                            @if ($item->product->image_url)
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                            @else
                                <div class="noimg"></div>
                            @endif
                            <div>
                                <h4>{{ $item->product->name }}</h4>
                                @if ($item->variant)<small>Warna: {{ $item->variant }}</small>@endif
                            </div>
                        </div>

                        <div class="cart-price">{{ $money->rp($item->product->price) }}</div>

                        <form method="POST" action="{{ route('cart.update', $item->id) }}" class="qty">
                            @csrf
                            @method('PATCH')
                            <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" aria-label="Kurangi" @disabled($item->quantity <= 1)>&minus;</button>
                            <span>{{ $item->quantity }}</span>
                            <button type="submit" name="quantity" value="{{ min(99, $item->quantity + 1) }}" aria-label="Tambah" @disabled($item->quantity >= 99)>+</button>
                        </form>

                        <div class="cart-subtotal">{{ $money->rp($item->subtotal) }}</div>

                        <form method="POST" action="{{ route('cart.destroy', $item->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-btn" aria-label="Hapus {{ $item->product->name }}"><svg class="icon"><use href="#i-trash"/></svg></button>
                        </form>
                    </div>
                @endforeach
            </section>

            <aside class="pc-card pc-card__pad summary">
                <svg class="sprig sprig--top"><use href="#i-sprig"/></svg>
                <svg class="sprig sprig--bottom"><use href="#i-sprig"/></svg>

                <h2>Ringkasan Belanja</h2>

                <div class="summary__row"><span>Subtotal</span><span>{{ $money->rp($cart->subtotal()) }}</span></div>
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

                <a href="{{ route('checkout.index') }}" class="btn">Checkout <svg class="icon"><use href="#i-arrow"/></svg></a>
            </aside>
        </div>
    @endif

    @include('partials.perks')
@endsection
