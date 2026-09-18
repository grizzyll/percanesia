<!-- ========================================== -->
<!-- MODAL KELOLA PRODUK (CRUD & STOCK UPDATE) -->
<!-- ========================================== -->

<!-- 1. Modal Form Input & Edit CRUD Produk -->
<div x-show="openAddModal || editMode" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak style="display: none;">
    <div @click.outside="closeProductModal()" class="bg-white w-full max-w-xl rounded-3xl overflow-hidden shadow-xl border border-brandPinkLight flex flex-col max-h-[90vh]">
        <div class="bg-brandDeep text-white p-6 flex justify-between items-center">
            <h3 class="font-bold text-lg" x-text="editMode ? 'Edit Data Produk' : 'Tambah Produk Baru'"></h3>
            <button @click="closeProductModal()" class="text-white/80 hover:text-white"><i class="fa-solid fa-xmark text-xl"></i></button>
        </div>
        <form @submit.prevent="saveProduct" class="p-6 space-y-4 overflow-y-auto flex-grow">
            <div>
                <label class="block text-xs font-bold text-brandDeep uppercase mb-1">Nama Produk</label>
                <input type="text" x-model="productForm.name" required class="w-full px-4 py-2.5 rounded-xl border border-brandPinkLight text-sm focus:outline-none focus:ring-2 focus:ring-brandMauve/30">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-brandDeep uppercase mb-1">Harga (IDR)</label>
                    <input type="number" x-model="productForm.price" required class="w-full px-4 py-2.5 rounded-xl border border-brandPinkLight text-sm focus:outline-none focus:ring-2 focus:ring-brandMauve/30">
                </div>
                <div>
                    <label class="block text-xs font-bold text-brandDeep uppercase mb-1">Stok Awal</label>
                    <input type="number" x-model="productForm.stock" required class="w-full px-4 py-2.5 rounded-xl border border-brandPinkLight text-sm focus:outline-none focus:ring-2 focus:ring-brandMauve/30">
                </div>
                <div>
                    <label class="block text-xs font-bold text-brandDeep uppercase mb-1">Berat (gram)</label>
                    <input type="number" x-model="productForm.weight" required placeholder="Untuk RajaOngkir" class="w-full px-4 py-2.5 rounded-xl border border-brandPinkLight text-sm focus:outline-none focus:ring-2 focus:ring-brandMauve/30">
                </div>
                <div>
                    <label class="block text-xs font-bold text-brandDeep uppercase mb-1">Bahan Perca</label>
                    <input type="text" x-model="productForm.material" placeholder="Katun, Tenun, dll" class="w-full px-4 py-2.5 rounded-xl border border-brandPinkLight text-sm focus:outline-none focus:ring-2 focus:ring-brandMauve/30">
                </div>
            </div>
            <div class="pt-4 border-t border-brandPinkLight/20 flex justify-end gap-2">
                <button type="button" @click="closeProductModal()" class="px-5 py-2.5 rounded-xl border border-brandPinkLight text-brandDeep font-semibold text-sm">Batal</button>
                <button type="submit" class="bg-brandPink hover:bg-brandMauve hover:text-white text-brandDeep font-bold px-6 py-2.5 rounded-xl text-sm shadow-md transition-all">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Modal Quick Stock Update -->
<div x-show="openStockModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak style="display: none;">
    <div @click.outside="openStockModal = false" class="bg-white w-full max-w-sm rounded-2xl overflow-hidden shadow-xl p-6 space-y-4 border border-brandPinkLight">
        <h4 class="font-bold text-brandDeep text-base" x-text="'Update Stok: ' + (selectedProductForStock?.name || '')"></h4>
        <div>
            <label class="block text-xs font-bold text-brandDeep uppercase mb-1">Jumlah Stok Baru</label>
            <input type="number" x-model="quickStockValue" class="w-full px-4 py-2.5 rounded-xl border border-brandPinkLight text-sm focus:outline-none focus:ring-2 focus:ring-brandMauve/30">
        </div>
        <div class="flex justify-end gap-2">
            <button type="button" @click="openStockModal = false" class="px-4 py-2 rounded-xl text-xs font-bold border border-brandPinkLight text-brandText">Batal</button>
            <button type="button" @click="saveQuickStock()" class="bg-brandPink hover:bg-brandMauve hover:text-white text-brandDeep text-xs font-bold px-4 py-2 rounded-xl shadow transition-all">Simpan</button>
        </div>
    </div>
</div>