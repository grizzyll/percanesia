<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Masuk - Percanesia Studio</title>

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
          statusFilter: 'semua',
          searchQuery: '',
          modalDetailOrder: false,
          selectedOrder: { id: '', customer: '', phone: '', address: '', item: '', total: 0, status: '', courier: '', payment: '', date: '' },
          orders: [
              { id: '#PCN-1201', customer: 'Tania Syabandia', phone: '081234567890', address: 'Jl. Soekarno Hatta No. 123, Malang, Jatim', item: 'Patchwork Tote Bag (1x)', total: 200000, status: 'Diproses', courier: 'JNE Reguler', payment: 'Transfer Bank (BCA)', date: '18 Okt 2025' },
              { id: '#PCN-1202', customer: 'Sarah Miller', phone: '+61 412 345 678', address: '42 Wallaby Way, Sydney, Australia', item: 'Bawana Quilt (1x), Cushion Cover (2x)', total: 695000, status: 'Dikirim', courier: 'DHL Express Global', payment: 'E-Wallet / Midtrans', date: '17 Okt 2025' },
              { id: '#PCN-1203', customer: 'Budi Santoso', phone: '085712349900', address: 'Jl. Ijen No. 45, Klojen, Malang, Jatim', item: 'Dompet Perca (2x)', total: 145000, status: 'Selesai', courier: 'Same Day Malang', payment: 'COD (Bayar di Tempat)', date: '16 Okt 2025' },
              { id: '#PCN-1204', customer: 'Aulia Rahma', phone: '082198765432', address: 'Jl. Diponegoro No. 88, Surabaya, Jatim', item: 'Selimut Perca Vintage (1x)', total: 265000, status: 'Diproses', courier: 'SiCepat Express', payment: 'QRIS Instan', date: '18 Okt 2025' }
          ],
          formatRupiah(num) {
              return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
          },
          get filteredOrders() {
              return this.orders.filter(order => {
                  let matchStatus = this.statusFilter === 'semua' || order.status.toLowerCase() === this.statusFilter.toLowerCase();
                  let matchSearch = order.customer.toLowerCase().includes(this.searchQuery.toLowerCase()) || order.id.toLowerCase().includes(this.searchQuery.toLowerCase());
                  return matchStatus && matchSearch;
              });
          },
          openDetail(order) {
              this.selectedOrder = Object.assign({}, order);
              this.modalDetailOrder = true;
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

                {{-- 2. Pesanan Masuk (AKTIF) --}}
                <a href="{{ url('/admin/pesanan') }}" 
                   class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl bg-[#B86B7F] text-white shadow-sm shadow-[#B86B7F]/30 transition">
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

    {{-- ================= KONTEN PESANAN MASUK ================= --}}
    <main class="flex-1 p-6 sm:p-10 overflow-y-auto">
        
        {{-- Header Topbar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-8 border-b border-[#FCE7EC] gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-serif text-[#2D1F25] font-normal">
                    Pesanan Masuk
                </h1>
                <p class="text-xs text-[#5A4950]/80 mt-1">Pantau transaksi belanja, proses pengiriman paket, dan pembaruan nomor resi.</p>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-[#B86B7F]" x-text="orders.length + ' Total Transaksi Tercatat'"></span>
            </div>
        </div>

        {{-- Filter & Search Toolbar --}}
        <div class="bg-white/90 backdrop-blur-md p-5 rounded-3xl border border-[#FCE7EC] shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            
            {{-- Filter Status Pills --}}
            <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 text-xs">
                <button type="button" @click="statusFilter = 'semua'" 
                        :class="statusFilter === 'semua' ? 'bg-[#B86B7F] text-white' : 'bg-[#FDF8F9] text-[#5A4950] hover:bg-[#FCE7EC]'"
                        class="px-4 py-2 rounded-2xl font-medium transition shrink-0">
                    Semua Status
                </button>
                <button type="button" @click="statusFilter = 'diproses'" 
                        :class="statusFilter === 'diproses' ? 'bg-[#B86B7F] text-white' : 'bg-[#FDF8F9] text-[#5A4950] hover:bg-[#FCE7EC]'"
                        class="px-4 py-2 rounded-2xl font-medium transition shrink-0">
                    Perlu Diproses
                </button>
                <button type="button" @click="statusFilter = 'dikirim'" 
                        :class="statusFilter === 'dikirim' ? 'bg-[#B86B7F] text-white' : 'bg-[#FDF8F9] text-[#5A4950] hover:bg-[#FCE7EC]'"
                        class="px-4 py-2 rounded-2xl font-medium transition shrink-0">
                    Sedang Dikirim
                </button>
                <button type="button" @click="statusFilter = 'selesai'" 
                        :class="statusFilter === 'selesai' ? 'bg-[#B86B7F] text-white' : 'bg-[#FDF8F9] text-[#5A4950] hover:bg-[#FCE7EC]'"
                        class="px-4 py-2 rounded-2xl font-medium transition shrink-0">
                    Selesai
                </button>
            </div>

            {{-- Search Bar --}}
            <div class="relative w-full md:w-64">
                <input type="text" x-model="searchQuery" placeholder="Cari no. order / pembeli..." 
                       class="w-full pl-9 pr-4 py-2 rounded-2xl border border-[#FCE7EC] text-xs text-[#2D1F25] focus:outline-none focus:ring-1 focus:ring-[#B86B7F] bg-[#FDF8F9]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-stone-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
            </div>

        </div>

        {{-- Tabel Daftar Pesanan --}}
        <div class="bg-white/90 backdrop-blur-md p-6 rounded-3xl border border-[#FCE7EC] shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-[#FCE7EC]/60">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-4 rounded-full bg-[#B86B7F]"></span>
                    <h3 class="font-serif text-lg font-medium text-[#2D1F25]">Daftar Pesanan Pelanggan</h3>
                </div>
                <span class="text-xs font-bold text-[#B86B7F]" x-text="filteredOrders.length + ' Pesanan Ditampilkan'"></span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-[#5A4950]">
                    <thead class="text-[#B86B7F] uppercase text-[10px] font-bold tracking-wider border-b border-[#FCE7EC]/60">
                        <tr>
                            <th class="pb-3 font-semibold">No. Order</th>
                            <th class="pb-3 font-semibold">Pelanggan & Kontak</th>
                            <th class="pb-3 font-semibold">Rincian Item</th>
                            <th class="pb-3 font-semibold">Kurir</th>
                            <th class="pb-3 font-semibold">Total Biaya</th>
                            <th class="pb-3 font-semibold">Status</th>
                            <th class="pb-3 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#FCE7EC]/50">
                        <template x-for="order in filteredOrders" :key="order.id">
                            <tr class="hover:bg-[#FDF8F9]/60 transition">
                                {{-- No. Order --}}
                                <td class="py-4 font-mono font-bold text-[#2D1F25]" x-text="order.id"></td>

                                {{-- Pelanggan --}}
                                <td class="py-4">
                                    <p class="font-bold text-[#2D1F25]" x-text="order.customer"></p>
                                    <p class="text-[11px] text-stone-400" x-text="order.phone"></p>
                                </td>

                                {{-- Item --}}
                                <td class="py-4 max-w-xs truncate" x-text="order.item"></td>

                                {{-- Kurir --}}
                                <td class="py-4">
                                    <span class="px-2.5 py-1 rounded-xl bg-[#FDF8F9] border border-[#FCE7EC] text-[10px] font-medium" x-text="order.courier"></span>
                                </td>

                                {{-- Total Biaya --}}
                                <td class="py-4">
                                    <p class="font-bold text-[#2D1F25]" x-text="formatRupiah(order.total)"></p>
                                    <p class="text-[10px] text-stone-400" x-text="order.payment"></p>
                                </td>

                                {{-- Status Badge --}}
                                <td class="py-4">
                                    <span :class="{
                                        'bg-amber-50 text-amber-700 border-amber-200': order.status === 'Diproses',
                                        'bg-blue-50 text-blue-700 border-blue-200': order.status === 'Dikirim',
                                        'bg-emerald-50 text-emerald-700 border-emerald-200': order.status === 'Selesai'
                                    }" class="px-3 py-1 rounded-full text-[10px] font-bold border" x-text="order.status"></span>
                                </td>

                                {{-- Tombol Aksi --}}
                                <td class="py-4 text-right">
                                    <button type="button" @click="openDetail(order)" 
                                            class="px-3.5 py-1.5 rounded-xl bg-[#FCE7EC] text-[#B86B7F] hover:bg-[#B86B7F] hover:text-white font-medium transition text-xs">
                                        Rincian & Resi
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ================= MODAL DETAIL & UPDATE RESI PESANAN ================= --}}
        <div x-show="modalDetailOrder" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm" 
             style="display: none;">
            <div @click.away="modalDetailOrder = false" 
                 class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-[#FCE7EC] shadow-2xl space-y-5">
                
                <div class="flex items-center justify-between pb-3 border-b border-[#FCE7EC]">
                    <div>
                        <span class="text-[10px] uppercase font-mono tracking-widest text-[#B86B7F] font-bold">Rincian Transaksi</span>
                        <h3 class="text-lg font-serif font-bold text-[#2D1F25]" x-text="'Pesanan ' + selectedOrder.id"></h3>
                    </div>
                    <button @click="modalDetailOrder = false" class="text-stone-400 hover:text-[#2D1F25] text-xl font-bold">&times;</button>
                </div>

                <div class="space-y-3.5 text-xs text-[#5A4950]">
                    <div class="p-3.5 rounded-2xl bg-[#FDF8F9] border border-[#FCE7EC] space-y-1">
                        <p class="font-bold text-[#2D1F25]" x-text="'Penerima: ' + selectedOrder.customer + ' (' + selectedOrder.phone + ')'"></p>
                        <p class="text-stone-500 font-light" x-text="'Alamat: ' + selectedOrder.address"></p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 rounded-2xl bg-[#FDF8F9] border border-[#FCE7EC]">
                            <span class="text-[10px] text-stone-400 uppercase font-semibold">Kurir Pengiriman</span>
                            <p class="font-bold text-[#2D1F25] mt-0.5" x-text="selectedOrder.courier"></p>
                        </div>
                        <div class="p-3 rounded-2xl bg-[#FDF8F9] border border-[#FCE7EC]">
                            <span class="text-[10px] text-stone-400 uppercase font-semibold">Metode Pembayaran</span>
                            <p class="font-bold text-[#2D1F25] mt-0.5" x-text="selectedOrder.payment"></p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[#5A4950] font-semibold mb-1">Update Status Pesanan</label>
                        <select x-model="selectedOrder.status" class="w-full px-4 py-2.5 rounded-2xl border border-[#FCE7EC] text-[#2D1F25] bg-white text-xs">
                            <option value="Diproses">Diproses (Sedang Dijahit / Dikemas)</option>
                            <option value="Dikirim">Dikirim (Paket di Kurir)</option>
                            <option value="Selesai">Selesai (Paket Diterima)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[#5A4950] font-semibold mb-1">Nomor Resi Pengiriman</label>
                        <input type="text" placeholder="Contoh: JNE8829102931 / DHL9921820"
                               class="w-full px-4 py-2.5 rounded-2xl border border-[#FCE7EC] text-[#2D1F25] focus:outline-none focus:ring-1 focus:ring-[#B86B7F] bg-[#FDF8F9]">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#FCE7EC] text-xs">
                    <button type="button" @click="modalDetailOrder = false" class="px-5 py-2.5 rounded-full border border-[#FCE7EC] text-[#5A4950]">Batal</button>
                    <button type="button" @click="
                        let o = orders.find(i => i.id === selectedOrder.id);
                        if (o) o.status = selectedOrder.status;
                        modalDetailOrder = false;
                        alert('Status pesanan berhasil diperbarui!');
                    " class="px-6 py-2.5 rounded-full bg-[#B86B7F] text-white font-semibold hover:bg-[#2D1F25] transition shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </div>

    </main>
</body>
</html>