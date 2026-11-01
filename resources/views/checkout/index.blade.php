@extends('layouts.percanesia')

@section('title', 'Checkout - Percanesia')

@section('content')
    <nav class="pc-breadcrumb" aria-label="Breadcrumb"><a href="{{ route('cart.index') }}">Keranjang</a><span>/</span>Checkout</nav>
    <h1 class="pc-title">Checkout</h1>
    <p class="pc-sub">Lengkapi informasi berikut untuk melanjutkan pesanan Anda.</p>

    <div id="stepper" class="stepper stepper--sage stepper--wide" aria-label="Langkah checkout"></div>

    <form id="checkout-form" method="POST" action="{{ route('checkout.store') }}" class="pc-layout" novalidate>
        @csrf

        <div class="pc-card form-card">

            {{-- 1. Informasi pelanggan --}}
            <section class="form-sec" id="sec-info">
                <header class="sec-head">
                    <span class="sec-num">1</span>
                    <svg class="icon"><use href="#i-user"/></svg>
                    <div>
                        <h2>Informasi Pelanggan</h2>
                        <p>Pastikan data yang Anda masukkan sudah benar.</p>
                    </div>
                </header>

                <div class="grid grid-3">
                    <div class="field" data-field="recipient_name">
                        <label for="f-name">Nama Lengkap <i>*</i></label>
                        <div class="input"><svg class="icon"><use href="#i-user"/></svg>
                            <input id="f-name" name="recipient_name" type="text" autocomplete="name" placeholder="Contoh: Tania Sya'bandiah" maxlength="100"></div>
                        <p class="err" role="alert"></p>
                    </div>
                    <div class="field" data-field="phone">
                        <label for="f-phone">No. WhatsApp <i>*</i></label>
                        <div class="input"><svg class="icon"><use href="#i-wa"/></svg>
                            <input id="f-phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" placeholder="08xxxxxxxxxx" maxlength="20"></div>
                        <p class="err" role="alert"></p>
                    </div>
                    <div class="field" data-field="email">
                        <label for="f-email">Email <i>*</i></label>
                        <div class="input"><svg class="icon"><use href="#i-mail"/></svg>
                            <input id="f-email" name="email" type="email" autocomplete="email" placeholder="nama@email.com" maxlength="150"></div>
                        <p class="err" role="alert"></p>
                    </div>
                </div>

                <label class="check">
                    <input type="checkbox" id="save-info" checked>
                    <span class="box"><svg class="icon"><use href="#i-check"/></svg></span>
                    <span>Simpan informasi ini untuk pesanan berikutnya</span>
                </label>
            </section>

            {{-- 2. Alamat pengiriman --}}
            <section class="form-sec" id="sec-address">
                <header class="sec-head">
                    <span class="sec-num">2</span>
                    <svg class="icon"><use href="#i-pin"/></svg>
                    <div>
                        <h2>Alamat Pengiriman</h2>
                        <p>Tentukan alamat lengkap untuk pengiriman pesanan Anda.</p>
                    </div>
                </header>

                <div class="grid grid-1">
                    <div class="field" data-field="country">
                        <label for="f-country">Negara / Country <i>*</i></label>
                        <div class="input"><svg class="icon"><use href="#i-globe"/></svg>
                            <select id="f-country" name="country" autocomplete="country-name"></select>
                            <svg class="icon chev"><use href="#i-down"/></svg></div>
                        <p class="err" role="alert"></p>
                    </div>
                    <div class="field" data-field="address">
                        <label for="f-address">Alamat Lengkap <i>*</i></label>
                        <div class="input"><svg class="icon"><use href="#i-pin"/></svg>
                            <input id="f-address" name="address" type="text" autocomplete="street-address" placeholder="Jl. Contoh No. 123, Kel. Contoh, Kec. Contoh" maxlength="500"></div>
                        <p class="err" role="alert"></p>
                    </div>
                </div>

                <div class="grid grid-city">
                    <div class="field" data-field="city">
                        <label for="f-city">Kota / Kabupaten <i>*</i></label>
                        <div class="input"><svg class="icon"><use href="#i-pin"/></svg>
                            <input id="f-city" name="city" type="text" list="city-list" autocomplete="address-level2" placeholder="Pilih atau ketik kota/kabupaten" maxlength="100">
                            <svg class="icon chev" id="city-chev"><use href="#i-down"/></svg></div>
                        <datalist id="city-list"></datalist>
                        <p class="err" role="alert"></p>
                    </div>
                    <div class="field" data-field="postal_code">
                        <label for="f-postal">Kode Pos <i>*</i></label>
                        <div class="input"><svg class="icon"><use href="#i-mail"/></svg>
                            <input id="f-postal" name="postal_code" type="text" inputmode="numeric" autocomplete="postal-code" placeholder="Cth: 65145" maxlength="10"></div>
                        <p class="err" role="alert"></p>
                    </div>
                </div>
            </section>

            {{-- 3. Metode pengiriman --}}
            <section class="form-sec" id="sec-shipping">
                <header class="sec-head">
                    <span class="sec-num">3</span>
                    <svg class="icon"><use href="#i-van"/></svg>
                    <div>
                        <h2>Metode Pengiriman</h2>
                        <p>Pilih metode pengiriman yang sesuai dengan kebutuhan Anda.</p>
                    </div>
                </header>
                <div id="ship-list" class="options" role="radiogroup" aria-label="Metode pengiriman"></div>
                <p class="err err--block" id="ship-err" role="alert"></p>
            </section>
        </div>

        <aside class="pc-card summary-card" id="summary" aria-label="Ringkasan pesanan"></aside>
    </form>
@endsection

@push('scripts')
<script>window.PC = @json($payload);</script>
<script src="{{ asset('js/checkout.js') }}?v=3"></script>
@endpush
