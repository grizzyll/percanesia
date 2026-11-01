<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Percanesia')</title>
    <link rel="preload" href="{{ asset('fonts/source-serif-4-latin-600-normal.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('fonts/plus-jakarta-sans-latin-400-normal.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/percanesia-checkout.css') }}?v=3">
</head>
<body class="pc">

{{-- kumpulan ikon, dipanggil dengan <svg class="icon"><use href="#i-nama"/></svg> --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
    <symbol id="i-search" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></symbol>
    <symbol id="i-heart" viewBox="0 0 24 24"><path d="M12 20s-7.5-4.6-9-9.5C2 7 4.2 4.5 7 4.5c1.9 0 3.5 1 5 3 1.5-2 3.1-3 5-3 2.8 0 5 2.5 4 6C19.5 15.4 12 20 12 20z"/></symbol>
    <symbol id="i-bag" viewBox="0 0 24 24"><path d="M5 8h14l-1 12H6L5 8z"/><path d="M9 8V6.5a3 3 0 016 0V8"/></symbol>
    <symbol id="i-trash" viewBox="0 0 24 24"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7V4h6v3"/></symbol>
    <symbol id="i-arrow" viewBox="0 0 24 24"><path d="M4 12h16M14 6l6 6-6 6"/></symbol>
    <symbol id="i-user" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/></symbol>
    <symbol id="i-pin" viewBox="0 0 24 24"><path d="M12 21s-6.5-6-6.5-11a6.5 6.5 0 0113 0c0 5-6.5 11-6.5 11z"/><circle cx="12" cy="10" r="2.5"/></symbol>
    <symbol id="i-mail" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></symbol>
    <symbol id="i-wa" viewBox="0 0 24 24"><path d="M4 20l1.3-4A8.5 8.5 0 1112 20.5a8.4 8.4 0 01-4.2-1.1L4 20z"/><path d="M9.2 9c.3 2.3 2.4 4.3 5.1 5.1l1.2-1.3-2-1.1-.9.8c-.8-.4-1.6-1.2-2-2l.8-.9-1.1-2L9.2 9z"/></symbol>
    <symbol id="i-van" viewBox="0 0 24 24"><path d="M2 6.5h11v10H2zM13 9.5h4l4 3.5v3.5h-8"/><circle cx="6.5" cy="17.5" r="1.8"/><circle cx="17" cy="17.5" r="1.8"/></symbol>
    <symbol id="i-plane" viewBox="0 0 24 24"><path d="M21 3L3 10.5l6.5 2.5L12 20.5 21 3z"/><path d="M9.5 13L21 3"/></symbol>
    <symbol id="i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></symbol>
    <symbol id="i-globe" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c3 3 3 15 0 18M12 3c-3 3-3 15 0 18"/></symbol>
    <symbol id="i-lock" viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="9" rx="2"/><path d="M8 11V8a4 4 0 018 0v3"/></symbol>
    <symbol id="i-shieldc" viewBox="0 0 24 24"><path d="M12 3l8 3v6c0 4.5-3.2 7.8-8 9-4.8-1.2-8-4.5-8-9V6l8-3z"/><path d="M8.5 12l2.5 2.5 4.5-5"/></symbol>
    <symbol id="i-check" viewBox="0 0 24 24"><path d="M5 12.5l4.5 4.5L19 7.5"/></symbol>
    <symbol id="i-info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8h.01"/></symbol>
    <symbol id="i-alert" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7.5v5.5M12 16.5h.01"/></symbol>
    <symbol id="i-copy" viewBox="0 0 24 24"><rect x="9" y="9" width="11" height="11" rx="2"/><path d="M5 15V6a2 2 0 012-2h9"/></symbol>
    <symbol id="i-image" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="1.8"/><path d="M4 18l5-5 4 4 3-3 4 4"/></symbol>
    <symbol id="i-down" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></symbol>
    <symbol id="i-left" viewBox="0 0 24 24"><path d="M15 6l-6 6 6 6"/></symbol>
    <symbol id="i-cash" viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="11" rx="2"/><circle cx="12" cy="12.5" r="2.5"/><path d="M6 10v5M18 10v5"/></symbol>
    <symbol id="i-upload" viewBox="0 0 24 24"><path d="M12 16V4M7 9l5-5 5 5M4 20h16"/></symbol>
    <symbol id="i-truck" viewBox="0 0 48 48"><path d="M16 12h18v20H16zM34 19h6l4 6v7h-10"/><circle cx="21" cy="35" r="3.5"/><circle cx="39" cy="35" r="3.5"/><path d="M4 18h9M7 24h7M10 30h4"/></symbol>
    <symbol id="i-shield" viewBox="0 0 48 48"><path d="M24 5l16 6v12c0 10-7 17-16 20C15 40 8 33 8 23V11l16-6z"/><path d="M16 24l6 6 11-12"/></symbol>
    <symbol id="i-award" viewBox="0 0 48 48"><circle cx="24" cy="19" r="12"/><circle cx="24" cy="19" r="8"/><path d="M17 30l-4 14 11-5 11 5-4-14"/></symbol>
    <symbol id="i-sprig" viewBox="0 0 90 120"><path d="M70 118C62 90 60 60 66 8" fill="none" stroke="currentColor" stroke-width="1"/><g fill="none" stroke="currentColor" stroke-width="1"><ellipse cx="58" cy="30" rx="9" ry="4" transform="rotate(-35 58 30)"/><ellipse cx="76" cy="40" rx="9" ry="4" transform="rotate(35 76 40)"/><ellipse cx="56" cy="58" rx="10" ry="4" transform="rotate(-40 56 58)"/><ellipse cx="74" cy="70" rx="10" ry="4" transform="rotate(38 74 70)"/><ellipse cx="55" cy="88" rx="10" ry="4" transform="rotate(-40 55 88)"/><circle cx="66" cy="8" r="3"/><circle cx="50" cy="22" r="2.5"/><circle cx="82" cy="30" r="2.5"/></g></symbol>
</svg>

@php
    $cartCount = \App\Models\Cart::current()->itemCount();
@endphp

<header class="pc-header">
    <div class="pc-header__inner">
        <a href="{{ url('/') }}" class="pc-logo" aria-label="Percanesia"><img src="{{ asset('images/logo-percanesia.png') }}" alt="Percanesia" width="1000" height="407"></a>

        {{-- ganti url di bawah dengan route halaman milik tim --}}
        <nav class="pc-nav" aria-label="Menu utama">
            <a href="{{ url('/') }}" class="is-active">Home</a>
            <a href="{{ url('/shop') }}">Shop</a>
            <a href="{{ url('/collections') }}">Collections</a>
            <a href="{{ url('/about') }}">About Us</a>
            <a href="{{ url('/journal') }}">Journal</a>
            <a href="{{ url('/contact') }}">Contact</a>
        </nav>

        <div class="pc-actions">
            <a href="{{ url('/shop') }}" aria-label="Cari"><svg class="icon"><use href="#i-search"/></svg></a>
            <a href="{{ url('/wishlist') }}" aria-label="Wishlist"><svg class="icon"><use href="#i-heart"/></svg></a>
            <a href="{{ route('cart.index') }}" aria-label="Keranjang">
                <svg class="icon"><use href="#i-bag"/></svg>
                <span class="pc-badge" data-count="{{ $cartCount }}">{{ $cartCount }}</span>
            </a>
        </div>
    </div>
</header>

<main class="pc-main">
    @if (session('success'))<div class="flash flash--success">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="flash flash--error">{{ session('error') }}</div>@endif

    @yield('content')

    @include('partials.perks')
</main>

<footer class="pc-footer">&copy; {{ date('Y') }} Percanesia</footer>

<script src="{{ asset('js/pc-common.js') }}?v=3"></script>
@stack('scripts')
</body>
</html>
