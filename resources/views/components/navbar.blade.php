<header class="w-full sticky top-0 z-50 bg-[#FAF7F2]/95 backdrop-blur-md border-b border-[#EBE5DC]" 
        x-data="{ mobileMenuOpen: false, searchOpen: false, userDropdownOpen: false }">
    
    {{-- 1. TOP ANNOUNCEMENT BAR (Sesuai Mockup) --}}
    <div class="bg-[#2C3A3F] text-white/90 text-center py-2 px-4 text-xs font-light tracking-wide">
        Gratis ongkir untuk pembelian di atas Rp150.000
    </div>

    {{-- 2. MAIN NAVBAR --}}
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-5 flex items-center justify-between">
        
        {{-- Sisi Kiri: Hamburger Button (Khusus Mobile) + Brand Logo --}}
        <div class="flex items-center gap-3">
            {{-- Tombol Mobile Hamburger --}}
            <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="md:hidden text-[#2C3A3F] hover:text-[#C07A65] p-1 transition" 
                    aria-label="Toggle Mobile Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;"/>
                </svg>
            </button>

            {{-- Brand Logo --}}
            <a href="{{ url('/') }}" class="text-2xl sm:text-3xl font-serif text-[#2C3A3F] font-medium tracking-tight">
                Percanesia
            </a>
        </div>

        {{-- Sisi Tengah: Menu Navigasi Desktop (Semua Menu Lengkap) --}}
        <div class="hidden md:flex items-center space-x-7 lg:space-x-8 text-xs font-medium text-stone-700 tracking-wider">
            {{-- 1. Home --}}
            <a href="{{ url('/') }}" 
               class="transition hover:text-[#2C3A3F] py-1 border-b-2 {{ request()->is('/') ? 'border-[#2C3A3F] text-[#2C3A3F] font-bold' : 'border-transparent' }}">
                Home
            </a>

            {{-- 2. Shop / Katalog --}}
            <a href="{{ url('/katalog') }}" 
               class="transition hover:text-[#2C3A3F] py-1 border-b-2 {{ request()->is('katalog') && !request()->has('kategori') ? 'border-[#2C3A3F] text-[#2C3A3F] font-bold' : 'border-transparent' }}">
                Shop
            </a>

            {{-- 3. Collections (Koleksi Tas Pilihan) --}}
            <a href="{{ url('/katalog?kategori=tas') }}" 
               class="transition hover:text-[#2C3A3F] py-1 border-b-2 {{ request()->get('kategori') === 'tas' ? 'border-[#2C3A3F] text-[#2C3A3F] font-bold' : 'border-transparent' }}">
                Collections
            </a>

            {{-- 4. About Us --}}
            <a href="{{ url('/about') }}" 
               class="transition hover:text-[#2C3A3F] py-1 border-b-2 {{ request()->is('about') ? 'border-[#2C3A3F] text-[#2C3A3F] font-bold' : 'border-transparent' }}">
                About Us
            </a>

            {{-- 5. Contact --}}
            <a href="{{ url('/contact') }}" 
               class="transition hover:text-[#2C3A3F] py-1 border-b-2 {{ request()->is('contact') ? 'border-[#2C3A3F] text-[#2C3A3F] font-bold' : 'border-transparent' }}">
                Contact
            </a>
        </div>

        {{-- Sisi Kanan: 4 Ikon Aksi (Search, Wishlist, Cart, Profile) --}}
        <div class="flex items-center space-x-4 sm:space-x-5 text-[#2C3A3F]">
            
            {{-- 1. Pencarian (Search Toggle) --}}
            <button type="button" @click="searchOpen = !searchOpen" 
                    class="hover:text-[#C07A65] p-1 transition" aria-label="Cari Produk">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>

            {{-- 2. Wishlist --}}
            <a href="{{ url('/katalog') }}" class="relative hover:text-[#C07A65] p-1 transition" aria-label="Daftar Keinginan">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </a>

            {{-- 3. Keranjang Belanja (Cart) dengan Badge Angka --}}
            <a href="{{ url('/cart') }}" class="relative hover:text-[#C07A65] p-1 transition" aria-label="Keranjang Belanja">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <span class="absolute -top-1 -right-1 bg-[#2C3A3F] text-white text-[9px] w-4 h-4 rounded-full flex items-center justify-center font-bold">
                    3
                </span>
            </a>

            {{-- 4. Akun / Dropdown User --}}
            <div class="relative">
                <button type="button" @click="userDropdownOpen = !userDropdownOpen" 
                        class="hover:text-[#C07A65] p-1 transition flex items-center focus:outline-none" aria-label="Menu Akun">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </button>

                {{-- Dropdown Menu Akun --}}
                <div x-show="userDropdownOpen" 
                     @click.away="userDropdownOpen = false" 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-xl border border-[#EBE5DC] py-2 text-xs z-50"
                     style="display: none;">
                    
                    <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-stone-700 hover:bg-[#FAF7F2] hover:text-[#2C3A3F]">
                        <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span>Dashboard Admin</span>
                    </a>

                    <a href="{{ url('/login') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-stone-700 hover:bg-[#FAF7F2] hover:text-[#2C3A3F]">
                        <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        <span>Login Pelanggan</span>
                    </a>
                </div>
            </div>

        </div>
    </nav>

    {{-- 3. BAR PENCARIAN SLIDE-DOWN (Muncul saat tombol cari diklik) --}}
    <div x-show="searchOpen" 
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="border-t border-[#EBE5DC] bg-white py-3 px-4 sm:px-8" style="display: none;">
        <form action="{{ url('/katalog') }}" method="GET" class="max-w-2xl mx-auto flex items-center gap-3">
            <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="q" placeholder="Cari karya kriya perca (misal: tote bag, selimut, sarung bantal)..." 
                   class="w-full text-xs text-[#2C3A3F] border-none focus:outline-none focus:ring-0 placeholder:text-stone-400">
            <button type="button" @click="searchOpen = false" class="text-stone-400 hover:text-stone-600 text-xs">Tutup</button>
        </form>
    </div>

    {{-- 4. DRAWER MENU MOBILE (Untuk tampilan layar HP) --}}
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="md:hidden border-t border-[#EBE5DC] bg-white px-6 py-5 space-y-3 text-xs font-medium"
         style="display: none;">
        
        <a href="{{ url('/') }}" class="block py-2 text-[#2C3A3F] hover:text-[#C07A65]">Home</a>
        <a href="{{ url('/katalog') }}" class="block py-2 text-[#2C3A3F] hover:text-[#C07A65]">Shop (Semua Produk)</a>
        <a href="{{ url('/katalog?kategori=tas') }}" class="block py-2 text-[#2C3A3F] hover:text-[#C07A65]">Collections</a>
        <a href="{{ url('/about') }}" class="block py-2 text-[#2C3A3F] hover:text-[#C07A65]">About Us (Kisah & Pengrajin)</a>
        <a href="{{ url('/contact') }}" class="block py-2 text-[#2C3A3F] hover:text-[#C07A65]">Contact & Workshop Malang</a>
        
        <div class="pt-3 border-t border-[#EBE5DC] flex flex-col gap-2">
            <a href="{{ url('/cart') }}" class="py-2 text-[#2C3A3F] flex items-center justify-between">
                <span>Keranjang Belanja</span>
                <span class="bg-[#2C3A3F] text-white text-[10px] px-2 py-0.5 rounded-full">3 Item</span>
            </a>
            <a href="{{ url('/admin/dashboard') }}" class="py-2 text-[#C07A65] font-semibold">
                Masuk ke Dashboard Admin &rarr;
            </a>
        </div>
    </div>

</header>