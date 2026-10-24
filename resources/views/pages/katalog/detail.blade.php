@extends('main')

@section('title', 'Patchwork Tote Bag - Percanesia')

@section('content')
<div class="bg-[#FAF7F2] text-[#2C3A3F] min-h-screen py-8 sm:py-12" x-data="{ 
    activeImg: 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=900&q=80',
    qty: 1,
    activeTab: 'deskripsi',
    selectedColor: 'sage'
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- 1. BREADCRUMB --}}
        <nav class="text-xs text-stone-500 mb-8 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-[#2C3A3F]">Home</a>
            <span>/</span>
            <a href="{{ url('/katalog?kategori=tas') }}" class="hover:text-[#2C3A3F]">Tas</a>
            <span>/</span>
            <span class="text-[#2C3A3F] font-medium">Patchwork Tote Bag</span>
        </nav>

        {{-- 2. MAIN PRODUCT SECTION (2 KOLOM) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 mb-16">
            
            {{-- KOLOM KIRI: GALERI GAMBAR --}}
            <div class="lg:col-span-7 flex flex-col-reverse sm:flex-row gap-4">
                {{-- Thumbnails List (Vertikal di tablet/desktop) --}}
                <div class="flex sm:flex-col gap-3 shrink-0 overflow-x-auto sm:overflow-visible">
                    @php
                        $thumbnails = [
                            'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=900&q=80',
                            'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?auto=format&fit=crop&w=900&q=80',
                            'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=900&q=80',
                            'https://images.unsplash.com/photo-1544441893-675973e31985?auto=format&fit=crop&w=900&q=80',
                        ];
                    @endphp

                    @foreach ($thumbnails as $thumb)
                        <button type="button" 
                                @click="activeImg = '{{ $thumb }}'"
                                :class="activeImg === '{{ $thumb }}' ? 'border-[#2C3A3F] ring-1 ring-[#2C3A3F]' : 'border-[#EBE5DC] opacity-70 hover:opacity-100'"
                                class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl overflow-hidden border bg-white p-0.5 transition shrink-0">
                            <img src="{{ $thumb }}" alt="Thumbnail" class="w-full h-full object-cover rounded-lg">
                        </button>
                    @endforeach
                </div>

                {{-- Foto Utama Besar --}}
                <div class="relative flex-1 aspect-[4/4.5] rounded-3xl overflow-hidden bg-stone-200 shadow-sm border border-[#EBE5DC]">
                    <img :src="activeImg" alt="Patchwork Tote Bag" class="w-full h-full object-cover">
                    
                    {{-- Zoom Icon (Sesuai Mockup) --}}
                    <button class="absolute top-4 right-4 w-9 h-9 rounded-full bg-white/80 backdrop-blur-sm flex items-center justify-center text-stone-600 hover:text-[#2C3A3F] shadow-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- KOLOM KANAN: DETAIL & BELI --}}
            <div class="lg:col-span-5 flex flex-col justify-between space-y-6">
                <div>
                    {{-- Judul & Harga --}}
                    <h1 class="text-3xl sm:text-4xl font-serif text-[#2C3A3F] font-normal">
                        Patchwork Tote Bag
                    </h1>
                    <p class="text-2xl font-serif font-medium text-[#2C3A3F] mt-2">
                        Rp 185.000
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
                        <span class="text-xs text-stone-500">(56 Ulasan)</span>
                    </div>

                    {{-- Deskripsi Singkat --}}
                    <p class="text-stone-600 text-xs sm:text-sm leading-relaxed mt-4 font-light">
                        Tas tote cantik dari kain perca pilihan dengan desain patchwork yang unik. Cocok untuk aktivitas sehari-hari dan ramah lingkungan.
                    </p>

                    {{-- Pilihan Warna (Color Swatches) --}}
                    <div class="mt-6">
                        <p class="text-xs font-semibold text-[#2C3A3F] mb-2.5">Warna</p>
                        <div class="flex items-center gap-3">
                            <button @click="selectedColor = 'terracotta'" :class="selectedColor === 'terracotta' ? 'ring-2 ring-offset-2 ring-[#C07A65]' : ''" class="w-6 h-6 rounded-full bg-[#C07A65] transition"></button>
                            <button @click="selectedColor = 'sage'" :class="selectedColor === 'sage' ? 'ring-2 ring-offset-2 ring-[#879685]' : ''" class="w-6 h-6 rounded-full bg-[#879685] transition"></button>
                            <button @click="selectedColor = 'mustard'" :class="selectedColor === 'mustard' ? 'ring-2 ring-offset-2 ring-[#D4A373]' : ''" class="w-6 h-6 rounded-full bg-[#D4A373] transition"></button>
                            <button @click="selectedColor = 'indigo'" :class="selectedColor === 'indigo' ? 'ring-2 ring-offset-2 ring-[#4F6774]' : ''" class="w-6 h-6 rounded-full bg-[#4F6774] transition"></button>
                            <button @click="selectedColor = 'linen'" :class="selectedColor === 'linen' ? 'ring-2 ring-offset-2 ring-[#CCD5AE]' : ''" class="w-6 h-6 rounded-full bg-[#CCD5AE] transition"></button>
                        </div>
                    </div>

                    {{-- Status Stok --}}
                    <div class="mt-6 flex items-center gap-2 text-xs text-stone-600">
                        <span class="font-semibold text-[#2C3A3F]">Stok:</span>
                        <span class="inline-flex items-center gap-1 text-emerald-700 font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            Tersedia
                        </span>
                    </div>

                    {{-- Quantity & Action Buttons --}}
                    <div class="mt-8 space-y-3">
                        <div class="flex items-center gap-4">
                            {{-- Counter [ - ] 1 [ + ] --}}
                            <div class="flex items-center border border-stone-300 rounded-full bg-white px-3 py-1.5">
                                <button type="button" @click="qty > 1 ? qty-- : 1" class="text-stone-500 hover:text-[#2C3A3F] px-2 text-base font-medium">-</button>
                                <span class="px-3 text-xs font-semibold text-[#2C3A3F]" x-text="qty">1</span>
                                <button type="button" @click="qty++" class="text-stone-500 hover:text-[#2C3A3F] px-2 text-base font-medium">+</button>
                            </div>

                            {{-- Tombol Tambah ke Keranjang --}}
                            <a href="{{ url('/checkout') }}" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full border border-[#2C3A3F] text-[#2C3A3F] text-xs sm:text-sm font-medium hover:bg-white transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                <span>Tambah ke Keranjang</span>
                            </a>
                        </div>

                        {{-- Tombol Beli Sekarang --}}
                        <a href="{{ url('/checkout') }}" class="w-full inline-flex items-center justify-center px-6 py-3.5 rounded-full bg-[#2C3A3F] text-white text-xs sm:text-sm font-medium hover:bg-black transition shadow-sm">
                            Beli Sekarang
                        </a>

                        {{-- Wishlist Button Link --}}
                        <div class="text-center pt-1">
                            <button type="button" class="inline-flex items-center gap-1.5 text-xs text-stone-500 hover:text-[#C07A65] transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                <span>Tambah ke Wishlist</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- 3. KOTAK 4 PILAR KEUNGGULAN (DI DALAM DETAIL) --}}
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
                                <p class="text-[11px] font-semibold text-[#2C3A3F]">Local Product</p>
                                <p class="text-[10px] text-stone-500">Proudly Indonesia</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- 4. TABS INFORMASI (Deskripsi, Detail Produk, Perawatan, Ulasan) --}}
        <div class="border-t border-[#EBE5DC] pt-10">
            {{-- Tab Buttons Header --}}
            <div class="flex items-center space-x-8 border-b border-[#EBE5DC] pb-4 mb-8">
                <button type="button" @click="activeTab = 'deskripsi'" 
                        :class="activeTab === 'deskripsi' ? 'text-[#2C3A3F] font-semibold border-b-2 border-[#2C3A3F] pb-4 -mb-4' : 'text-stone-500 hover:text-[#2C3A3F] pb-4 -mb-4'"
                        class="text-xs sm:text-sm tracking-wide transition">
                    Deskripsi
                </button>
                <button type="button" @click="activeTab = 'detail'" 
                        :class="activeTab === 'detail' ? 'text-[#2C3A3F] font-semibold border-b-2 border-[#2C3A3F] pb-4 -mb-4' : 'text-stone-500 hover:text-[#2C3A3F] pb-4 -mb-4'"
                        class="text-xs sm:text-sm tracking-wide transition">
                    Detail Produk
                </button>
                <button type="button" @click="activeTab = 'perawatan'" 
                        :class="activeTab === 'perawatan' ? 'text-[#2C3A3F] font-semibold border-b-2 border-[#2C3A3F] pb-4 -mb-4' : 'text-stone-500 hover:text-[#2C3A3F] pb-4 -mb-4'"
                        class="text-xs sm:text-sm tracking-wide transition">
                    Perawatan
                </button>
                <button type="button" @click="activeTab = 'ulasan'" 
                        :class="activeTab === 'ulasan' ? 'text-[#2C3A3F] font-semibold border-b-2 border-[#2C3A3F] pb-4 -mb-4' : 'text-stone-500 hover:text-[#2C3A3F] pb-4 -mb-4'"
                        class="text-xs sm:text-sm tracking-wide transition">
                    Ulasan (56)
                </button>
            </div>

            {{-- Tab Content: Deskripsi --}}
            <div x-show="activeTab === 'deskripsi'" class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                <div class="md:col-span-8 space-y-4">
                    <p class="text-stone-600 text-xs sm:text-sm leading-relaxed font-light">
                        Patchwork Tote Bag terbuat dari kain perca berkualitas tinggi yang dipilih dengan teliti oleh pengrajin lokal. Setiap tas memiliki kombinasi warna dan motif yang berbeda, menjadikannya unik dan istimewa.
                    </p>
                    <ul class="space-y-2 text-xs sm:text-sm text-stone-600 font-light pt-2">
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-stone-400"></span>
                            <span>Material: Kain perca katun</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-stone-400"></span>
                            <span>Ukuran: 35cm x 30cm x 12cm</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-stone-400"></span>
                            <span>Tali bahu nyaman digunakan</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-stone-400"></span>
                            <span>Dengan inner pocket</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-stone-400"></span>
                            <span>Handmade with love ❤️</span>
                        </li>
                    </ul>
                </div>

                {{-- Foto Inner Pocket / Bagian Dalam Sesuai Mockup --}}
                <div class="md:col-span-4">
                    <div class="aspect-[4/3] rounded-2xl overflow-hidden shadow-sm border border-[#EBE5DC]">
                        <img src="https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=600&q=80" 
                             alt="Bag Interior" 
                             class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            {{-- Tab Content: Detail Produk --}}
            <div x-show="activeTab === 'detail'" class="text-xs sm:text-sm text-stone-600 space-y-2">
                <p><strong>Berat Produk:</strong> 350 gram</p>
                <p><strong>Asal Pembuatan:</strong> Malang, Jawa Timur, Indonesia</p>
                <p><strong>Kapasitas:</strong> Muat laptop hingga 13 inci, dompet, buku catatan, dan botol minum</p>
            </div>

            {{-- Tab Content: Perawatan --}}
            <div x-show="activeTab === 'perawatan'" class="text-xs sm:text-sm text-stone-600 space-y-2">
                <p>• Cuci menggunakan tangan dengan air dingin dan sabun lembut.</p>
                <p>• Hindari penggunaan pemutih kain agar warna perca tetap awet.</p>
                <p>• Keringkan di tempat teduh dan setrika dengan suhu sedang.</p>
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
            </div>

        </div>

    </div>
</div>
@endsection