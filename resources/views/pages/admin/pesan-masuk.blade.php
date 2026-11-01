<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Masuk - Percanesia Studio</title>

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
          categoryFilter: 'semua',
          searchQuery: '',
          modalDetailPesan: false,
          selectedMessage: { id: 1, name: '', email: '', phone: '', subject: '', message: '', date: '', is_read: false },
          messages: [
              { id: 1, name: 'Clara Dubois', email: 'clara.dubois@paris-boutique.fr', phone: '+33 6 12 34 56 78', subject: 'Kerjasama Ekspor', message: 'Halo Percanesia, kami butik interior di Paris tertarik untuk memesan 50 unit sarung bantal perca dan 20 quilt dengan motif earth-tone. Apakah ada katalog grosir ekspor dan perkiraan lead time pembuatannya?', date: '18 Okt 2025', is_read: false },
              { id: 2, name: 'Dewi Lestari', email: 'dewi.lestari@gmail.com', phone: '081298765432', subject: 'Custom Order', message: 'Selamat siang, apakah saya bisa memesan selimut perca ukuran king size dengan request dominan warna terracotta dan indigo? Terima kasih.', date: '17 Okt 2025', is_read: true },
              { id: 3, name: 'Bambang Pamungkas', email: 'bambang.p@yahoo.com', phone: '085733445566', subject: 'Pertanyaan Produk', message: 'Apakah Patchwork Tote Bag bagian dalamnya ada kantong resleting untuk tempat hp dan kunci?', date: '16 Okt 2025', is_read: true }
          ],
          get filteredMessages() {
              return this.messages.filter(m => {
                  let matchCat = this.categoryFilter === 'semua' || 
                                 (this.categoryFilter === 'unread' && !m.is_read) || 
                                 m.subject.toLowerCase().includes(this.categoryFilter.toLowerCase());
                  let matchSearch = m.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                    m.message.toLowerCase().includes(this.searchQuery.toLowerCase());
                  return matchCat && matchSearch;
              });
          },
          openMessage(msg) {
              msg.is_read = true;
              this.selectedMessage = Object.assign({}, msg);
              this.modalDetailPesan = true;
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

                {{-- 3. Kelola Produk & Stok --}}
                <a href="{{ url('/admin/produk') }}" 
                   class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-[#5A4950] hover:bg-[#FDF8F9] hover:text-[#2D1F25] transition">
                    <i class="fa-solid fa-boxes-stacked w-4 text-center"></i>
                    <span>Kelola Produk & Stok</span>
                </a>

                {{-- 4. Pesan Masuk Pelanggan (AKTIF) --}}
                <a href="{{ url('/admin/pesan-masuk') }}" 
                   class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl bg-[#B86B7F] text-white shadow-sm shadow-[#B86B7F]/30 transition">
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

    {{-- ================= KONTEN PESAN MASUK ================= --}}
    <main class="flex-1 p-6 sm:p-10 overflow-y-auto">
        
        {{-- Header Topbar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-8 border-b border-[#FCE7EC] gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-serif text-[#2D1F25] font-normal">
                    Kotak Pesan Masuk
                </h1>
                <p class="text-xs text-[#5A4950]/80 mt-1">Pesan pertanyaan produk, konsultasi kustom, dan penawaran ekspor B2B dari pelanggan.</p>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-[#B86B7F]" x-text="messages.filter(m => !m.is_read).length + ' Pesan Belum Dibaca'"></span>
            </div>
        </div>

        {{-- Filter & Search Toolbar --}}
        <div class="bg-white/90 backdrop-blur-md p-5 rounded-3xl border border-[#FCE7EC] shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            
            {{-- Filter Pills --}}
            <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 text-xs">
                <button type="button" @click="categoryFilter = 'semua'" 
                        :class="categoryFilter === 'semua' ? 'bg-[#B86B7F] text-white' : 'bg-[#FDF8F9] text-[#5A4950] hover:bg-[#FCE7EC]'"
                        class="px-4 py-2 rounded-2xl font-medium transition shrink-0">
                    Semua Pesan
                </button>
                <button type="button" @click="categoryFilter = 'unread'" 
                        :class="categoryFilter === 'unread' ? 'bg-[#B86B7F] text-white' : 'bg-[#FDF8F9] text-[#5A4950] hover:bg-[#FCE7EC]'"
                        class="px-4 py-2 rounded-2xl font-medium transition shrink-0">
                    Belum Dibaca
                </button>
                <button type="button" @click="categoryFilter = 'ekspor'" 
                        :class="categoryFilter === 'ekspor' ? 'bg-[#B86B7F] text-white' : 'bg-[#FDF8F9] text-[#5A4950] hover:bg-[#FCE7EC]'"
                        class="px-4 py-2 rounded-2xl font-medium transition shrink-0">
                    Kerjasama Ekspor
                </button>
                <button type="button" @click="categoryFilter = 'custom'" 
                        :class="categoryFilter === 'custom' ? 'bg-[#B86B7F] text-white' : 'bg-[#FDF8F9] text-[#5A4950] hover:bg-[#FCE7EC]'"
                        class="px-4 py-2 rounded-2xl font-medium transition shrink-0">
                    Custom Order
                </button>
            </div>

            {{-- Kolom Cari --}}
            <div class="relative w-full md:w-64">
                <input type="text" x-model="searchQuery" placeholder="Cari pengirim / isi pesan..." 
                       class="w-full pl-9 pr-4 py-2 rounded-2xl border border-[#FCE7EC] text-xs text-[#2D1F25] focus:outline-none focus:ring-1 focus:ring-[#B86B7F] bg-[#FDF8F9]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-stone-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
            </div>

        </div>

        {{-- Tabel Daftar Pesan Masuk --}}
        <div class="bg-white/90 backdrop-blur-md p-6 rounded-3xl border border-[#FCE7EC] shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-[#FCE7EC]/60">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-4 rounded-full bg-[#B86B7F]"></span>
                    <h3 class="font-serif text-lg font-medium text-[#2D1F25]">Daftar Pesan Masuk</h3>
                </div>
                <span class="text-xs font-bold text-[#B86B7F]" x-text="filteredMessages.length + ' Pesan'"></span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-[#5A4950]">
                    <thead class="text-[#B86B7F] uppercase text-[10px] font-bold tracking-wider border-b border-[#FCE7EC]/60">
                        <tr>
                            <th class="pb-3 font-semibold">Pengirim</th>
                            <th class="pb-3 font-semibold">Kategori / Subjek</th>
                            <th class="pb-3 font-semibold">Ringkasan Pesan</th>
                            <th class="pb-3 font-semibold">Tanggal</th>
                            <th class="pb-3 font-semibold">Status</th>
                            <th class="pb-3 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#FCE7EC]/50">
                        <template x-for="m in filteredMessages" :key="m.id">
                            <tr :class="!m.is_read ? 'bg-[#FDF8F9] font-medium' : 'hover:bg-[#FDF8F9]/50'" class="transition">
                                {{-- Pengirim --}}
                                <td class="py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-[#FCE7EC] text-[#B86B7F] flex items-center justify-center font-bold text-xs shrink-0" 
                                             x-text="m.name.charAt(0)"></div>
                                        <div>
                                            <p class="font-bold text-[#2D1F25]" x-text="m.name"></p>
                                            <p class="text-[10px] text-stone-400 font-light" x-text="m.email"></p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kategori --}}
                                <td class="py-4">
                                    <span class="px-2.5 py-1 rounded-full bg-white border border-[#FCE7EC] text-[10px] font-medium text-[#2D1F25]" x-text="m.subject"></span>
                                </td>

                                {{-- Ringkasan --}}
                                <td class="py-4 max-w-xs truncate text-stone-600 font-light" x-text="m.message"></td>

                                {{-- Tanggal --}}
                                <td class="py-4 text-stone-400 text-[11px]" x-text="m.date"></td>

                                {{-- Status Baca --}}
                                <td class="py-4">
                                    <span :class="!m.is_read ? 'bg-[#FCE7EC] text-[#B86B7F]' : 'bg-stone-100 text-stone-400'"
                                          class="px-2.5 py-1 rounded-full text-[10px] font-bold" 
                                          x-text="!m.is_read ? 'Baru' : 'Dibaca'"></span>
                                </td>

                                {{-- Aksi --}}
                                <td class="py-4 text-right space-x-2">
                                    <button type="button" @click="openMessage(m)" 
                                            class="px-3.5 py-1.5 rounded-xl bg-[#FCE7EC] text-[#B86B7F] hover:bg-[#B86B7F] hover:text-white font-medium transition text-xs">
                                        Buka Pesan
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ================= MODAL DETAIL PESAN MASUK ================= --}}
        <div x-show="modalDetailPesan" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm" 
             style="display: none;">
            <div @click.away="modalDetailPesan = false" 
                 class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-[#FCE7EC] shadow-2xl space-y-5">
                
                <div class="flex items-center justify-between pb-3 border-b border-[#FCE7EC]">
                    <div>
                        <span class="text-[10px] uppercase font-mono tracking-widest text-[#B86B7F] font-bold" x-text="selectedMessage.subject"></span>
                        <h3 class="text-lg font-serif font-bold text-[#2D1F25]" x-text="'Pesan dari ' + selectedMessage.name"></h3>
                    </div>
                    <button @click="modalDetailPesan = false" class="text-stone-400 hover:text-[#2D1F25] text-xl font-bold">&times;</button>
                </div>

                <div class="space-y-4 text-xs text-[#5A4950]">
                    <div class="p-3.5 rounded-2xl bg-[#FDF8F9] border border-[#FCE7EC] space-y-1">
                        <div class="flex justify-between">
                            <span class="text-stone-400">Email:</span>
                            <span class="font-bold text-[#2D1F25]" x-text="selectedMessage.email"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-stone-400">WhatsApp / Telp:</span>
                            <span class="font-bold text-[#2D1F25]" x-text="selectedMessage.phone"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-stone-400">Tanggal Kirim:</span>
                            <span class="text-stone-500" x-text="selectedMessage.date"></span>
                        </div>
                    </div>

                    <div>
                        <span class="text-[10px] uppercase font-bold text-stone-400">Isi Pesan:</span>
                        <div class="p-4 rounded-2xl bg-stone-50 border border-stone-200 mt-1 leading-relaxed text-stone-700 font-light" x-text="selectedMessage.message"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-3 border-t border-[#FCE7EC] text-xs">
                    <button type="button" @click="modalDetailPesan = false" class="px-5 py-2.5 rounded-full border border-[#FCE7EC] text-[#5A4950]">Tutup</button>
                    <a :href="'https://wa.me/' + selectedMessage.phone.replace(/[^0-9]/g, '') + '?text=Halo%20' + encodeURIComponent(selectedMessage.name) + ',%20terima%20kasih%20telah%20menghubungi%20Percanesia'" 
                       target="_blank"
                       class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition shadow-sm">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                        <span>Balas via WhatsApp</span>
                    </a>
                </div>

            </div>
        </div>

    </main>
</body>
</html>