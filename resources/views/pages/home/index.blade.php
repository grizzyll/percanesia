@extends('main')

@section('title', 'Percanesia - Every Piece Tells a Story')

@section('content')
<div class="bg-[#FAF7F2] text-[#2C3A3F]">

    {{-- ================= 1. HERO SECTION ================= --}}
    <section class="pt-8 pb-12 lg:pt-14 lg:pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                {{-- Left Text --}}
                <div class="lg:col-span-6 space-y-5">
                    <span class="text-xs sm:text-sm font-semibold tracking-widest uppercase text-[#C07A65]">
                        Handmade with Heart
                    </span>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-serif text-[#2C3A3F] font-normal leading-[1.15]">
                        Every Piece <br>
                        Tells a Story
                    </h1>

                    <p class="text-stone-600 text-sm sm:text-base font-light max-w-md leading-relaxed">
                        Produk handmade dari kain perca pilihan, dibuat dengan cinta, untuk bumi yang lebih baik.
                    </p>

                    <div class="pt-2">
                        <a href="{{ url('/katalog') }}" 
                           class="inline-block px-8 py-3 rounded-full bg-[#C07A65] text-white text-sm font-medium hover:bg-[#a96653] transition shadow-sm">
                            Shop Now
                        </a>
                    </div>
                </div>

                {{-- Right Hero Image Card --}}
                <div class="lg:col-span-6 flex justify-center lg:justify-end">
                    <div class="w-full max-w-lg">
                        <div class="aspect-[4/3] rounded-[2.5rem] overflow-hidden shadow-sm bg-stone-200">
                            <img src="https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?auto=format&fit=crop&w=1000&q=80" 
                                 alt="Percanesia Patchwork Bag" 
                                 class="w-full h-full object-cover object-center">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ================= 2. KATEGORI FLOATING ROW ================= --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-10">
        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-sm border border-[#EBE5DC]">
            <div class="grid grid-cols-3 sm:grid-cols-6 gap-4 sm:gap-6 text-center">
                
                <a href="{{ url('/katalog?kategori=tas') }}" class="group flex flex-col items-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full overflow-hidden bg-stone-100 p-1 border border-stone-200 group-hover:border-[#2C3A3F] transition">
                        <img src="https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=200&q=80" alt="Tas" class="w-full h-full object-cover rounded-full">
                    </div>
                    <span class="mt-2.5 text-xs sm:text-sm font-medium text-stone-700">Tas</span>
                </a>

                <a href="{{ url('/katalog?kategori=dompet') }}" class="group flex flex-col items-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full overflow-hidden bg-stone-100 p-1 border border-stone-200 group-hover:border-[#2C3A3F] transition">
                        <img src="https://images.unsplash.com/photo-1544441893-675973e31985?auto=format&fit=crop&w=200&q=80" alt="Dompet" class="w-full h-full object-cover rounded-full">
                    </div>
                    <span class="mt-2.5 text-xs sm:text-sm font-medium text-stone-700">Dompet</span>
                </a>

                <a href="{{ url('/katalog?kategori=sarung-bantal') }}" class="group flex flex-col items-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full overflow-hidden bg-stone-100 p-1 border border-stone-200 group-hover:border-[#2C3A3F] transition">
                        <img src="https://images.unsplash.com/photo-1579656381226-5fc0f0100c3b?auto=format&fit=crop&w=200&q=80" alt="Sarung Bantal" class="w-full h-full object-cover rounded-full">
                    </div>
                    <span class="mt-2.5 text-xs sm:text-sm font-medium text-stone-700">Sarung Bantal</span>
                </a>

                <a href="{{ url('/katalog?kategori=selimut') }}" class="group flex flex-col items-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full overflow-hidden bg-stone-100 p-1 border border-stone-200 group-hover:border-[#2C3A3F] transition">
                        <img src="https://images.unsplash.com/photo-1584100936595-c0654b55a2e2?auto=format&fit=crop&w=200&q=80" alt="Selimut" class="w-full h-full object-cover rounded-full">
                    </div>
                    <span class="mt-2.5 text-xs sm:text-sm font-medium text-stone-700">Selimut</span>
                </a>

                <a href="{{ url('/katalog?kategori=taplak') }}" class="group flex flex-col items-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full overflow-hidden bg-stone-100 p-1 border border-stone-200 group-hover:border-[#2C3A3F] transition">
                        <img src="https://images.unsplash.com/photo-1605371924599-2d0365da1ae0?auto=format&fit=crop&w=200&q=80" alt="Taplak" class="w-full h-full object-cover rounded-full">
                    </div>
                    <span class="mt-2.5 text-xs sm:text-sm font-medium text-stone-700">Taplak</span>
                </a>

                <a href="{{ url('/katalog?kategori=aksesoris') }}" class="group flex flex-col items-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full overflow-hidden bg-stone-100 p-1 border border-stone-200 group-hover:border-[#2C3A3F] transition">
                        <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=200&q=80" alt="Aksesoris" class="w-full h-full object-cover rounded-full">
                    </div>
                    <span class="mt-2.5 text-xs sm:text-sm font-medium text-stone-700">Aksesoris</span>
                </a>

            </div>
        </div>
    </section>

    {{-- ================= 3. PRODUK PILIHAN ================= --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-14">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl sm:text-3xl font-serif text-[#2C3A3F] font-normal">
                Produk Pilihan
            </h2>
            <a href="{{ url('/katalog') }}" class="text-xs sm:text-sm font-medium text-stone-500 hover:text-[#2C3A3F] transition">
                Lihat Semua
            </a>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            
            {{-- Card 1 --}}
            <div class="group flex flex-col">
                <div class="relative aspect-square rounded-2xl overflow-hidden bg-stone-200">
                    <img src="https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=600&q=80" alt="Patchwork Tote Bag" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    <button type="button" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 flex items-center justify-center text-stone-600 hover:text-red-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                </div>
                <div class="mt-3">
                    <p class="text-xs sm:text-sm font-medium text-[#2C3A3F]">Patchwork Tote Bag</p>
                    <p class="text-xs sm:text-sm text-stone-600 mt-0.5">Rp 185.000</p>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="group flex flex-col">
                <div class="relative aspect-square rounded-2xl overflow-hidden bg-stone-200">
                    <img src="https://images.unsplash.com/photo-1579656381226-5fc0f0100c3b?auto=format&fit=crop&w=600&q=80" alt="Sarung Bantal Patchwork" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    <button type="button" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 flex items-center justify-center text-stone-600 hover:text-red-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                </div>
                <div class="mt-3">
                    <p class="text-xs sm:text-sm font-medium text-[#2C3A3F]">Sarung Bantal Patchwork</p>
                    <p class="text-xs sm:text-sm text-stone-600 mt-0.5">Rp 75.000</p>
                </div>
            </div>

            {{-- Card 3 --}}
            <div class="group flex flex-col">
                <div class="relative aspect-square rounded-2xl overflow-hidden bg-stone-200">
                    <img src="https://images.unsplash.com/photo-1544441893-675973e31985?auto=format&fit=crop&w=600&q=80" alt="Dompet Perca" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    <button type="button" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 flex items-center justify-center text-stone-600 hover:text-red-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                </div>
                <div class="mt-3">
                    <p class="text-xs sm:text-sm font-medium text-[#2C3A3F]">Dompet Perca</p>
                    <p class="text-xs sm:text-sm text-stone-600 mt-0.5">Rp 65.000</p>
                </div>
            </div>

            {{-- Card 4 --}}
            <div class="group flex flex-col">
                <div class="relative aspect-square rounded-2xl overflow-hidden bg-stone-200">
                    <img src="https://images.unsplash.com/photo-1584100936595-c0654b55a2e2?auto=format&fit=crop&w=600&q=80" alt="Selimut Perca" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    <button type="button" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 flex items-center justify-center text-stone-600 hover:text-red-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                </div>
                <div class="mt-3">
                    <p class="text-xs sm:text-sm font-medium text-[#2C3A3F]">Selimut Perca</p>
                    <p class="text-xs sm:text-sm text-stone-600 mt-0.5">Rp 240.000</p>
                </div>
            </div>

        </div>

        {{-- Dots Indicator --}}
        <div class="flex justify-center items-center gap-2 mt-8">
            <span class="w-2 h-2 rounded-full bg-[#2C3A3F]"></span>
            <span class="w-2 h-2 rounded-full bg-stone-300"></span>
            <span class="w-2 h-2 rounded-full bg-stone-300"></span>
        </div>
    </section>

    {{-- ================= 4. VALUE PILLARS (SAGE GREEN) ================= --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="bg-[#879685] text-white rounded-3xl py-7 px-6 sm:px-10 shadow-sm">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-left">
                
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full border border-white/40 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-semibold">Handmade</h4>
                        <p class="text-[11px] text-white/80">Dibuat dengan cinta</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full border border-white/40 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-semibold">Sustainable</h4>
                        <p class="text-[11px] text-white/80">Ramah lingkungan</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full border border-white/40 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-semibold">Unique</h4>
                        <p class="text-[11px] text-white/80">Setiap produk unik</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full border border-white/40 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-semibold">Local Product</h4>
                        <p class="text-[11px] text-white/80">Proudly Indonesia</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>
@endsection