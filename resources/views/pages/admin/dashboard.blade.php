<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Percanesia Studio</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDF8F9] text-[#5A4950] font-sans antialiased min-h-screen flex"
      x-data="{
          modalTambahProduk: false,
          modalUpdateStok: false,
          selectedProduct: { id: 1, name: 'Patchwork Tote Bag', stock: 3 },
          openQuickStockUpdate(name, stock) {
              this.selectedProduct.name = name;
              this.selectedProduct.stock = stock;
              this.modalUpdateStok = true;
          }
      }">

    {{-- ================= SIDEBAR ADMIN PINK / MAUVE ================= --}}
    <aside class="w-64 bg-white/95 backdrop-blur-md border-r border-[#FCE7EC] min-h-screen p-6 flex flex-col justify-between shrink-0">
        <div class="space-y-8">
            {{-- Logo --}}
            <div>
                <a href="{{ url('/') }}" class="text-2xl font-serif text-[#2D1F25] font-medium tracking-tight">
                    Percanesia
                </a>
                <span class="block text-[10px] uppercase font-mono tracking-widest text-[#B86B7F] mt-1 font-bold">
                    Admin Panel Studio
                </span>
            </div>

            {{-- Navigasi Menu --}}
            <nav class="space-y-2 text-xs font-medium">
                {{-- 1. Dashboard Ringkasan (Aktif) --}}
                <a href="{{ url('/admin/dashboard') }}" 
                   class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl bg-[#B86B7F] text-white shadow-sm shadow-[#B86B7F]/30 transition">
                    <i class="fa-solid fa-chart-pie w-4 text-center"></i>
                    <span>Ringkasan Dashboard</span>
                </a>

                {{-- 2. Pesanan Masuk --}}
                <a href="{{ url('/admin/pesanan') }}" 
                   class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-[#5A4950] hover:bg-[#FDF8F9] hover:text-[#2D1F25] transition">
                    <i class="fa-solid fa-bag-shopping w-4 text-center"></i>
                    <span>Pesanan Masuk</span>
                </a>

                {{-- 3. Kelola Produk & Stok --}}
                <a href="{{ url('/admin/produk') }}" 
                   class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-[#5A4950] hover:bg-[#FDF8F9] hover:text-[#2D1F25] transition">
                    <i class="fa-solid fa-boxes-stacked w-4 text-center"></i>
                    <span>Kelola Produk & Stok</span>
                </a>

                {{-- 4. Pesan Masuk Pelanggan --}}
                <a href="{{ url('/admin/pesan-masuk') }}" 
                   class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-[#5A4950] hover:bg-[#FDF8F9] hover:text-[#2D1F25] transition">
                    <i class="fa-solid fa-envelope w-4 text-center"></i>
                    <span>Pesan Masuk</span>
                </a>

                {{-- Link ke Web Depan --}}
                <a href="{{ url('/') }}" target="_blank" 
                   class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-[#5A4950] hover:bg-[#FDF8F9] hover:text-[#2D1F25] transition pt-3 border-t border-[#FCE7EC]">
                    <i class="fa-solid fa-arrow-up-right-from-square w-4 text-center"></i>
                    <span>Lihat Web Toko</span>
                </a>
            </nav>
        </div>

        {{-- Footer Profil Admin --}}
        <div class="pt-6 border-t border-[#FCE7EC] space-y-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl bg-[#FCE7EC] text-[#B86B7F] flex items-center justify-center font-bold text-xs">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-[#2D1F25]">Admin Percanesia</p>
                    <p class="text-[11px] text-[#5A4950]/70">Studio Malang</p>
                </div>
            </div>
            <a href="{{ url('/') }}" class="block text-center text-xs text-[#B86B7F] hover:text-red-600 transition py-1 font-medium">
                Keluar ke Beranda &rarr;
            </a>
        </div>
    </aside>

    {{-- ================= KONTEN UTAMA DASHBOARD ================= --}}
    <main class="flex-1 p-6 sm:p-10 overflow-y-auto">
        
        {{-- Header Topbar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-8 border-b border-[#FCE7EC] gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-serif text-[#2D1F25] font-normal">
                    Ringkasan Studio
                </h1>
                <p class="text-xs text-[#5A4950]/80 mt-1">Pantau performa penjualan kriya perca dan status stok terkini.</p>
            </div>

            <div class="flex items-center gap-3">
                <button type="button" @click="modalTambahProduk = true" 
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-[#B86B7F] text-white text-xs font-semibold hover:bg-[#2D1F25] transition shadow-sm">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Produk Baru</span>
                </button>
            </div>
        </div>

        <div class="space-y-8">
            <!-- 3 KARTU STATISTIK UTAMA -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1: Total Penjualan -->
                <div class="bg-white/90 backdrop-blur-md p-6 rounded-3xl border border-[#FCE7EC] shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-[#B86B7F] uppercase tracking-widest">Total Penjualan</p>
                        <h3 class="text-2xl font-bold text-[#2D1F25]">Rp 5.420.000</h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-[#FCE7EC]/60 flex items-center justify-center text-[#B86B7F] text-xl">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                </div>

                <!-- Card 2: Pesanan Baru -->
                <div class="bg-white/90 backdrop-blur-md p-6 rounded-3xl border border-[#FCE7EC] shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-[#B86B7F] uppercase tracking-widest">Pesanan Baru</p>
                        <h3 class="text-2xl font-bold text-[#2D1F25]">3 Pesanan</h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-[#FCE7EC]/60 flex items-center justify-center text-[#B86B7F] text-xl">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                </div>

                <!-- Card 3: Varian Katalog -->
                <div class="bg-white/90 backdrop-blur-md p-6 rounded-3xl border border-[#FCE7EC] shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-[#B86B7F] uppercase tracking-widest">Varian Katalog</p>
                        <h3 class="text-2xl font-bold text-[#2D1F25]">4 Produk</h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-[#FCE7EC]/60 flex items-center justify-center text-[#B86B7F] text-xl">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                </div>
            </div>

            <!-- BAGIAN BAWAH: CEK STOK & AKTIVITAS TERKINI -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Widget Cek Stok -->
                <div class="bg-white/90 backdrop-blur-md p-6 rounded-3xl border border-[#FCE7EC] shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-[#FCE7EC]/60 pb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-4 rounded-full bg-[#B86B7F]"></span>
                            <h4 class="font-semibold text-[#2D1F25] text-sm">Cek Stok Menipis</h4>
                        </div>
                        <span class="text-[10px] bg-red-100 text-red-600 px-2.5 py-1 rounded-full font-bold">Perlu Perhatian</span>
                    </div>

                    <div class="space-y-3">
                        {{-- Item 1 --}}
                        <div class="flex items-center justify-between p-3.5 rounded-2xl bg-[#FDF8F9] border border-[#FCE7EC]/80">
                            <div class="space-y-0.5">
                                <p class="text-xs font-semibold text-[#2D1F25]">Patchwork Tote Bag</p>
                                <p class="text-[10px] font-bold text-red-500 uppercase tracking-wide">Sisa: 3 unit</p>
                            </div>
                            <button @click="openQuickStockUpdate('Patchwork Tote Bag', 3)" 
                                    class="px-4 py-2 rounded-xl bg-[#B86B7F] text-white text-xs font-medium hover:bg-[#2D1F25] transition-all">
                                Update
                            </button>
                        </div>

                        {{-- Item 2 --}}
                        <div class="flex items-center justify-between p-3.5 rounded-2xl bg-[#FDF8F9] border border-[#FCE7EC]/80">
                            <div class="space-y-0.5">
                                <p class="text-xs font-semibold text-[#2D1F25]">Dompet Perca Lipat</p>
                                <p class="text-[10px] font-bold text-red-500 uppercase tracking-wide">Sisa: 2 unit</p>
                            </div>
                            <button @click="openQuickStockUpdate('Dompet Perca Lipat', 2)" 
                                    class="px-4 py-2 rounded-xl bg-[#B86B7F] text-white text-xs font-medium hover:bg-[#2D1F25] transition-all">
                                Update
                            </button>
                        </div>

                        {{-- Item 3 --}}
                        <div class="flex items-center justify-between p-3.5 rounded-2xl bg-[#FDF8F9] border border-[#FCE7EC]/80">
                            <div class="space-y-0.5">
                                <p class="text-xs font-semibold text-[#2D1F25]">Sarung Bantal Perca</p>
                                <p class="text-[10px] font-bold text-red-500 uppercase tracking-wide">Sisa: 1 unit</p>
                            </div>
                            <button @click="openQuickStockUpdate('Sarung Bantal Perca', 1)" 
                                    class="px-4 py-2 rounded-xl bg-[#B86B7F] text-white text-xs font-medium hover:bg-[#2D1F25] transition-all">
                                Update
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Widget Aktivitas Terkini -->
                <div class="bg-white/90 backdrop-blur-md p-6 rounded-3xl border border-[#FCE7EC] shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-[#FCE7EC]/60 pb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-4 rounded-full bg-[#B86B7F]"></span>
                            <h4 class="font-semibold text-[#2D1F25] text-sm">Aktivitas Terkini</h4>
                        </div>
                        <a href="{{ url('/admin/pesanan') }}" class="text-[10px] font-bold text-[#B86B7F] hover:text-[#2D1F25] uppercase tracking-wider">
                            Lihat Semua
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="text-[#B86B7F] border-b border-[#FCE7EC]/60">
                                    <th class="pb-3 font-semibold">Nomor Order</th>
                                    <th class="pb-3 font-semibold">Pelanggan</th>
                                    <th class="pb-3 font-semibold text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#FCE7EC]/50">
                                <tr>
                                    <td class="py-3.5 font-bold text-[#2D1F25]">#PCN-1201</td>
                                    <td class="py-3.5 text-[#5A4950]">Tania Syabandia</td>
                                    <td class="py-3.5 font-semibold text-[#2D1F25] text-right">Rp 200.000</td>
                                </tr>
                                <tr>
                                    <td class="py-3.5 font-bold text-[#2D1F25]">#PCN-1202</td>
                                    <td class="py-3.5 text-[#5A4950]">Sarah Miller</td>
                                    <td class="py-3.5 font-semibold text-[#2D1F25] text-right">Rp 695.000</td>
                                </tr>
                                <tr>
                                    <td class="py-3.5 font-bold text-[#2D1F25]">#PCN-1203</td>
                                    <td class="py-3.5 text-[#5A4950]">Budi Santoso</td>
                                    <td class="py-3.5 font-semibold text-[#2D1F25] text-right">Rp 145.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= MODAL TAMBAH PRODUK ================= --}}
        <div x-show="modalTambahProduk" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm" 
             style="display: none;">
            <div @click.away="modalTambahProduk = false" 
                 class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-[#FCE7EC] shadow-2xl space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-[#FCE7EC]">
                    <h3 class="text-lg font-serif font-bold text-[#2D1F25]">Tambah Produk Perca Baru</h3>
                    <button @click="modalTambahProduk = false" class="text-stone-400 hover:text-[#2D1F25] text-xl font-bold">&times;</button>
                </div>

                <form action="{{ url('/admin/produk/store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block text-[#5A4950] font-semibold mb-1">Nama Produk</label>
                        <input type="text" name="nama" required placeholder="Contoh: Arunika Patchwork Kimono"
                               class="w-full px-4 py-2.5 rounded-2xl border border-[#FCE7EC] text-[#2D1F25] focus:outline-none focus:ring-1 focus:ring-[#B86B7F] bg-[#FDF8F9]">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[#5A4950] font-semibold mb-1">Kategori</label>
                            <select name="kategori" class="w-full px-4 py-2.5 rounded-2xl border border-[#FCE7EC] text-[#2D1F25] bg-white">
                                <option value="Tas">Tas</option>
                                <option value="Dompet">Dompet</option>
                                <option value="Sarung Bantal">Sarung Bantal</option>
                                <option value="Selimut">Selimut</option>
                                <option value="Taplak">Taplak</option>
                                <option value="Aksesoris">Aksesoris</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[#5A4950] font-semibold mb-1">Harga (Rp)</label>
                            <input type="number" name="harga" required placeholder="185000"
                                   class="w-full px-4 py-2.5 rounded-2xl border border-[#FCE7EC] text-[#2D1F25] focus:outline-none focus:ring-1 focus:ring-[#B86B7F] bg-[#FDF8F9]">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[#5A4950] font-semibold mb-1">Jumlah Stok Unit</label>
                            <input type="number" name="stok" required placeholder="10"
                                   class="w-full px-4 py-2.5 rounded-2xl border border-[#FCE7EC] text-[#2D1F25] focus:outline-none focus:ring-1 focus:ring-[#B86B7F] bg-[#FDF8F9]">
                        </div>
                        <div>
                            <label class="block text-[#5A4950] font-semibold mb-1">Upload Foto</label>
                            <input type="file" name="foto" class="w-full text-stone-500 file:mr-2 file:py-1 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:bg-[#FCE7EC] file:text-[#B86B7F]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[#5A4950] font-semibold mb-1">Deskripsi & Perawatan Perca</label>
                        <textarea name="deskripsi" rows="3" placeholder="Bahan perca katun, teknik jahit halus, ukuran..."
                                  class="w-full px-4 py-2.5 rounded-2xl border border-[#FCE7EC] text-[#2D1F25] bg-[#FDF8F9]"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#FCE7EC]">
                        <button type="button" @click="modalTambahProduk = false" class="px-5 py-2.5 rounded-full border border-[#FCE7EC] text-[#5A4950] hover:bg-[#FDF8F9]">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-full bg-[#B86B7F] text-white font-semibold hover:bg-[#2D1F25] transition shadow-sm">Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= MODAL UPDATE STOK ================= --}}
        <div x-show="modalUpdateStok" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm" 
             style="display: none;">
            <div @click.away="modalUpdateStok = false" 
                 class="bg-white rounded-3xl p-6 sm:p-7 max-w-sm w-full border border-[#FCE7EC] shadow-2xl space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-[#FCE7EC]">
                    <h4 class="font-serif font-bold text-[#2D1F25] text-base">Update Stok Unit</h4>
                    <button @click="modalUpdateStok = false" class="text-stone-400 hover:text-[#2D1F25] text-xl font-bold">&times;</button>
                </div>

                <div class="space-y-3 text-xs">
                    <p class="text-[#5A4950]">Produk: <strong class="text-[#2D1F25]" x-text="selectedProduct.name"></strong></p>
                    <div>
                        <label class="block text-[#5A4950] font-semibold mb-1">Jumlah Stok Baru</label>
                        <input type="number" x-model="selectedProduct.stock" min="0"
                               class="w-full px-4 py-2.5 rounded-2xl border border-[#FCE7EC] text-[#2D1F25] focus:outline-none focus:ring-1 focus:ring-[#B86B7F] bg-[#FDF8F9]">
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2 border-t border-[#FCE7EC] text-xs">
                    <button type="button" @click="modalUpdateStok = false" class="px-4 py-2 rounded-xl border border-[#FCE7EC] text-[#5A4950]">Batal</button>
                    <button type="button" @click="modalUpdateStok = false; alert('Stok berhasil diupdate!')" class="px-5 py-2 rounded-xl bg-[#B86B7F] text-white font-medium hover:bg-[#2D1F25]">
                        Simpan
                    </button>
                </div>
            </div>
        </div>

    </main>
</body>
</html>