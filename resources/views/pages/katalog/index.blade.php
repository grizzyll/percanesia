@extends('main')

@section('title', 'Semua Produk - Percanesia')

@section('content')
<div class="bg-[#FAF7F2] text-[#2C3A3F] min-h-screen py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- 1. BREADCRUMB --}}
        <nav class="text-xs text-stone-500 mb-6 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-[#2C3A3F]">Home</a>
            <span>/</span>
            <span class="text-[#2C3A3F] font-medium">Shop</span>
        </nav>

        {{-- 2. JUDUL HALAMAN --}}
        <h1 class="text-3xl sm:text-4xl font-serif text-[#2C3A3F] font-normal mb-8">
            Semua Produk
        </h1>

        {{-- 3. FILTER & SORT BAR --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10 pb-6 border-b border-[#EBE5DC]">
            
            {{-- Filter Kategori Pills --}}
            <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 scrollbar-none">
                {{-- Tombol Ikon Filter --}}
                <button type="button" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full border border-stone-300 text-xs font-medium text-stone-700 bg-white hover:bg-stone-50 transition shrink-0">
                    <svg class="w-3.5 h-3.5 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </button>

                @php
                    $activeCategory = request('kategori', 'semua');
                    $kategoris = [
                        ['label' => 'Semua', 'slug' => 'semua'],
                        ['label' => 'Tas', 'slug' => 'tas'],
                        ['label' => 'Dompet', 'slug' => 'dompet'],
                        ['label' => 'Sarung Bantal', 'slug' => 'sarung-bantal'],
                        ['label' => 'Selimut', 'slug' => 'selimut'],
                        ['label' => 'Taplak', 'slug' => 'taplak'],
                        ['label' => 'Aksesoris', 'slug' => 'aksesoris'],
                    ];
                @endphp

                @foreach ($kategoris as $kat)
                    <a href="{{ $kat['slug'] === 'semua' ? url('/katalog') : url('/katalog?kategori=' . $kat['slug']) }}"
                       class="px-4 py-2 rounded-full text-xs font-medium transition shrink-0 {{ $activeCategory === $kat['slug'] ? 'bg-[#2C3A3F] text-white' : 'bg-white text-stone-700 border border-stone-300 hover:bg-stone-50' }}">
                        {{ $kat['label'] }}
                    </a>
                @endforeach
            </div>

            {{-- Dropdown Sorting "Terbaru" --}}
            <div class="flex items-center justify-end shrink-0">
                <div class="relative inline-block text-left">
                    <select class="appearance-none bg-white border border-stone-300 text-stone-700 text-xs rounded-full pl-4 pr-9 py-2 font-medium focus:outline-none focus:ring-1 focus:ring-[#2C3A3F] cursor-pointer">
                        <option value="terbaru">Terbaru</option>
                        <option value="termurah">Harga: Rendah ke Tinggi</option>
                        <option value="termahal">Harga: Tinggi ke Rendah</option>
                        <option value="terpopuler">Terpopuler</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-stone-500">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        {{-- 4. GRID PRODUK (3 Kolom Sesuai Mockup) --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8 mb-16">
            
            @php
                $products = [
                    ['id' => 1, 'name' => 'Patchwork Tote Bag', 'price' => 185000, 'img' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=600&q=80'],
                    ['id' => 2, 'name' => 'Canvas Perca Bag', 'price' => 165000, 'img' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=600&q=80'],
                    ['id' => 3, 'name' => 'Bucket Bag Perca', 'price' => 175000, 'img' => 'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?auto=format&fit=crop&w=600&q=80'],
                    ['id' => 4, 'name' => 'Dompet Perca', 'price' => 65000, 'img' => 'https://images.unsplash.com/photo-1544441893-675973e31985?auto=format&fit=crop&w=600&q=80'],
                    ['id' => 5, 'name' => 'Dompet Lipat Perca', 'price' => 75000, 'img' => 'https://images.unsplash.com/photo-1606503808940-025555d496a7?auto=format&fit=crop&w=600&q=80'],
                    ['id' => 6, 'name' => 'Dompet Kancing Perca', 'price' => 70000, 'img' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=600&q=80'],
                    ['id' => 7, 'name' => 'Sarung Bantal Perca', 'price' => 75000, 'img' => 'https://images.unsplash.com/photo-1579656381226-5fc0f0100c3b?auto=format&fit=crop&w=600&q=80'],
                    ['id' => 8, 'name' => 'Selimut Perca', 'price' => 240000, 'img' => 'https://images.unsplash.com/photo-1584100936595-c0654b55a2e2?auto=format&fit=crop&w=600&q=80'],
                    ['id' => 9, 'name' => 'Taplak Meja Perca', 'price' => 120000, 'img' => 'https://images.unsplash.com/photo-1605371924599-2d0365da1ae0?auto=format&fit=crop&w=600&q=80'],
                ];
            @endphp

            @foreach ($products as $item)
                <div class="group flex flex-col">
                    <div class="relative aspect-square rounded-2xl overflow-hidden bg-stone-200">
                        <img src="{{ $item['img'] }}" 
                             alt="{{ $item['name'] }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        
                        {{-- Wishlist Button --}}
                        <button type="button" aria-label="Wishlist" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center text-stone-600 hover:text-red-500 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </div>

                    <div class="mt-3">
                        <a href="{{ url('/katalog/detail/' . $item['id']) }}" class="text-sm font-medium text-[#2C3A3F] hover:underline">
                            {{ $item['name'] }}
                        </a>
                        <p class="text-xs sm:text-sm font-normal text-stone-600 mt-0.5">
                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @endforeach

        </div>

        {{-- 5. PAGINATION (Sesuai Mockup: 1 2 3 ... 8 >) --}}
        <div class="flex items-center justify-center space-x-2 pt-6">
            <span class="w-8 h-8 rounded-lg bg-[#4F6774] text-white text-xs font-semibold flex items-center justify-center cursor-default">
                1
            </span>
            <a href="#" class="w-8 h-8 rounded-lg text-stone-600 hover:bg-stone-200 text-xs font-medium flex items-center justify-center transition">
                2
            </a>
            <a href="#" class="w-8 h-8 rounded-lg text-stone-600 hover:bg-stone-200 text-xs font-medium flex items-center justify-center transition">
                3
            </a>
            <span class="text-stone-400 text-xs px-1">...</span>
            <a href="#" class="w-8 h-8 rounded-lg text-stone-600 hover:bg-stone-200 text-xs font-medium flex items-center justify-center transition">
                8
            </a>
            <a href="#" class="w-8 h-8 rounded-lg text-stone-600 hover:bg-stone-200 text-xs font-medium flex items-center justify-center transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

    </div>
</div>
@endsection