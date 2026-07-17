<div class="bg-white rounded-2xl border border-brandLightSage/20 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-brandLightSage/20 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-brandOffWhite/50">
        <input type="text" x-model="searchProductQuery" placeholder="Cari nama produk perca..." class="px-4 py-2 rounded-xl border border-brandLightSage/50 text-sm w-full max-w-xs focus:outline-none">
        <!-- Tombol Aksen Pink Pastel Utama -->
        <button @click="openAddModal = true" class="bg-brandPink text-brandDarkGreen font-bold px-5 py-2.5 rounded-xl hover:bg-brandPink/80 transition text-sm shadow-md">
            <i class="fa-solid fa-plus mr-2"></i>Tambah Produk Baru
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm border-collapse">
            <thead>
                <tr class="bg-brandOffWhite text-brandSage font-bold uppercase text-xs">
                    <th class="p-4 pl-6">Foto</th>
                    <th class="p-4">Nama Produk</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Stok</th>
                    <th class="p-4">Harga</th>
                    <th class="p-4 pr-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="product in filteredProducts()">
                    <tr class="border-b border-brandLightSage/10 hover:bg-brandOffWhite/20">
                        <td class="p-4 pl-6"><img :src="product.image" class="w-12 h-12 object-cover rounded-xl border bg-white"></td>
                        <td class="p-4 font-bold text-brandDarkGreen" x-text="product.name"></td>
                        <td class="p-4 text-brandDarkGreen"><span class="bg-brandLightSage/30 px-2.5 py-1 rounded-lg text-xs font-semibold" x-text="product.category"></span></td>
                        <td class="p-4 font-bold" :class="product.stock <= 5 ? 'text-red-500' : 'text-brandDarkGreen'" x-text="product.stock + ' unit'"></td>
                        <td class="p-4 font-bold text-brandDarkGreen" x-text="formatRupiah(product.price)"></td>
                        <td class="p-4 pr-6 text-center space-x-2">
                            <button @click="editProduct(product)" class="text-brandSage hover:text-brandDarkGreen"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button @click="deleteProduct(product.id)" class="text-red-400 hover:text-red-600"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>