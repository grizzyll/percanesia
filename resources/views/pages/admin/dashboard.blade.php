<!-- KONTEN TAB: DASHBOARD RINGKASAN -->
<div class="space-y-8">
    <!-- Kartu Statistik Utama -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Total Penjualan -->
        <div class="bg-white/90 backdrop-blur-md p-6 rounded-3xl border border-brandPinkLight shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-[10px] font-bold text-brandMauve uppercase tracking-widest">Total Penjualan</p>
                <h3 class="text-2xl font-bold text-brandDeep" x-text="formatRupiah(totals.sales)"></h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-brandPinkLight/60 flex items-center justify-center text-brandMauve text-xl">
                <i class="fa-solid fa-wallet"></i>
            </div>
        </div>

        <!-- Card 2: Pesanan Baru -->
        <div class="bg-white/90 backdrop-blur-md p-6 rounded-3xl border border-brandPinkLight shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-[10px] font-bold text-brandMauve uppercase tracking-widest">Pesanan Baru</p>
                <h3 class="text-2xl font-bold text-brandDeep" x-text="orders.length + ' Pesanan'"></h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-brandPinkLight/60 flex items-center justify-center text-brandMauve text-xl">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
        </div>

        <!-- Card 3: Varian Katalog -->
        <div class="bg-white/90 backdrop-blur-md p-6 rounded-3xl border border-brandPinkLight shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-[10px] font-bold text-brandMauve uppercase tracking-widest">Varian Katalog</p>
                <h3 class="text-2xl font-bold text-brandDeep" x-text="products.length + ' Produk'"></h3>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-brandPinkLight/60 flex items-center justify-center text-brandMauve text-xl">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
        </div>
    </div>

    <!-- Bagian Bawah: Cek Stok & Aktivitas Terkini -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Widget Cek Stok -->
        <div class="bg-white/90 backdrop-blur-md p-6 rounded-3xl border border-brandPinkLight shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-brandPinkLight/40 pb-4">
                <div class="flex items-center gap-2">
                    <span class="w-1 h-4 rounded-full bg-brandMauve"></span>
                    <h4 class="font-semibold text-brandDeep text-sm">Cek Stok</h4>
                </div>
                <span class="text-[10px] bg-red-100 text-red-600 px-2.5 py-1 rounded-full font-bold">Perlu Perhatian</span>
            </div>

            <div class="space-y-3">
                <template x-for="product in products" :key="product.id">
                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-brandBg border border-brandPinkLight/50">
                        <div class="space-y-0.5">
                            <p class="text-xs font-semibold text-brandDeep" x-text="product.name"></p>
                            <p class="text-[10px] font-bold text-red-500 uppercase tracking-wide" x-text="'Sisa: ' + product.stock + ' unit'"></p>
                        </div>
                        <button @click="openQuickStockUpdate(product)" class="px-4 py-2 rounded-xl bg-brandMauve text-white text-xs font-medium hover:bg-brandDeep transition-all">
                            Update
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Widget Aktivitas Terkini -->
        <div class="bg-white/90 backdrop-blur-md p-6 rounded-3xl border border-brandPinkLight shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-brandPinkLight/40 pb-4">
                <div class="flex items-center gap-2">
                    <span class="w-1 h-4 rounded-full bg-brandMauve"></span>
                    <h4 class="font-semibold text-brandDeep text-sm">Aktivitas Terkini</h4>
                </div>
                <button @click="currentTab = 'orders'" class="text-[10px] font-bold text-brandMauve hover:text-brandDeep uppercase tracking-wider">
                    Lihat Semua
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-brandMauve border-b border-brandPinkLight/30">
                            <th class="pb-3 font-semibold">Nomor Order</th>
                            <th class="pb-3 font-semibold">Pelanggan</th>
                            <th class="pb-3 font-semibold text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brandPinkLight/20">
                        <template x-for="order in orders" :key="order.id">
                            <tr>
                                <td class="py-3.5 font-bold text-brandDeep" x-text="order.order_number"></td>
                                <td class="py-3.5 text-brandText" x-text="order.customer"></td>
                                <td class="py-3.5 font-semibold text-brandDeep text-right" x-text="formatRupiah(order.grand_total)"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>