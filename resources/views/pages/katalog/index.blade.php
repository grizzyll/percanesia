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
            @if (request('kategori') && request('kategori') !== 'semua')
                <span>/</span>
                <span class="capitalize text-stone-500">{{ str_replace('-', ' ', request('kategori')) }}</span>
            @endif
        </nav>

        {{-- 2. JUDUL HALAMAN & SEARCH --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl sm:text-4xl font-serif text-[#2C3A3F] font-normal">
                    Semua Produk
                </h1>
                <p class="text-xs text-stone-500 mt-1">
                    Menampilkan {{ $products->total() }} karya perca ramah lingkungan
                </p>
            </div>

            {{-- Form Pencarian --}}
            <form action="{{ url('/katalog') }}" method="GET" class="relative max-w-xs w-full">
                @if (request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                @if (request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau bahan..." 
                       class="w-full bg-white border border-stone-300 text-stone-700 text-xs rounded-full pl-4 pr-10 py-2.5 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F] transition">
                <button type="submit" aria-label="Cari" class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-[#2C3A3F]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </form>
        </div>

        {{-- 3. FILTER & SORT BAR --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10 pb-6 border-b border-[#EBE5DC]">
            
            {{-- Filter Kategori Pills --}}
            <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 scrollbar-none">
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
                    @php
                        $params = array_filter([
                            'kategori' => $kat['slug'] === 'semua' ? null : $kat['slug'],
                            'q' => request('q'),
                            'sort' => request('sort'),
                        ]);
                    @endphp
                    <a href="{{ url('/katalog' . ($params ? '?' . http_build_query($params) : '')) }}"
                       class="px-4 py-2 rounded-full text-xs font-medium transition shrink-0 {{ $activeCategory === $kat['slug'] ? 'bg-[#2C3A3F] text-white' : 'bg-white text-stone-700 border border-stone-300 hover:bg-stone-50' }}">
                        {{ $kat['label'] }}
                    </a>
                @endforeach
            </div>

            {{-- Dropdown Sorting --}}
            <div class="flex items-center justify-end shrink-0">
                <div class="relative inline-block text-left">
                    <select onchange="window.location.href=this.value" 
                            class="appearance-none bg-white border border-stone-300 text-stone-700 text-xs rounded-full pl-4 pr-9 py-2 font-medium focus:outline-none focus:ring-1 focus:ring-[#2C3A3F] cursor-pointer">
                        @php
                            $sortOptions = [
                                'terbaru' => 'Terbaru',
                                'termurah' => 'Harga: Rendah ke Tinggi',
                                'termahal' => 'Harga: Tinggi ke Rendah',
                                'terpopuler' => 'Terpopuler',
                            ];
                            $currentSort = request('sort', 'terbaru');
                        @endphp
                        @foreach ($sortOptions as $key => $label)
                            @php
                                $sortParams = array_filter(array_merge(request()->query(), ['sort' => $key]));
                            @endphp
                            <option value="{{ url('/katalog?' . http_build_query($sortParams)) }}" {{ $currentSort === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
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
            @forelse ($products as $item)
                <div class="group flex flex-col">
                    <div class="relative aspect-square rounded-2xl overflow-hidden bg-stone-200">
                        <a href="{{ route('katalog.detail', $item->id) }}" class="block w-full h-full">
                            <img src="{{ $item->image_url ?? 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=600&q=80' }}" 
                                 alt="{{ $item->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </a>
                        
                        {{-- Wishlist / Info Icon --}}
                        <a href="{{ route('katalog.detail', $item->id) }}" 
                           aria-label="Detail Produk" 
                           class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center text-stone-600 hover:text-[#C07A65] transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>

                        @if ($item->stock <= 0)
                            <span class="absolute bottom-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold bg-stone-900/80 text-white backdrop-blur-sm">
                                Habis
                            </span>
                        @elseif ($item->is_featured)
                            <span class="absolute bottom-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#C07A65] text-white shadow-sm">
                                Best Seller
                            </span>
                        @endif
                    </div>

                    <div class="mt-3">
                        <p class="text-[11px] uppercase tracking-wider text-stone-400 font-medium">
                            {{ $item->category }}
                        </p>
                        <a href="{{ route('katalog.detail', $item->id) }}" class="text-sm font-medium text-[#2C3A3F] hover:text-[#C07A65] transition">
                            {{ $item->name }}
                        </a>
                        <p class="text-xs sm:text-sm font-semibold text-stone-700 mt-0.5">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center">
                    <p class="text-stone-500 text-sm">Tidak ada produk perca yang sesuai dengan kriteria filter Anda.</p>
                    <a href="{{ url('/katalog') }}" class="inline-block mt-4 px-6 py-2.5 rounded-full bg-[#2C3A3F] text-white text-xs font-medium hover:bg-black transition">
                        Reset Filter
                    </a>
                </div>
            @endforelse
        </div>

        {{-- 5. PAGINATION --}}
        @if ($products->hasPages())
            <div class="flex justify-center pt-6">
                {{ $products->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
