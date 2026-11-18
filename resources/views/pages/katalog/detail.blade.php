@extends('main')

@section('title', $product->name . ' - Percanesia')

@section('content')
<div class="bg-[#FAF7F2] text-[#2C3A3F] min-h-screen py-8 sm:py-12" x-data="{ 
    activeImg: '{{ $product->image_url ?? "https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=900&q=80" }}',
    qty: 1,
    maxQty: {{ max(1, (int)$product->stock) }},
    activeTab: 'deskripsi',
    selectedColor: 'Terracotta'
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- 1. BREADCRUMB --}}
        <nav class="text-xs text-stone-500 mb-8 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-[#2C3A3F]">Home</a>
            <span>/</span>
            <a href="{{ url('/katalog') }}" class="hover:text-[#2C3A3F]">Katalog</a>
            <span>/</span>
            <a href="{{ url('/katalog?kategori=' . Str::slug($product->category)) }}" class="hover:text-[#2C3A3F]">{{ $product->category }}</a>
            <span>/</span>
            <span class="text-[#2C3A3F] font-medium">{{ $product->name }}</span>
        </nav>

        {{-- 2. MAIN PRODUCT SECTION (2 KOLOM) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 mb-16">
            
            {{-- KOLOM KIRI: GALERI GAMBAR --}}
            <div class="lg:col-span-7 flex flex-col-reverse sm:flex-row gap-4">
                {{-- Thumbnails List --}}
                @php
                    $mainImg = $product->image_url ?? 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=900&q=80';
                    $thumbnails = [
                        $mainImg,
                        'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?auto=format&fit=crop&w=900&q=80',
                        'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=900&q=80',
                        'https://images.unsplash.com/photo-1544441893-675973e31985?auto=format&fit=crop&w=900&q=80',
                    ];
                @endphp

                <div class="flex sm:flex-col gap-3 shrink-0 overflow-x-auto sm:overflow-visible">
                    @foreach ($thumbnails as $thumb)
                        <button type="button" 
                                @click="activeImg = '{{ $thumb }}'"
                                :class="activeImg === '{{ $thumb }}' ? 'border-[#2C3A3F] ring-1 ring-[#2C3A3F]' : 'border-[#EBE5DC] opacity-70 hover:opacity-100'"
                                class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl overflow-hidden border bg-white p-0.5 transition shrink-0">
                            <img src="{{ $thumb }}" alt="Thumbnail {{ $product->name }}" class="w-full h-full object-cover rounded-lg">
                        </button>
                    @endforeach
                </div>

                {{-- Foto Utama Besar --}}
                <div class="relative flex-1 aspect-[4/4.5] rounded-3xl overflow-hidden bg-stone-200 shadow-sm border border-[#EBE5DC]">
                    <img :src="activeImg" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    
                    {{-- Zoom Icon --}}
                    <div class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center text-stone-600 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                        </svg>
                    </div>

                    @if ($product->stock <= 0)
                        <span class="absolute top-4 left-4 px-3 py-1.5 rounded-full text-xs font-bold bg-stone-900/90 text-white backdrop-blur-sm">
                            Stok Habis
                        </span>
                    @endif
                </div>
            </div>

            {{-- KOLOM KANAN: DETAIL & BELI --}}
            <div class="lg:col-span-5 flex flex-col justify-between space-y-6">
                <div>
                    {{-- Kategori & Judul & Harga --}}
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium bg-[#879685]/15 text-[#556953] mb-2">
                        {{ $product->category }}
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-serif text-[#2C3A3F] font-normal">
                        {{ $product->name }}
                    </h1>
                    <p class="text-2xl font-serif font-medium text-[#2C3A3F] mt-2">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    {{-- Rating Bintang --}}
                    <div class="flex items-center gap-2 mt-3">
                        <div class="flex text-amber-500">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-xs text-stone-500">(Produk Asli Percanesia)</span>
                    </div>

                    {{-- Deskripsi Singkat --}}
                    <p class="text-stone-600 text-xs sm:text-sm leading-relaxed mt-4 font-light">
                        {{ $product->description ?? 'Produk kriya perca handmade ramah lingkungan hasil karya pengrajin terampil lokal.' }}
                    </p>

                    {{-- Pilihan Warna/Varian --}}
                    <div class="mt-6">
                        <div class="flex items-center justify-between mb-2.5">
                            <p class="text-xs font-semibold text-[#2C3A3F]">Pilihan Nuansa Varian</p>
                            <span class="text-xs text-[#C07A65] font-medium" x-text="selectedColor"></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" @click="selectedColor = 'Terracotta'" :class="selectedColor === 'Terracotta' ? 'ring-2 ring-offset-2 ring-[#C07A65]' : ''" class="w-6 h-6 rounded-full bg-[#C07A65] transition" title="Terracotta"></button>
                            <button type="button" @click="selectedColor = 'Sage Green'" :class="selectedColor === 'Sage Green' ? 'ring-2 ring-offset-2 ring-[#879685]' : ''" class="w-6 h-6 rounded-full bg-[#879685] transition" title="Sage Green"></button>
                            <button type="button" @click="selectedColor = 'Mustard Gold'" :class="selectedColor === 'Mustard Gold' ? 'ring-2 ring-offset-2 ring-[#D4A373]' : ''" class="w-6 h-6 rounded-full bg-[#D4A373] transition" title="Mustard Gold"></button>
                            <button type="button" @click="selectedColor = 'Indigo Blue'" :class="selectedColor === 'Indigo Blue' ? 'ring-2 ring-offset-2 ring-[#4F6774]' : ''" class="w-6 h-6 rounded-full bg-[#4F6774] transition" title="Indigo Blue"></button>
                            <button type="button" @click="selectedColor = 'Linen Cream'" :class="selectedColor === 'Linen Cream' ? 'ring-2 ring-offset-2 ring-[#CCD5AE]' : ''" class="w-6 h-6 rounded-full bg-[#CCD5AE] transition" title="Linen Cream"></button>
                        </div>
                    </div>

                    {{-- Status Stok --}}
                    <div class="mt-6 flex items-center gap-2 text-xs text-stone-600">
                        <span class="font-semibold text-[#2C3A3F]">Ketersediaan Stok:</span>
                        @if ($product->stock > 0)
                            <span class="inline-flex items-center gap-1.5 text-emerald-700 font-medium">
                                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                Tersedia ({{ $product->stock }} unit)
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-red-600 font-medium">
                                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                                Habis Sementara
                            </span>
                        @endif
                    </div>

                    {{-- Quantity & Action Buttons --}}
                    <div class="mt-8 space-y-3">
                        @if ($product->stock > 0)
                            <div class="flex items-center gap-4">
                                {{-- Counter [ - ] qty [ + ] --}}
                                <div class="flex items-center border border-stone-300 rounded-full bg-white px-3 py-1.5">
                                    <button type="button" @click="qty > 1 ? qty-- : 1" class="text-stone-500 hover:text-[#2C3A3F] px-2 text-base font-medium">-</button>
                                    <span class="px-3 text-xs font-semibold text-[#2C3A3F]" x-text="qty">1</span>
                                    <button type="button" @click="qty < maxQty ? qty++ : qty" class="text-stone-500 hover:text-[#2C3A3F] px-2 text-base font-medium">+</button>
                                </div>

                                {{-- Tombol Tambah ke Keranjang --}}
                                <form method="POST" action="{{ route('cart.store') }}" class="flex-1 flex">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" :value="qty">
                                    <input type="hidden" name="variant" :value="selectedColor">
                                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full border border-[#2C3A3F] text-[#2C3A3F] text-xs sm:text-sm font-medium hover:bg-white transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                        <span>Tambah ke Keranjang</span>
                                    </button>
                                </form>
                            </div>

                            {{-- Tombol Beli Sekarang --}}
                            <form method="POST" action="{{ route('cart.store') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" :value="qty">
                                <input type="hidden" name="variant" :value="selectedColor">
                                <input type="hidden" name="buy_now" value="1">
                                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3.5 rounded-full bg-[#2C3A3F] text-white text-xs sm:text-sm font-medium hover:bg-black transition shadow-sm">
                                    Beli Sekarang
                                </button>
                            </form>
                        @else
                            <div class="p-4 rounded-2xl bg-stone-100 text-stone-600 text-center text-xs">
                                Maaf, stok produk ini sedang habis. Hubungi kami melalui halaman kontak untuk pre-order kustom.
                            </div>
                        @endif

                        {{-- Link ke Keranjang --}}
                        <div class="text-center pt-2">
                            <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-1.5 text-xs text-stone-500 hover:text-[#C07A65] transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                <span>Lihat Isi Keranjang Belanja</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 3. KOTAK 4 PILAR KEUNGGULAN --}}
                <div class="rounded-2xl border border-[#EBE5DC] bg-white/70 p-4 sm:p-5 mt-6">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center sm:text-left">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#879685] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            <div>
                                <p class="text-[11px] font-semibold text-[#2C3A3F]">Handmade</p>
                                <p class="text-[10px] text-stone-500">Dibuat dengan cinta</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#879685] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <div>
                                <p class="text-[11px] font-semibold text-[#2C3A3F]">Sustainable</p>
                                <p class="text-[10px] text-stone-500">Ramah lingkungan</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#879685] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            <div>
                                <p class="text-[11px] font-semibold text-[#2C3A3F]">Unique</p>
                                <p class="text-[10px] text-stone-500">Setiap produk unik</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#879685] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div>
                                <p class="text-[11px] font-semibold text-[#2C3A3F]">Local</p>
                                <p class="text-[10px] text-stone-500">Malang, Indonesia</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- 4. TABS INFORMASI --}}
        <div class="border-t border-[#EBE5DC] pt-10">
            {{-- Tab Buttons Header --}}
            <div class="flex items-center space-x-8 border-b border-[#EBE5DC] pb-4 mb-8 overflow-x-auto">
                <button type="button" @click="activeTab = 'deskripsi'" 
                        :class="activeTab === 'deskripsi' ? 'text-[#2C3A3F] font-semibold border-b-2 border-[#2C3A3F] pb-4 -mb-4' : 'text-stone-500 hover:text-[#2C3A3F] pb-4 -mb-4'"
                        class="text-xs sm:text-sm tracking-wide transition shrink-0">
                    Deskripsi
                </button>
                <button type="button" @click="activeTab = 'detail'" 
                        :class="activeTab === 'detail' ? 'text-[#2C3A3F] font-semibold border-b-2 border-[#2C3A3F] pb-4 -mb-4' : 'text-stone-500 hover:text-[#2C3A3F] pb-4 -mb-4'"
                        class="text-xs sm:text-sm tracking-wide transition shrink-0">
                    Detail Produk
                </button>
                <button type="button" @click="activeTab = 'perawatan'" 
                        :class="activeTab === 'perawatan' ? 'text-[#2C3A3F] font-semibold border-b-2 border-[#2C3A3F] pb-4 -mb-4' : 'text-stone-500 hover:text-[#2C3A3F] pb-4 -mb-4'"
                        class="text-xs sm:text-sm tracking-wide transition shrink-0">
                    Perawatan
                </button>
                <button type="button" @click="activeTab = 'ulasan'" 
                        :class="activeTab === 'ulasan' ? 'text-[#2C3A3F] font-semibold border-b-2 border-[#2C3A3F] pb-4 -mb-4' : 'text-stone-500 hover:text-[#2C3A3F] pb-4 -mb-4'"
                        class="text-xs sm:text-sm tracking-wide transition shrink-0">
                    Ulasan Pelanggan
                </button>
            </div>

            {{-- Tab Content: Deskripsi --}}
            <div x-show="activeTab === 'deskripsi'" class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                <div class="md:col-span-8 space-y-4">
                    <p class="text-stone-600 text-xs sm:text-sm leading-relaxed font-light">
                        {{ $product->description ?? 'Produk ini terbuat dari perca katun berkualitas pilihan yang dijahit dengan teliti oleh pengrajin lokal Malang. Setiap karya memiliki karakter motif dan kombinasi yang istimewa.' }}
                    </p>
                    <ul class="space-y-2 text-xs sm:text-sm text-stone-600 font-light pt-2">
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-stone-400"></span>
                            <span>Kategori: {{ $product->category }}</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-stone-400"></span>
                            <span>Material: Kain perca katun upcycled terpilih</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-stone-400"></span>
                            <span>Jahitan ganda rapi & kuat</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-stone-400"></span>
                            <span>Handmade with love ❤️</span>
                        </li>
                    </ul>
                </div>

                <div class="md:col-span-4">
                    <div class="aspect-[4/3] rounded-2xl overflow-hidden shadow-sm border border-[#EBE5DC]">
                        <img src="{{ $product->image_url ?? 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=600&q=80' }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            {{-- Tab Content: Detail Produk --}}
            <div x-show="activeTab === 'detail'" class="text-xs sm:text-sm text-stone-600 space-y-2">
                <p><strong>SKU / Kode:</strong> PCN-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Kategori:</strong> {{ $product->category }}</p>
                <p><strong>Asal Pembuatan:</strong> Malang, Jawa Timur, Indonesia</p>
                <p><strong>Stok Tersedia:</strong> {{ $product->stock }} unit</p>
            </div>

            {{-- Tab Content: Perawatan --}}
            <div x-show="activeTab === 'perawatan'" class="text-xs sm:text-sm text-stone-600 space-y-2">
                <p>• Cuci menggunakan tangan dengan air dingin atau suhu ruang dan detergen lembut.</p>
                <p>• Hindari pemutih pakaian (bleach) agar serat kain perca dan warnanya tidak pudar.</p>
                <p>• Jemur di tempat teduh tanpa terkena terik matahari langsung.</p>
                <p>• Setrika dengan suhu sedang (katun).</p>
            </div>

            {{-- Tab Content: Ulasan --}}
            <div x-show="activeTab === 'ulasan'" class="space-y-4">
                <div class="p-4 rounded-2xl bg-white border border-[#EBE5DC]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold text-xs text-[#2C3A3F]">Sarah M. (Melbourne, Australia)</span>
                        <span class="text-amber-500 text-xs">★★★★★</span>
                    </div>
                    <p class="text-xs text-stone-600">Jahitannya luar biasa rapi! Corak warnanya sangat cantik dan furing dalamnya tebal. Pengiriman sampai ke Australia sangat aman.</p>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-[#EBE5DC]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold text-xs text-[#2C3A3F]">Budi Santoso (Malang)</span>
                        <span class="text-amber-500 text-xs">★★★★★</span>
                    </div>
                    <p class="text-xs text-stone-600">Bangga produk lokal Malang kualitasnya sebagus ini. Bahannya halus dan kuat!</p>
                </div>
            </div>

        </div>

        {{-- 5. PRODUK TERKAIT --}}
        @if ($relatedProducts->isNotEmpty())
            <div class="mt-20 pt-12 border-t border-[#EBE5DC]">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-serif text-[#2C3A3F]">Produk Terkait</h2>
                    <a href="{{ url('/katalog?kategori=' . Str::slug($product->category)) }}" class="text-xs font-medium text-stone-500 hover:text-[#2C3A3F]">
                        Lihat Kategori Ini &rarr;
                    </a>
                </div>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    @foreach ($relatedProducts as $rel)
                        <div class="group flex flex-col">
                            <div class="relative aspect-square rounded-2xl overflow-hidden bg-stone-200">
                                <a href="{{ route('katalog.detail', $rel->id) }}" class="block w-full h-full">
                                    <img src="{{ $rel->image_url ?? 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=600&q=80' }}" 
                                         alt="{{ $rel->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                </a>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('katalog.detail', $rel->id) }}" class="text-xs sm:text-sm font-medium text-[#2C3A3F] hover:text-[#C07A65]">
                                    {{ $rel->name }}
                                </a>
                                <p class="text-xs text-stone-600 mt-0.5">
                                    Rp {{ number_format($rel->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
