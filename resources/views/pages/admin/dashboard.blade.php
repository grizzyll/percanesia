<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <!-- Stat Card 1 -->
    <div class="bg-white/90 p-8 rounded-[2rem] border border-brandPinkLight shadow-[0_10px_30px_-15px_rgba(163,107,126,0.1)] flex items-center justify-between group hover:border-brandPink transition-all duration-300">
        <div>
            <p class="text-[10px] text-brandMauve uppercase font-semibold tracking-widest">Total Penjualan</p>
            <h3 class="text-2xl font-semibold text-brandDeep mt-1 tracking-tight" x-text="formatRupiah(totals.sales)"></h3>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-brandPinkLight/50 flex items-center justify-center text-brandMauve text-xl group-hover:bg-brandMauve group-hover:text-white transition-all shadow-inner">
            <i class="fa-solid fa-wallet"></i>
        </div>
    </div>
    
    <!-- Stat Card 2 -->
    <div class="bg-white/90 p-8 rounded-[2rem] border border-brandPinkLight shadow-[0_10px_30px_-15px_rgba(163,107,126,0.1)] flex items-center justify-between group hover:border-brandPink transition-all duration-300">
        <div>
            <p class="text-[10px] text-brandMauve uppercase font-semibold tracking-widest">Pesanan Baru</p>
            <h3 class="text-2xl font-semibold text-brandDeep mt-1 tracking-tight" x-text="orders.length + ' Pesanan'"></h3>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-brandPinkLight/50 flex items-center justify-center text-brandMauve text-xl group-hover:bg-brandMauve group-hover:text-white transition-all shadow-inner">
            <i class="fa-solid fa-hourglass-half"></i>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white/90 p-8 rounded-[2rem] border border-brandPinkLight shadow-[0_10px_30px_-15px_rgba(163,107,126,0.1)] flex items-center justify-between group hover:border-brandPink transition-all duration-300">
        <div>
            <p class="text-[10px] text-brandMauve uppercase font-semibold tracking-widest">Varian Katalog</p>
            <h3 class="text-2xl font-semibold text-brandDeep mt-1 tracking-tight" x-text="products.length + ' Produk'"></h3>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-brandPinkLight/50 flex items-center justify-center text-brandMauve text-xl group-hover:bg-brandMauve group-hover:text-white transition-all shadow-inner">
            <i class="fa-solid fa-boxes-stacked"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-10">
    <!-- Peringatan Stok -->
    <div class="bg-white/95 p-8 rounded-[2.5rem] border border-brandPinkLight shadow-sm lg:col-span-1">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-1.5 h-6 bg-brandPink rounded-full"></div>
            <h4 class="font-semibold text-brandDeep text-lg tracking-tight">Cek Stok</h4>
        </div>
        <div class="space-y-4">
            <template x-for="product in products.filter(p => p.stock <= 5)">
                <div class="flex items-center justify-between p-5 bg-white border border-brandPinkLight rounded-2xl group hover:border-brandMauve transition-all shadow-sm">
                    <div class="min-w-0 flex-grow pr-4">
                        <p class="text-[13px] font-medium text-brandDeep truncate" x-text="product.name"></p>
                        <p class="text-[10px] text-red-400 font-bold mt-1 tracking-wider uppercase" x-text="'Sisa: ' + product.stock + ' Unit'"></p>
                    </div>
                    <!-- Tombol Deep Mauve Pop -->
                    <button @click="openQuickStockUpdate(product)" class="bg-brandMauve text-white text-[10px] font-bold px-4 py-2 rounded-xl hover:bg-brandDeep transition-all shadow-md">
                        UPDATE
                    </button>
                </div>
            </template>
        </div>
    </div>

    <!-- Mini Table Aktivitas -->
    <div class="bg-white/95 p-8 rounded-[2.5rem] border border-brandPinkLight shadow-sm lg:col-span-2">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-6 bg-brandMauve rounded-full"></div>
                <h4 class="font-semibold text-brandDeep text-lg tracking-tight">Aktivitas Terkini</h4>
            </div>
            <button class="text-[10px] font-bold text-brandMauve uppercase tracking-widest underline decoration-brandPink decoration-2 underline-offset-8 hover:text-brandDeep transition-colors">Lihat Semua</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-[13px]">
                <thead>
                    <tr class="text-[10px] font-semibold uppercase tracking-[0.15em] text-brandMauve/60 border-b border-brandPinkLight pb-4">
                        <th class="pb-5">Nomor Order</th>
                        <th class="pb-5">Pelanggan</th>
                        <th class="pb-5 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brandPinkLight/30">
                    <template x-for="order in orders">
                        <tr class="group hover:bg-brandPinkLight/10 transition-colors">
                            <td class="py-5 font-medium">
                                <span class="bg-brandPinkLight text-brandMauve px-3 py-1.5 rounded-lg text-[11px] font-bold" x-text="order.order_number"></span>
                            </td>
                            <td class="py-5 text-brandDeep font-medium" x-text="order.customer"></td>
                            <td class="py-5 text-right font-bold text-brandDeep" x-text="formatRupiah(order.grand_total)"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>