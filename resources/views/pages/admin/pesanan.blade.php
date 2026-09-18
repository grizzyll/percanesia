<!-- KONTEN TAB: PESANAN MASUK -->
<div class="space-y-6" x-data="orderManager()">
    <!-- Bagian Atas: Judul & Informasi -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white/90 backdrop-blur-md p-6 rounded-3xl border border-brandPinkLight shadow-sm">
        <div>
            <h3 class="text-lg font-bold text-brandDeep">Pemantauan Pesanan Masuk</h3>
            <p class="text-xs text-brandMauve mt-0.5">Pantau status transaksi, pembayaran, dan pengiriman pesanan pelanggan Percanesia.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-xl bg-brandPinkLight text-brandDeep text-xs font-semibold">
                Total: <span x-text="orders.length"></span> Pesanan
            </span>
        </div>
    </div>

    <!-- Tabel Daftar Pesanan Masuk -->
    <div class="bg-white/90 backdrop-blur-md rounded-3xl border border-brandPinkLight shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-brandPinkLight/30 text-brandMauve border-b border-brandPinkLight/50">
                        <th class="py-4 px-6 font-semibold">No. Order</th>
                        <th class="py-4 px-6 font-semibold">Pelanggan</th>
                        <th class="py-4 px-6 font-semibold">Total Biaya</th>
                        <th class="py-4 px-6 font-semibold">Status</th>
                        <th class="py-4 px-6 font-semibold text-right">Aksi / Ubah Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brandPinkLight/20">
                    <template x-for="order in orders" :key="order.id">
                        <tr class="hover:bg-brandPinkLight/10 transition-colors">
                            <td class="py-4 px-6 font-bold text-brandDeep" x-text="order.order_number"></td>
                            <td class="py-4 px-6 font-medium text-brandText" x-text="order.customer"></td>
                            <td class="py-4 px-6 font-semibold text-brandDeep" x-text="formatRupiah(order.grand_total)"></td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider"
                                    :class="{
                                        'bg-yellow-100 text-yellow-700': order.status === 'Pending',
                                        'bg-blue-100 text-blue-700': order.status === 'Diproses',
                                        'bg-green-100 text-green-700': order.status === 'Selesai'
                                    }"
                                    x-text="order.status">
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right space-x-1">
                                <select @change="updateStatus(order.id, $event.target.value)" class="px-3 py-1.5 rounded-xl border border-brandPinkLight bg-white text-brandDeep text-xs focus:outline-none focus:border-brandMauve">
                                    <option value="Pending" :selected="order.status === 'Pending'">Pending</option>
                                    <option value="Diproses" :selected="order.status === 'Diproses'">Diproses</option>
                                    <option value="Selesai" :selected="order.status === 'Selesai'">Selesai</option>
                                </select>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function orderManager() {
        return {
            updateStatus(id, newStatus) {
                let order = this.orders.find(o => o.id === id);
                if(order) {
                    order.status = newStatus;
                    // Bisa ditambahkan notifikasi kecil atau logic sinkronisasi backend nanti
                }
            }
        }
    }
</script>