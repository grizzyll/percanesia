@extends('main')

@section('title', 'Keranjang Belanja - Percanesia')

@section('content')
<div class="bg-[#FAF7F2] text-[#2C3A3F] min-h-screen py-8 sm:py-12" 
     x-data="{
        items: [
            { id: 1, name: 'Patchwork Tote Bag', variant: 'Sage Mix', price: 185000, qty: 1, img: 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=300&q=80' },
            { id: 2, name: 'Dompet Perca', variant: 'Peony Blush', price: 65000, qty: 1, img: 'https://images.unsplash.com/photo-1544441893-675973e31985?auto=format&fit=crop&w=300&q=80' },
            { id: 3, name: 'Sarung Bantal Perca', variant: 'Coastal Haze', price: 75000, qty: 2, img: 'https://images.unsplash.com/photo-1579656381226-5fc0f0100c3b?auto=format&fit=crop&w=300&q=80' }
        ],
        ongkir: 15000,
        removeItem(id) {
            this.items = this.items.filter(item => item.id !== id);
        },
        getSubtotal() {
            return this.items.reduce((total, item) => total + (item.price * item.qty), 0);
        },
        getTotal() {
            return this.items.length > 0 ? this.getSubtotal() + this.ongkir : 0;
        },
        formatRupiah(num) {
            return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
     }">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Judul Halaman Sesuai Mockup --}}
        <h1 class="text-2xl sm:text-3xl font-serif text-[#2C3A3F] font-normal mb-8">
            Keranjang Belanja
        </h1>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 mb-16 items-start">
            
            {{-- KOLOM KIRI: DAFTAR PRODUK DALAM KERANJANG --}}
            <div class="lg:col-span-8">
                <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-[#EBE5DC]">
                    
                    {{-- Header Tabel (Desktop) --}}
                    <div class="hidden sm:grid sm:grid-cols-12 text-xs font-semibold text-stone-500 uppercase tracking-wider pb-4 border-b border-[#EBE5DC]">
                        <div class="sm:col-span-6">Produk</div>
                        <div class="sm:col-span-2 text-center">Harga</div>
                        <div class="sm:col-span-2 text-center">Jumlah</div>
                        <div class="sm:col-span-2 text-right">Subtotal</div>
                    </div>

                    {{-- Loop Daftar Produk --}}
                    <div class="divide-y divide-[#EBE5DC]">
                        <template x-for="item in items" :key="item.id">
                            <div class="py-5 grid grid-cols-1 sm:grid-cols-12 gap-4 items-center">
                                
                                {{-- Info Produk & Foto --}}
                                <div class="sm:col-span-6 flex items-center gap-4">
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl overflow-hidden bg-stone-100 shrink-0 border border-[#EBE5DC]">
                                        <img :src="item.img" :alt="item.name" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-[#2C3A3F]" x-text="item.name"></h3>
                                        <p class="text-xs text-stone-500 mt-0.5">Warna: <span x-text="item.variant"></span></p>
                                    </div>
                                </div>

                                {{-- Harga Satuan --}}
                                <div class="sm:col-span-2 text-left sm:text-center text-xs sm:text-sm text-stone-600">
                                    <span class="sm:hidden font-medium text-stone-400">Harga: </span>
                                    <span x-text="formatRupiah(item.price)"></span>
                                </div>

                                {{-- Counter Jumlah [ - 1 + ] --}}
                                <div class="sm:col-span-2 flex items-center justify-start sm:justify-center">
                                    <div class="flex items-center border border-stone-300 rounded-full bg-stone-50 px-2 py-1">
                                        <button type="button" @click="item.qty > 1 ? item.qty-- : 1" class="text-stone-500 hover:text-[#2C3A3F] px-1.5 text-sm font-semibold">-</button>
                                        <span class="px-2 text-xs font-semibold text-[#2C3A3F]" x-text="item.qty"></span>
                                        <button type="button" @click="item.qty++" class="text-stone-500 hover:text-[#2C3A3F] px-1.5 text-sm font-semibold">+</button>
                                    </div>
                                </div>

                                {{-- Subtotal Item & Tombol Hapus --}}
                                <div class="sm:col-span-2 flex items-center justify-between sm:justify-end gap-3 text-xs sm:text-sm font-medium text-[#2C3A3F]">
                                    <span x-text="formatRupiah(item.price * item.qty)"></span>
                                    
                                    {{-- Trash Button --}}
                                    <button type="button" @click="removeItem(item.id)" class="text-stone-400 hover:text-red-500 transition" aria-label="Hapus Item">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>

                            </div>
                        </template>

                        {{-- Tampilan Jika Keranjang Kosong --}}
                        <div x-show="items.length === 0" class="py-12 text-center space-y-3">
                            <p class="text-sm text-stone-500">Keranjang belanja Anda masih kosong.</p>
                            <a href="{{ url('/katalog') }}" class="inline-block text-xs font-medium text-[#2C3A3F] underline">Mulai Belanja</a>
                        </div>
                    </div>

                    {{-- Tombol Lanjut Belanja --}}
                    <div class="pt-6 mt-4 border-t border-[#EBE5DC]">
                        <a href="{{ url('/katalog') }}" class="inline-flex items-center text-xs font-medium text-[#2C3A3F] px-5 py-2.5 rounded-full border border-stone-300 hover:bg-stone-50 transition">
                            &larr; Lanjut Belanja
                        </a>
                    </div>

                </div>
            </div>

            {{-- KOLOM KANAN: CARD RINGKASAN BELANJA --}}
            <div class="lg:col-span-4">
                <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-[#EBE5DC] space-y-4">
                    <h2 class="text-lg font-serif font-medium text-[#2C3A3F]">
                        Ringkasan Belanja
                    </h2>

                    <div class="space-y-3 text-xs sm:text-sm text-stone-600 border-b border-[#EBE5DC] pb-4">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-medium text-[#2C3A3F]" x-text="formatRupiah(getSubtotal())"></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Ongkir (Estimasi)</span>
                            <span class="font-medium text-[#2C3A3F]" x-text="items.length > 0 ? formatRupiah(ongkir) : 'Rp 0'"></span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center text-sm sm:text-base font-semibold text-[#2C3A3F] pt-1">
                        <span>Total</span>
                        <span class="font-serif text-lg" x-text="formatRupiah(getTotal())"></span>
                    </div>

                    {{-- Tombol Menuju Checkout --}}
                    <div class="pt-2">
                        <a href="{{ url('/checkout') }}" 
                           :class="items.length === 0 ? 'pointer-events-none opacity-50' : ''"
                           class="w-full inline-flex items-center justify-center px-6 py-3.5 rounded-full bg-[#7D8F7B] text-white text-xs sm:text-sm font-medium hover:bg-[#6b7c69] transition shadow-sm">
                            Checkout
                        </a>
                    </div>
                </div>
            </div>

        </div>

        {{-- 3 VALUE TRUST BADGES (Bawah Halaman Sesuai Mockup) --}}
        <div class="rounded-3xl border border-[#EBE5DC] bg-white/70 py-6 px-6 sm:px-10 mb-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center sm:text-left">
                
                {{-- Badge 1 --}}
                <div class="flex items-center justify-center sm:justify-start gap-4">
                    <div class="w-10 h-10 rounded-full border border-stone-300 flex items-center justify-center shrink-0 text-[#2C3A3F]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold text-[#2C3A3F]">Gratis Ongkir</h4>
                        <p class="text-[11px] text-stone-500">Min. belanja Rp150.000</p>
                    </div>
                </div>

                {{-- Badge 2 --}}
                <div class="flex items-center justify-center sm:justify-start gap-4">
                    <div class="w-10 h-10 rounded-full border border-stone-300 flex items-center justify-center shrink-0 text-[#2C3A3F]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold text-[#2C3A3F]">Pembayaran Aman</h4>
                        <p class="text-[11px] text-stone-500">100% secure payment</p>
                    </div>
                </div>

                {{-- Badge 3 --}}
                <div class="flex items-center justify-center sm:justify-start gap-4">
                    <div class="w-10 h-10 rounded-full border border-stone-300 flex items-center justify-center shrink-0 text-[#2C3A3F]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-semibold text-[#2C3A3F]">Garansi Produk</h4>
                        <p class="text-[11px] text-stone-500">7 hari ganti baru</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection