<!-- Modal Form Input CRUD Produk -->
<div x-show="openAddModal || editMode" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak>
    <div class="bg-white w-full max-w-xl rounded-3xl overflow-hidden shadow-xl border border-brandLightSage/30 flex flex-col max-h-[90vh]">
        <div class="bg-brandDarkGreen text-white p-6 flex justify-between items-center">
            <h3 class="font-comfortaa font-bold text-lg" x-text="editMode ? 'Edit Data Produk' : 'Tambah Produk Baru'"></h3>
            <button @click="closeProductModal()"><i class="fa-solid fa-xmark text-xl"></i></button>
        </div>
        <form @submit.prevent="saveProduct" class="p-6 space-y-4 overflow-y-auto flex-grow">
            <div>
                <label class="block text-xs font-bold text-brandDarkGreen uppercase mb-1">Nama Produk</label>
                <input type="text" x-model="productForm.name" required class="w-full px-4 py-2.5 rounded-xl border border-brandLightSage/60 text-sm focus:outline-none focus:ring-2 focus:ring-brandSage/30">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-brandDarkGreen uppercase mb-1">Harga (IDR)</label>
                    <input type="number" x-model="productForm.price" required class="w-full px-4 py-2.5 rounded-xl border border-brandLightSage/60 text-sm focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-brandDarkGreen uppercase mb-1">Stok Awal</label>
                    <input type="number" x-model="productForm.stock" required class="w-full px-4 py-2.5 rounded-xl border border-brandLightSage/60 text-sm focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-brandDarkGreen uppercase mb-1">Berat (gram)</label>
                    <input type="number" x-model="productForm.weight" required placeholder="Untuk RajaOngkir" class="w-full px-4 py-2.5 rounded-xl border border-brandLightSage/60 text-sm focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-brandDarkGreen uppercase mb-1">Bahan Perca</label>
                    <input type="text" x-model="productForm.material" placeholder="Katun, Tenun, dll" class="w-full px-4 py-2.5 rounded-xl border border-brandLightSage/60 text-sm focus:outline-none">
                </div>
            </div>
            <div class="pt-4 border-t border-brandLightSage/20 flex justify-end gap-2">
                <button type="button" @click="closeProductModal()" class="px-5 py-2.5 rounded-xl border border-brandLightSage/50 text-brandDarkGreen font-semibold text-sm">Batal</button>
                <!-- Tombol Utama Pink Pastel -->
                <button type="submit" class="bg-brandPink hover:bg-brandPink/80 text-brandDarkGreen font-bold px-6 py-2.5 rounded-xl text-sm shadow-md">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Quick Stock Update -->
<div x-show="openStockModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak>
    <div class="bg-white w-full max-w-sm rounded-2xl overflow-hidden shadow-xl p-6 space-y-4 border">
        <h4 class="font-bold text-brandDarkGreen text-base" x-text="selectedProductForStock?.name"></h4>
        <div>
            <label class="block text-xs font-bold text-brandDarkGreen uppercase mb-1">Jumlah Stok Baru</label>
            <input type="number" x-model="quickStockValue" class="w-full px-4 py-2.5 rounded-xl border text-sm focus:outline-none">
        </div>
        <div class="flex justify-end gap-2">
            <button @click="openStockModal = false" class="px-4 py-2 rounded-xl text-xs font-bold border">Batal</button>
            <button @click="saveQuickStock()" class="bg-brandPink text-brandDarkGreen text-xs font-bold px-4 py-2 rounded-xl shadow">Simpan</button>
        </div>
    </div>
</div>