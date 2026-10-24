@inject('money', 'App\Support\Money')

<section class="perks">
    <div class="perk">
        <svg class="icon"><use href="#i-truck"/></svg>
        <div>
            <strong>Gratis Ongkir</strong>
            @if (config('shop.free_shipping_min'))
                <small>Min. belanja {{ $money->rp(config('shop.free_shipping_min')) }}</small>
            @else
                <small>Untuk semua pesanan</small>
            @endif
        </div>
    </div>
    <div class="perk">
        <svg class="icon"><use href="#i-shield"/></svg>
        <div>
            <strong>Pembayaran Aman</strong>
            <small>100% secure payment</small>
        </div>
    </div>
    <div class="perk">
        <svg class="icon"><use href="#i-award"/></svg>
        <div>
            <strong>Garansi Produk</strong>
            <small>7 hari ganti baru</small>
        </div>
    </div>
</section>
