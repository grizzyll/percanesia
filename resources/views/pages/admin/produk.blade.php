<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk & Stok - Percanesia Studio</title>

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
          selectedProduct: { id: null, name: '', stock: 0 },
          filterKategori: 'semua',
          searchQuery: '',
          products: [
              { id: 1, name: 'Patchwork Tote Bag', category: 'Tas', price: 185000, stock: 3, status: 'Tersedia', img: 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=200&q=80' },
              { id: 2, name: 'Dompet Perca Lipat', category: 'Dompet', price: 75000, stock: 2, status: 'Tersedia', img: 'https://images.unsplash.com/photo-1544441893-675973e31985?auto=format&fit=crop&w=200&q=80' },
              { id: 3, name: 'Sarung Bantal Perca', category: 'Sarung Bantal', price: 75000, stock: 1, status: 'Menipis', img: 'https://images.unsplash.com/photo-1579656381226-5fc0f0100c3b?auto=format&fit=crop&w=200&q=80' },
              { id: 4, name: 'Selimut Perca Vintage', category: 'Selimut', price: 240000, stock: 5, status: 'Tersedia', img: 'https://images.unsplash.com/photo-1584100936595-c0654b55a2e2?auto=format&fit=crop&w=200&q=80' },
              { id: 5, name: 'Taplak Meja Perca', category: 'Taplak', price: 120000, stock: 0, status: 'Habis', img: 'https://images.unsplash.com/photo-1605371924599-2d0365da1ae0?auto=format&fit=crop&w=200&q=80' },
              { id: 6, name: 'Bucket Bag Perca', category: 'Tas', price: 175000, stock: 7, status: 'Tersedia', img: 'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?auto=format&fit=crop&w=200&q=80' }
          ],
          formatRupiah(num) {
              return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
          },
          get filteredProducts() {
              return this.products.filter(p => {
                  let matchCat = this.filterKategori === 'semua' || p.category.toLowerCase() === this.filterKategori.toLowerCase();
                  let matchSearch = p.name.toLowerCase().includes(this.searchQuery.toLowerCase());
                  return matchCat && matchSearch;
              });
          },
          openQuickStockUpdate(product) {
              this.selectedProduct = Object.assign({}, product);
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
                {{-- 1. Dashboard Ringkasan --}}
                <a href="{{ url('/admin/dashboard') }}" 
                   class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-[#5A4950] hover:bg-[#FDF8F9] hover:text-[#2D1F25] transition">
                    <i class="fa-solid fa-chart-pie w-4 text-center"></i>
                    <span>Ringkasan Dashboard</span>
                </a>

                {{-- 2. Pesanan Masuk --}}
                <a href="{{ url('/admin/pesanan') }}" 
                   class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-[#5A4950] hover:bg-[#FDF8F9] hover:text-[#2D1F25] transition">
                    <i class="fa-solid fa-bag-shopping w-4 text-center"></i>
                    <span>Pesanan Masuk</span>
                </a>

                {{-- 3. Kelola Produk & Stok (AKTIF) --}}
                <a href="{{ url('/admin/produk') }}" 
                   class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl bg-[#B86B7F] text-white shadow-sm shadow-[#B86B7F]/30 transition">
                    <i class="fa-solid fa-boxes-stacked w-4 text-center"></i>
                    <span>Kelola Produk & Stok</span>
                </a>

                {{-- 4. Pesan Masuk Pelanggan --}}
                <a href="{{ url('/admin/pesan-masuk') }}" 
                   class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-[#5A4950] hover:bg-[#FDF8F9] hover:text-[#2D1F25] transition">
                    <i class="fa-solid fa-envelope w-4 text-center"></i>
                    <span>Pesan Masuk</span>
                </a>

                {{-- Link ke Toko Depan --}}
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

    {{-- ================= KONTEN KELOLA PRODUK ================= --}}
    <main class="flex-1 p-6 sm:p-10 overflow-y-auto">
        
        {{-- Header Topbar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-8 border-b border-[#FCE7EC] gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-serif text-[#2D1F25] font-normal">
                    Kelola Produk & Stok
                </h1>
                <p class="text-xs text-[#5A4950]/80 mt-1">Daftar seluruh karya kriya perca yang aktif dan siap dibeli oleh pelanggan di katalog.</p>
            </div>

            <div class="flex items-center gap-3">
                <button type="button" @click="modalTambahProduk = true" 
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-[#B86B7F] text-white text-xs font-semibold hover:bg-[#2D1F25] transition shadow-sm">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Produk Baru</span>
                </button>
            </div>
        </div>

        {{-- Filter & Search Toolbar --}}
        <div class="bg-white/90 backdrop-blur-md p-5 rounded-3xl border border-[#FCE7EC] shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            
            {{-- Kategori Filter Pills --}}
            <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 text-xs">
                <button type="button" @click="filterKategori = 'semua'" 
                        :class="filterKategori === 'semua' ? 'bg-[#B86B7F] text-white' : 'bg-[#FDF8F9] text-[#5A4950] hover:bg-[#FCE7EC]'"
                        class="px-4 py-2 rounded-2xl font-medium transition shrink-0">
                    Semua Kategori
                </button>
                <button type="button" @click="filterKategori = 'tas'" 
                        :class="filterKategori === 'tas' ? 'bg-[#B86B7F] text-white' : 'bg-[#FDF8F9] text-[#5A4950] hover:bg-[#FCE7EC]'"
                        class="px-4 py-2 rounded-2xl font-medium transition shrink-0">
                    Tas
                </button>
                <button type="button" @click="filterKategori = 'dompet'" 
                        :class="filterKategori === 'dompet' ? 'bg-[#B86B7F] text-white' : 'bg-[#FDF8F9] text-[#5A4950] hover:bg-[#FCE7EC]'"
                        class="px-4 py-2 rounded-2xl font-medium transition shrink-0">
                    Dompet
                </button>
                <button type="button" @click="filterKategori = 'sarung bantal'" 
                        :class="filterKategori === 'sarung bantal' ? 'bg-[#B86B7F] text-white' : 'bg-[#FDF8F9] text-[#5A4950] hover:bg-[#FCE7EC]'"
                        class="px-4 py-2 rounded-2xl font-medium transition shrink-0">
                    Sarung Bantal
                </button>
                <button type="button" @click="filterKategori = 'selimut'" 
                        :class="filterKategori === 'selimut' ? 'bg-[#B86B7F] text-white' : 'bg-[#FDF8F9] text-[#5A4950] hover:bg-[#FCE7EC]'"
                        class="px-4 py-2 rounded-2xl font-medium transition shrink-0">
                    Selimut
                </button>
                <button type="button" @click="filterKategori = 'taplak'" 
                        :class="filterKategori === 'taplak' ? 'bg-[#B86B7F] text-white' : 'bg-[#FDF8F9] text-[#5A4950] hover:bg-[#FCE7EC]'"
                        class="px-4 py-2 rounded-2xl font-medium transition shrink-0">
                    Taplak
                </button>
            </div>

            {{-- Kolom Pencarian Cepat --}}
            <div class="relative w-full md:w-64">
                <input type="text" x-model="searchQuery" placeholder="Cari nama produk..." 
                       class="w-full pl-9 pr-4 py-2 rounded-2xl border border-[#FCE7EC] text-xs text-[#2D1F25] focus:outline-none focus:ring-1 focus:ring-[#B86B7F] bg-[#FDF8F9]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-stone-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
            </div>

        </div>

        {{-- Tabel Daftar Lengkap Produk --}}
        <div class="bg-white/90 backdrop-blur-md p-6 rounded-3xl border border-[#FCE7EC] shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-[#FCE7EC]/60">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-4 rounded-full bg-[#B86B7F]"></span>
                    <h3 class="font-serif text-lg font-medium text-[#2D1F25]">Katalog Produk Percanesia</h3>
                </div>
                <span class="text-xs font-bold text-[#B86B7F]" x-text="filteredProducts.length + ' Produk Ditampilkan'"></span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-[#5A4950]">
                    <thead class="text-[#B86B7F] uppercase text-[10px] font-bold tracking-wider border-b border-[#FCE7EC]/60">
                        <tr>
                            <th class="pb-3 font-semibold">Foto & Nama Produk</th>
                            <th class="pb-3 font-semibold">Kategori</th>
                            <th class="pb-3 font-semibold">Harga</th>
                            <th class="pb-3 font-semibold">Sisa Stok</th>
                            <th class="pb-3 font-semibold">Status</th>
                            <th class="pb-3 font-semibold text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#FCE7EC]/50">
                        <template x-for="p in filteredProducts" :key="p.id">
                            <tr class="hover:bg-[#FDF8F9]/60 transition">
                                {{-- Foto & Nama --}}
                                <td class="py-4">
                                    <div class="flex items-center gap-3">
                                        <img :src="p.img" :alt="p.name" class="w-12 h-12 rounded-2xl object-cover border border-[#FCE7EC] shrink-0">
                                        <div>
                                            <p class="font-bold text-[#2D1F25] text-sm" x-text="p.name"></p>
                                            <p class="text-[10px] text-stone-400">100% Upcycled Cotton</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kategori --}}
                                <td class="py-4">
                                    <span class="px-3 py-1 rounded-full bg-[#FDF8F9] border border-[#FCE7EC] text-[11px] font-medium text-[#2D1F25]" x-text="p.category"></span>
                                </td>

                                {{-- Harga --}}
                                <td class="py-4 font-bold text-[#2D1F25]" x-text="formatRupiah(p.price)"></td>

                                {{-- Sisa Stok --}}
                                <td class="py-4 font-semibold">
                                    <div class="flex items-center gap-2">
                                        <span x-text="p.stock + ' unit'"></span>
                                        <template x-if="p.stock <= 2 && p.stock > 0">
                                            <span class="text-[9px] bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-bold">Menipis</span>
                                        </template>
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td class="py-4">
                                    <span :class="p.stock > 0 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-stone-100 text-stone-500 border-stone-200'"
                                          class="px-2.5 py-1 rounded-full text-[10px] font-bold border" 
                                          x-text="p.stock > 0 ? 'Tersedia' : 'Habis'"></span>
                                </td>

                                {{-- Aksi --}}
                                <td class="py-4 text-right space-x-2">
                                    <button type="button" @click="openQuickStockUpdate(p)" 
                                            class="px-3 py-1.5 rounded-xl bg-[#FCE7EC] text-[#B86B7F] hover:bg-[#B86B7F] hover:text-white font-medium transition">
                                        Update Stok
                                    </button>
                                    <button type="button" @click="if(confirm('Hapus produk ' + p.name + '?')) products = products.filter(item => item.id !== p.id)" 
                                            class="p-1.5 text-stone-400 hover:text-red-500 transition" title="Hapus Produk">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
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
                    <button type="button" @click="
                        let p = products.find(item => item.id === selectedProduct.id);
                        if (p) p.stock = selectedProduct.stock;
                        modalUpdateStok = false;
                    " class="px-5 py-2 rounded-xl bg-[#B86B7F] text-white font-medium hover:bg-[#2D1F25]">
                        Simpan
                    </button>
                </div>
            </div>
        </div>

    </main>
</body>
</html>