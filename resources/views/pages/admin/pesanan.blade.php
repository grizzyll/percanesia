<div class="bg-white rounded-2xl border border-brandLightSage/20 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-brandLightSage/20 bg-brandOffWhite/50 flex gap-2">
        <button @click="orderFilter = 'all'" :class="orderFilter === 'all' ? 'bg-brandDarkGreen text-white' : 'bg-white text-brandDarkGreen'" class="px-4 py-2 rounded-xl text-xs font-bold border border-brandLightSage/20">Semua</button>
        <button @click="orderFilter = 'pending'" :class="orderFilter === 'pending' ? 'bg-amber-500 text-white' : 'bg-white text-brandDarkGreen'" class="px-4 py-2 rounded-xl text-xs font-bold border border-brandLightSage/20">Pending</button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="bg-brandOffWhite text-brandSage font-bold uppercase text-xs">
                    <th class="p-4 pl-6">No. Order</th>
                    <th class="p-4">Pelanggan</th>
                    <th class="p-4">Pengiriman (RajaOngkir)</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 pr-6 text-center">Aksi Status</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="order in filteredOrders()">
                    <tr class="border-b border-brandLightSage/10">
                        <td class="p-4 pl-6 font-bold text-brandDarkGreen" x-text="order.order_number"></td>
                        <td class="p-4 text-brandDarkGreen" x-text="order.customer"></td>
                        <td class="p-4 text-xs text-brandDarkGreen">
                            <span class="bg-brandPink/40 text-brandDarkGreen px-2 py-0.5 rounded uppercase font-bold" x-text="order.shipping_courier"></span>
                            <span class="text-brandSage font-semibold" x-text="order.shipping_service"></span>
                            <p class="text-[11px] text-brandSage mt-1 max-w-[180px] truncate" x-text="order.shipping_address"></p>
                        </td>
                        <td class="p-4 font-bold text-brandDarkGreen" x-text="formatRupiah(order.grand_total)"></td>
                        <td class="p-4"><span :class="getStatusClass(order.status)" class="text-xs px-2.5 py-1 rounded-full font-semibold" x-text="formatStatus(order.status)"></span></td>
                        <td class="p-4 pr-6 text-center">
                            <button x-show="order.status === 'pending'" @click="updateOrderStatus(order.id, 'paid')" class="bg-brandPink hover:bg-brandPink/80 text-brandDarkGreen text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm">Konfirmasi Bayar</button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>