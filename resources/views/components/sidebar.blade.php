<aside class="w-64 bg-white/95 backdrop-blur-md border-r border-brandPinkLight min-h-screen p-6 flex flex-col justify-between shrink-0">
    <div class="space-y-8">
        {{-- Brand Logo --}}
        <div>
            <a href="{{ route('home') }}" class="text-2xl font-serif text-brandDeep font-medium tracking-tight">
                Percanesia
            </a>
            <span class="block text-[10px] uppercase font-mono tracking-widest text-brandMauve mt-1 font-bold">
                Admin Panel Studio
            </span>
        </div>

        {{-- Navigasi Menu Halaman Admin --}}
        <nav class="space-y-2 text-xs font-medium">
            {{-- 1. Ringkasan Dashboard --}}
            <a href="{{ url('/admin/dashboard') }}" 
               class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->is('admin/dashboard') ? 'bg-brandMauve text-white shadow-sm shadow-brandMauve/30' : 'text-brandText hover:bg-brandBg hover:text-brandDeep' }}">
                <i class="fa-solid fa-chart-pie w-4 text-center"></i>
                <span>Ringkasan Dashboard</span>
            </a>

            {{-- 2. Pesanan Masuk --}}
            <a href="{{ url('/admin/pesanan') }}" 
               class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->is('admin/pesanan') ? 'bg-brandMauve text-white shadow-sm shadow-brandMauve/30' : 'text-brandText hover:bg-brandBg hover:text-brandDeep' }}">
                <i class="fa-solid fa-bag-shopping w-4 text-center"></i>
                <span>Pesanan Masuk</span>
            </a>

            {{-- 3. Kelola Produk & Stok --}}
            <a href="{{ url('/admin/produk') }}" 
               class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->is('admin/produk') ? 'bg-brandMauve text-white shadow-sm shadow-brandMauve/30' : 'text-brandText hover:bg-brandBg hover:text-brandDeep' }}">
                <i class="fa-solid fa-boxes-stacked w-4 text-center"></i>
                <span>Kelola Produk & Stok</span>
            </a>

            {{-- 4. Kotak Pesan Masuk Pelanggan --}}
            <a href="{{ url('/admin/pesan-masuk') }}" 
               class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->is('admin/pesan-masuk') ? 'bg-brandMauve text-white shadow-sm shadow-brandMauve/30' : 'text-brandText hover:bg-brandBg hover:text-brandDeep' }}">
                <i class="fa-solid fa-envelope w-4 text-center"></i>
                <span>Pesan Masuk</span>
            </a>

            {{-- Link Keluar ke Toko Depan --}}
            <a href="{{ url('/') }}" target="_blank" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-brandText hover:bg-brandBg hover:text-brandDeep transition pt-3 border-t border-brandPinkLight/60">
                <i class="fa-solid fa-arrow-up-right-from-square w-4 text-center"></i>
                <span>Lihat Web Toko</span>
            </a>
        </nav>
    </div>

    {{-- Footer Info Admin --}}
    <div class="pt-6 border-t border-brandPinkLight space-y-3">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-2xl bg-brandPinkLight text-brandMauve flex items-center justify-center font-bold text-xs">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-brandDeep">Admin Percanesia</p>
                <p class="text-[11px] text-brandText/70">Studio Malang</p>
            </div>
        </div>
        <a href="{{ route('home') }}" class="block text-center text-xs text-brandMauve hover:text-red-600 transition py-1 font-medium">
            Keluar ke Beranda &rarr;
        </a>
    </div>
</aside>