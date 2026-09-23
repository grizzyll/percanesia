<footer class="bg-[#4F6774] text-white pt-14 pb-10 w-full block">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- Col 1: Brand & Slogan -->
            <div class="md:col-span-5 space-y-4">
                <h3 class="text-2xl font-serif tracking-tight text-white font-normal">Percanesia</h3>
                <p class="text-white/80 text-xs sm:text-sm font-light leading-relaxed max-w-sm">
                    Made from leftover fabrics, <br>
                    Made for a better tomorrow.
                </p>
                <div class="flex items-center space-x-3 pt-2 text-white">
                    <a href="https://instagram.com" target="_blank" class="w-8 h-8 rounded-full border border-white/40 flex items-center justify-center hover:bg-white hover:text-[#4F6774] transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.441-.645 1.441-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Col 2: Shop Links -->
            <div class="md:col-span-2 space-y-3">
                <h4 class="text-xs font-semibold uppercase tracking-wider text-white">Shop</h4>
                <ul class="space-y-2 text-xs text-white/70">
                    <li><a href="{{ url('/katalog') }}" class="hover:text-white">Semua Produk</a></li>
                    <li><a href="{{ url('/katalog?kategori=tas') }}" class="hover:text-white">Tas</a></li>
                    <li><a href="{{ url('/katalog?kategori=dompet') }}" class="hover:text-white">Dompet</a></li>
                    <li><a href="{{ url('/katalog?kategori=sarung-bantal') }}" class="hover:text-white">Sarung Bantal</a></li>
                    <li><a href="{{ url('/katalog?kategori=selimut') }}" class="hover:text-white">Selimut</a></li>
                    <li><a href="{{ url('/katalog?kategori=taplak') }}" class="hover:text-white">Taplak</a></li>
                    <li><a href="{{ url('/katalog?kategori=aksesoris') }}" class="hover:text-white">Aksesoris</a></li>
                </ul>
            </div>

            <!-- Col 3: Information -->
            <div class="md:col-span-2 space-y-3">
                <h4 class="text-xs font-semibold uppercase tracking-wider text-white">Information</h4>
                <ul class="space-y-2 text-xs text-white/70">
                    <li><a href="{{ url('/about') }}" class="hover:text-white">About Us</a></li>
                    <li><a href="#" class="hover:text-white">Care Guide</a></li>
                    <li><a href="#" class="hover:text-white">Pengiriman</a></li>
                    <li><a href="#" class="hover:text-white">Pembayaran</a></li>
                    <li><a href="#" class="hover:text-white">FAQ</a></li>
                </ul>
            </div>

            <!-- Col 4: Customer Service -->
            <div class="md:col-span-3 space-y-3">
                <h4 class="text-xs font-semibold uppercase tracking-wider text-white">Customer Service</h4>
                <ul class="space-y-2 text-xs text-white/70">
                    <li><a href="https://wa.me/6281234567890" target="_blank" class="hover:text-white">WhatsApp</a></li>
                    <li><a href="https://instagram.com" target="_blank" class="hover:text-white">Instagram</a></li>
                    <li><a href="mailto:hello@percanesia.com" class="hover:text-white">Email</a></li>
                    <li><span class="text-white/90">Location: Malang, Jawa Timur</span></li>
                </ul>
            </div>

        </div>

        <div class="mt-12 pt-6 border-t border-white/10 text-center text-[11px] text-white/50">
            &copy; {{ date('Y') }} Percanesia. All rights reserved. Handcrafted with love in Malang.
        </div>
    </div>
</footer>