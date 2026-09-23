@extends('main')

@section('title', 'Hubungi Kami - Percanesia')

@section('content')
<div class="bg-[#FAF7F2] text-[#2C3A3F] min-h-screen py-8 sm:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- 1. BREADCRUMB --}}
        <nav class="text-xs text-stone-500 mb-8 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-[#2C3A3F]">Home</a>
            <span>/</span>
            <span class="text-[#2C3A3F] font-medium">Contact</span>
        </nav>

        {{-- 2. HEADER SECTION --}}
        <div class="max-w-3xl mb-12">
            <span class="text-xs uppercase tracking-widest font-semibold text-[#C07A65]">
                Terhubung dengan Percanesia
            </span>
            <h1 class="text-3xl sm:text-4xl font-serif font-normal text-[#2C3A3F] mt-2">
                Hubungi Kami & Kunjungi Studio Kami di Malang
            </h1>
            <p class="text-xs sm:text-sm text-stone-600 font-light mt-2 leading-relaxed">
                Punya pertanyaan seputar produk, ingin konsultasi pesanan kriya kustom, atau tertarik bekerja sama untuk pengiriman ekspor mancanegara? Tim kami siap menyambut Anda.
            </p>
        </div>

        {{-- Pesan Sukses Jika Form Terkirim --}}
        @if(session('success'))
            <div class="mb-8 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- 3. GRID 2 KOLOM (INFO KONTAK & FORMULIR) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start mb-20">
            
            {{-- KOLOM KIRI: INFORMASI STUDIO & MEDIA SOSIAL --}}
            <div class="lg:col-span-5 space-y-6">
                
                {{-- Card Studio Operasional Malang --}}
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#EBE5DC] shadow-sm space-y-5">
                    <h2 class="text-lg font-serif font-medium text-[#2C3A3F]">
                        Studio & Workshop
                    </h2>

                    <div class="space-y-4 text-xs">
                        {{-- Lokasi --}}
                        <div class="flex items-start gap-3.5">
                            <div class="w-8 h-8 rounded-full bg-[#FAF7F2] border border-[#EBE5DC] flex items-center justify-center shrink-0 text-[#C07A65]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-[#2C3A3F]">Alamat Workshop</p>
                                <p class="text-stone-600 mt-0.5 leading-relaxed font-light">
                                    Jl. Soekarno Hatta No. 123, Lowokwaru, Kota Malang, Jawa Timur 65145, Indonesia.
                                </p>
                            </div>
                        </div>

                        {{-- Jam Operasional --}}
                        <div class="flex items-start gap-3.5">
                            <div class="w-8 h-8 rounded-full bg-[#FAF7F2] border border-[#EBE5DC] flex items-center justify-center shrink-0 text-[#879685]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-[#2C3A3F]">Jam Operasional</p>
                                <p class="text-stone-600 mt-0.5 font-light">Senin – Sabtu: 08.00 – 17.00 WIB</p>
                                <p class="text-stone-400 text-[11px]">Minggu & Hari Libur Nasional: Tutup</p>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="flex items-start gap-3.5">
                            <div class="w-8 h-8 rounded-full bg-[#FAF7F2] border border-[#EBE5DC] flex items-center justify-center shrink-0 text-[#4F6774]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-[#2C3A3F]">Email Resmi</p>
                                <a href="mailto:hello@percanesia.com" class="text-stone-600 hover:text-[#2C3A3F] font-light">hello@percanesia.com</a>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Direct WhatsApp Admin --}}
                    <div class="pt-2 border-t border-[#EBE5DC]">
                        <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Percanesia,%20saya%20ingin%20bertanya%20seputar%20produk%20kain%20perca" 
                           target="_blank"
                           class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-full bg-[#7D8F7B] text-white text-xs font-medium hover:bg-[#6b7c69] transition shadow-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.668-.699c.974.53 1.776.814 2.792.815 3.179 0 5.767-2.587 5.768-5.766 0-3.18-2.586-5.767-5.768-5.767zm3.392 8.232c-.145.409-.838.775-1.164.821-.326.046-.732.067-2.34-.589-1.933-.787-3.148-2.776-3.245-2.906-.095-.129-.773-1.028-.773-1.959s.486-1.388.66-1.577c.174-.189.38-.236.506-.236.127 0 .253.002.364.007.119.006.278-.045.435.334.164.398.558 1.36.608 1.46.05.101.082.219.016.352-.066.133-.1.217-.198.333-.099.116-.208.26-.297.35-.099.099-.202.207-.087.404.115.197.513.847 1.101 1.371.758.675 1.397.884 1.594.982.197.098.312.083.428-.05.116-.133.498-.58.63-.78.132-.199.265-.166.446-.099.182.066 1.155.545 1.353.644.198.099.33.149.379.232.049.083.049.481-.096.89z"/></svg>
                            <span>Chat WhatsApp Admin (Fast Response)</span>
                        </a>
                    </div>
                </div>

                {{-- Social Media Box --}}
                <div class="bg-white rounded-3xl p-6 border border-[#EBE5DC] shadow-sm">
                    <h3 class="text-xs uppercase tracking-wider font-semibold text-stone-500 mb-3">Ikuti Cerita Keseharian Kami</h3>
                    <div class="flex items-center gap-3">
                        <a href="https://instagram.com" target="_blank" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-2xl bg-[#FAF7F2] border border-[#EBE5DC] text-xs font-medium text-[#2C3A3F] hover:bg-stone-100 transition">
                            <span>Instagram</span>
                        </a>
                        <a href="https://tiktok.com" target="_blank" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-2xl bg-[#FAF7F2] border border-[#EBE5DC] text-xs font-medium text-[#2C3A3F] hover:bg-stone-100 transition">
                            <span>TikTok</span>
                        </a>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN: FORMULIR KONTAK --}}
            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#EBE5DC] shadow-sm">
                    <h2 class="text-xl font-serif font-medium text-[#2C3A3F] mb-6">
                        Kirim Pesan
                    </h2>

                    <form action="{{ url('/contact/send') }}" method="POST" class="space-y-4 text-xs">
                        @csrf

                        <div>
                            <label class="block text-stone-600 font-medium mb-1.5">Nama Lengkap</label>
                            <input type="text" name="name" required placeholder="Contoh: Tania Syabandia"
                                   class="w-full px-4 py-3 rounded-xl border border-stone-300 text-stone-800 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F]">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-stone-600 font-medium mb-1.5">Email</label>
                                <input type="email" name="email" required placeholder="nama@email.com"
                                       class="w-full px-4 py-3 rounded-xl border border-stone-300 text-stone-800 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F]">
                            </div>
                            <div>
                                <label class="block text-stone-600 font-medium mb-1.5">No. WhatsApp</label>
                                <input type="tel" name="phone" placeholder="08xxxxxxxxxx"
                                       class="w-full px-4 py-3 rounded-xl border border-stone-300 text-stone-800 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F]">
                            </div>
                        </div>

                        <div>
                            <label class="block text-stone-600 font-medium mb-1.5">Kategori Pertanyaan / Subjek</label>
                            <select name="subject" class="w-full px-4 py-3 rounded-xl border border-stone-300 text-stone-800 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F] bg-white cursor-pointer">
                                <option value="Pertanyaan Produk">Pertanyaan Seputar Produk & Stok</option>
                                <option value="Custom Order">Pesanan Khusus / Custom Motif</option>
                                <option value="Kerjasama Ekspor">Pemesanan Grosir / Kerjasama Ekspor (B2B)</option>
                                <option value="Kunjungan Studio">Kunjungan Workshop di Malang</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-stone-600 font-medium mb-1.5">Pesan Anda</label>
                            <textarea name="message" rows="4" required placeholder="Tuliskan pesan atau detail kebutuhan Anda di sini..."
                                      class="w-full px-4 py-3 rounded-xl border border-stone-300 text-stone-800 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F]"></textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" 
                                    class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-[#C07A65] text-white text-xs sm:text-sm font-medium hover:bg-[#a96653] transition shadow-sm">
                                Kirim Pesan Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection