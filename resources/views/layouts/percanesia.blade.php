<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Percanesia')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600&family=Source+Serif+4:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/percanesia-checkout.css') }}">
</head>
<body class="pc">

{{-- kumpulan ikon, dipanggil dengan <svg class="icon"><use href="#i-nama"/></svg> --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
    <symbol id="i-search" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></symbol>
    <symbol id="i-heart" viewBox="0 0 24 24"><path d="M12 20s-7.5-4.6-9-9.5C2 7 4.2 4.5 7 4.5c1.9 0 3.5 1 5 3 1.5-2 3.1-3 5-3 2.8 0 5 2.5 4 6C19.5 15.4 12 20 12 20z"/></symbol>
    <symbol id="i-bag" viewBox="0 0 24 24"><path d="M5 8h14l-1 12H6L5 8z"/><path d="M9 8V6.5a3 3 0 016 0V8"/></symbol>
    <symbol id="i-trash" viewBox="0 0 24 24"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7V4h6v3"/></symbol>
    <symbol id="i-arrow" viewBox="0 0 24 24"><path d="M4 12h16M14 6l6 6-6 6"/></symbol>
    <symbol id="i-truck" viewBox="0 0 48 48"><path d="M16 12h18v20H16zM34 19h6l4 6v7h-10"/><circle cx="21" cy="35" r="3.5"/><circle cx="39" cy="35" r="3.5"/><path d="M4 18h9M7 24h7M10 30h4"/></symbol>
    <symbol id="i-shield" viewBox="0 0 48 48"><path d="M24 5l16 6v12c0 10-7 17-16 20C15 40 8 33 8 23V11l16-6z"/><path d="M16 24l6 6 11-12"/></symbol>
    <symbol id="i-award" viewBox="0 0 48 48"><circle cx="24" cy="19" r="12"/><circle cx="24" cy="19" r="8"/><path d="M17 30l-4 14 11-5 11 5-4-14"/></symbol>
    <symbol id="i-sprig" viewBox="0 0 90 120"><path d="M70 118C62 90 60 60 66 8" fill="none" stroke="currentColor" stroke-width="1"/><g fill="none" stroke="currentColor" stroke-width="1"><ellipse cx="58" cy="30" rx="9" ry="4" transform="rotate(-35 58 30)"/><ellipse cx="76" cy="40" rx="9" ry="4" transform="rotate(35 76 40)"/><ellipse cx="56" cy="58" rx="10" ry="4" transform="rotate(-40 56 58)"/><ellipse cx="74" cy="70" rx="10" ry="4" transform="rotate(38 74 70)"/><ellipse cx="55" cy="88" rx="10" ry="4" transform="rotate(-40 55 88)"/><circle cx="66" cy="8" r="3"/><circle cx="50" cy="22" r="2.5"/><circle cx="82" cy="30" r="2.5"/></g></symbol>
</svg>

@php
    $cartCount = isset($cart) ? $cart->itemCount() : \App\Models\Cart::current()->itemCount();
@endphp

<header class="pc-header">
    <div class="pc-header__inner">
        <a href="{{ url('/') }}" class="pc-logo"><img src="{{ asset('images/logo-percanesia.png') }}" alt="Percanesia"></a>

        {{-- ganti url di bawah dengan route halaman milik tim --}}
        <nav class="pc-nav">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('/shop') }}">Shop</a>
            <a href="{{ url('/collections') }}">Collections</a>
            <a href="{{ url('/about') }}">About Us</a>
            <a href="{{ url('/contact') }}">Contact</a>
        </nav>

        <div class="pc-actions">
            <a href="{{ url('/shop') }}" aria-label="Cari"><svg class="icon"><use href="#i-search"/></svg></a>
            <a href="{{ url('/wishlist') }}" aria-label="Wishlist"><svg class="icon"><use href="#i-heart"/></svg></a>
            <a href="{{ route('cart.index') }}" aria-label="Keranjang">
                <svg class="icon"><use href="#i-bag"/></svg>
                @if ($cartCount > 0)<span class="pc-badge">{{ $cartCount }}</span>@endif
            </a>
        </div>
    </div>
</header>

<main class="pc-main">
    @if (session('success'))<div class="flash flash--success">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="flash flash--error">{{ session('error') }}</div>@endif

    @yield('content')
</main>

<footer class="pc-footer">&copy; {{ date('Y') }} Percanesia</footer>

@stack('scripts')
</body>
</html>
