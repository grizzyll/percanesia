@extends('main')

@section('title', 'Checkout - Percanesia')

@section('content')
<div class="bg-[#FAF7F2] text-[#2C3A3F] min-h-screen py-8 sm:py-12" 
     x-data="{
        subtotal: 400000,
        shippingCost: 15000,
        shippingMethod: 'reguler',
        paymentMethod: 'bank_transfer',
        updateShipping(cost, method) {
            this.shippingCost = cost;
            this.shippingMethod = method;
        },
        getTotal() {
            return this.subtotal + this.shippingCost;
        },
        formatRupiah(num) {
            return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
     }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- 1. STEP WIZARD BAR (Sesuai Mockup) --}}
        <div class="flex items-center justify-start sm:justify-center gap-6 sm:gap-10 pb-8 mb-8 border-b border-[#EBE5DC] overflow-x-auto text-xs sm:text-sm font-medium tracking-wide">
            <span class="text-[#2C3A3F] font-bold border-b-2 border-[#2C3A3F] pb-2 shrink-0">1. Informasi</span>
            <span class="text-stone-500 pb-2 shrink-0">2. Pengiriman</span>
            <span class="text-stone-500 pb-2 shrink-0">3. Pembayaran</span>
            <span class="text-stone-500 pb-2 shrink-0">4. Ringkasan</span>
        </div>

        <form action="{{ url('/checkout/process') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start mb-16">
                
                {{-- KOLOM KIRI: FORMULIR DATA, PENGIRIMAN & PEMBAYARAN --}}
                <div class="lg:col-span-7 space-y-8">
                    
                    {{-- Section A: Informasi Pelanggan --}}
                    <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-[#EBE5DC] space-y-4">
                        <h2 class="text-base sm:text-lg font-serif font-medium text-[#2C3A3F]">
                            Informasi Pelanggan
                        </h2>

                        <div class="space-y-3 text-xs">
                            <div>
                                <label class="block text-stone-600 font-medium mb-1">Nama Lengkap</label>
                                <input type="text" name="nama" value="Tania Syabandia" required
                                       class="w-full px-4 py-2.5 rounded-xl border border-stone-300 text-stone-800 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F]">
                            </div>

                            <div>
                                <label class="block text-stone-600 font-medium mb-1">No. WhatsApp</label>
                                <input type="tel" name="whatsapp" value="081234567890" required
                                       class="w-full px-4 py-2.5 rounded-xl border border-stone-300 text-stone-800 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F]">
                            </div>

                            <div>
                                <label class="block text-stone-600 font-medium mb-1">Email</label>
                                <input type="email" name="email" value="tania.sy@example.com" required
                                       class="w-full px-4 py-2.5 rounded-xl border border-stone-300 text-stone-800 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F]">
                            </div>

                            <div class="flex items-center gap-2 pt-1">
                                <input type="checkbox" id="saveInfo" checked class="rounded border-stone-300 text-[#2C3A3F] focus:ring-0">
                                <label for="saveInfo" class="text-stone-500 cursor-pointer">Simpan informasi ini untuk pesanan berikutnya</label>
                            </div>
                        </div>
                    </div>

                    {{-- Section B: Alamat Pengiriman --}}
                    <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-[#EBE5DC] space-y-4">
                        <h2 class="text-base sm:text-lg font-serif font-medium text-[#2C3A3F]">
                            Alamat Pengiriman
                        </h2>

                        <div class="space-y-3 text-xs">
                            <div>
                                <label class="block text-stone-600 font-medium mb-1">Alamat Lengkap</label>
                                <textarea name="alamat" rows="2" required
                                          class="w-full px-4 py-2.5 rounded-xl border border-stone-300 text-stone-800 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F]">Jl. Soekarno Hatta No. 123, Malang, Jawa Timur, 65145</textarea>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-stone-600 font-medium mb-1">Kota / Kabupaten</label>
                                    <input type="text" name="kota" value="Malang" required
                                           class="w-full px-4 py-2.5 rounded-xl border border-stone-300 text-stone-800 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F]">
                                </div>
                                <div>
                                    <label class="block text-stone-600 font-medium mb-1">Kode Pos</label>
                                    <input type="text" name="kodepos" value="65145" required
                                           class="w-full px-4 py-2.5 rounded-xl border border-stone-300 text-stone-800 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F]">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section C: Metode Pengiriman --}}
                    <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-[#EBE5DC] space-y-4">
                        <h2 class="text-base sm:text-lg font-serif font-medium text-[#2C3A3F]">
                            Metode Pengiriman
                        </h2>

                        <div class="space-y-2.5 text-xs">
                            {{-- Reguler --}}
                            <label @click="updateShipping(15000, 'reguler')" 
                                   :class="shippingMethod === 'reguler' ? 'border-[#2C3A3F] bg-stone-50' : 'border-stone-200'"
                                   class="flex items-center justify-between p-3.5 rounded-2xl border cursor-pointer transition">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="shipping_method" value="reguler" :checked="shippingMethod === 'reguler'" class="text-[#2C3A3F] focus:ring-0">
                                    <div>
                                        <p class="font-medium text-[#2C3A3F]">Reguler (2-3 hari)</p>
                                        <p class="text-[11px] text-stone-500">JNE / J&T / SiCepat</p>
                                    </div>
                                </div>
                                <span class="font-semibold text-[#2C3A3F]">Rp 15.000</span>
                            </label>

                            {{-- Express --}}
                            <label @click="updateShipping(25000, 'express')" 
                                   :class="shippingMethod === 'express' ? 'border-[#2C3A3F] bg-stone-50' : 'border-stone-200'"
                                   class="flex items-center justify-between p-3.5 rounded-2xl border cursor-pointer transition">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="shipping_method" value="express" :checked="shippingMethod === 'express'" class="text-[#2C3A3F] focus:ring-0">
                                    <div>
                                        <p class="font-medium text-[#2C3A3F]">Express (1-2 hari)</p>
                                        <p class="text-[11px] text-stone-500">JNE YES / SiCepat BEST</p>
                                    </div>
                                </div>
                                <span class="font-semibold text-[#2C3A3F]">Rp 25.000</span>
                            </label>

                            {{-- Same Day Malang --}}
                            <label @click="updateShipping(35000, 'sameday')" 
                                   :class="shippingMethod === 'sameday' ? 'border-[#2C3A3F] bg-stone-50' : 'border-stone-200'"
                                   class="flex items-center justify-between p-3.5 rounded-2xl border cursor-pointer transition">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="shipping_method" value="sameday" :checked="shippingMethod === 'sameday'" class="text-[#2C3A3F] focus:ring-0">
                                    <div>
                                        <p class="font-medium text-[#2C3A3F]">Same Day (Area Malang)</p>
                                        <p class="text-[11px] text-stone-500">Kirim hari ini sampai</p>
                                    </div>
                                </div>
                                <span class="font-semibold text-[#2C3A3F]">Rp 35.000</span>
                            </label>
                        </div>
                    </div>

                    {{-- Section D: Metode Pembayaran --}}
                    <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-[#EBE5DC] space-y-4">
                        <h2 class="text-base sm:text-lg font-serif font-medium text-[#2C3A3F]">
                            Metode Pembayaran
                        </h2>

                        <div class="space-y-2.5 text-xs">
                            <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-stone-200 cursor-pointer hover:bg-stone-50 transition">
                                <input type="radio" name="payment_method" value="bank_transfer" checked class="text-[#2C3A3F] focus:ring-0">
                                <div>
                                    <p class="font-medium text-[#2C3A3F]">Transfer Bank</p>
                                    <p class="text-[11px] text-stone-500">BCA, Mandiri, BNI, BRI</p>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-stone-200 cursor-pointer hover:bg-stone-50 transition">
                                <input type="radio" name="payment_method" value="ewallet" class="text-[#2C3A3F] focus:ring-0">
                                <div>
                                    <p class="font-medium text-[#2C3A3F]">E-Wallet / QRIS (Midtrans / Xendit)</p>
                                    <p class="text-[11px] text-stone-500">GoPay, OVO, ShopeePay, QRIS instan</p>
                                </div>
                            </label>

                            <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-stone-200 cursor-pointer hover:bg-stone-50 transition">
                                <input type="radio" name="payment_method" value="cod" class="text-[#2C3A3F] focus:ring-0">
                                <div>
                                    <p class="font-medium text-[#2C3A3F]">COD (Bayar di Tempat)</p>
                                    <p class="text-[11px] text-stone-500">Bayar saat paket sampai ke rumah</p>
                                </div>
                            </label>
                        </div>
                    </div>

                </div>

                {{-- KOLOM KANAN: CARD RINGKASAN PESANAN --}}
                <div class="lg:col-span-5 sticky top-28">
                    <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-[#EBE5DC] space-y-5">
                        <h2 class="text-lg font-serif font-medium text-[#2C3A3F]">
                            Ringkasan Pesanan
                        </h2>

                        {{-- Daftar Item Singkat Sesuai Mockup --}}
                        <div class="divide-y divide-[#EBE5DC] text-xs">
                            
                            {{-- Item 1 --}}
                            <div class="py-3 flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden bg-stone-100 shrink-0 border border-[#EBE5DC]">
                                        <img src="https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=200&q=80" alt="Bag" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <p class="font-medium text-[#2C3A3F]">Patchwork Tote Bag</p>
                                        <p class="text-stone-500 text-[11px]">1 x Rp 185.000</p>
                                    </div>
                                </div>
                                <span class="font-medium text-[#2C3A3F]">Rp 185.000</span>
                            </div>

                            {{-- Item 2 --}}
                            <div class="py-3 flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden bg-stone-100 shrink-0 border border-[#EBE5DC]">
                                        <img src="https://images.unsplash.com/photo-1544441893-675973e31985?auto=format&fit=crop&w=200&q=80" alt="Dompet" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <p class="font-medium text-[#2C3A3F]">Dompet Perca</p>
                                        <p class="text-stone-500 text-[11px]">1 x Rp 65.000</p>
                                    </div>
                                </div>
                                <span class="font-medium text-[#2C3A3F]">Rp 65.000</span>
                            </div>

                            {{-- Item 3 --}}
                            <div class="py-3 flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden bg-stone-100 shrink-0 border border-[#EBE5DC]">
                                        <img src="https://images.unsplash.com/photo-1579656381226-5fc0f0100c3b?auto=format&fit=crop&w=200&q=80" alt="Sarung Bantal" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <p class="font-medium text-[#2C3A3F]">Sarung Bantal Perca</p>
                                        <p class="text-stone-500 text-[11px]">2 x Rp 75.000</p>
                                    </div>
                                </div>
                                <span class="font-medium text-[#2C3A3F]">Rp 150.000</span>
                            </div>

                        </div>

                        {{-- Perhitungan Biaya --}}
                        <div class="space-y-2.5 text-xs text-stone-600 border-t border-[#EBE5DC] pt-4">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span class="font-medium text-[#2C3A3F]" x-text="formatRupiah(subtotal)"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Ongkir</span>
                                <span class="font-medium text-[#2C3A3F]" x-text="formatRupiah(shippingCost)"></span>
                            </div>
                        </div>

                        {{-- Total Biaya Keseluruhan --}}
                        <div class="flex justify-between items-center text-sm font-semibold text-[#2C3A3F] border-t border-[#EBE5DC] pt-4">
                            <span>Total</span>
                            <span class="font-serif text-xl" x-text="formatRupiah(getTotal())"></span>
                        </div>

                        {{-- Tombol Buat Pesanan Sesuai Mockup Terracotta --}}
                        <div class="pt-2">
                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center px-6 py-3.5 rounded-full bg-[#C07A65] text-white text-xs sm:text-sm font-medium hover:bg-[#a96653] transition shadow-sm">
                                Buat Pesanan
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </form>

    </div>
</div>
@endsection