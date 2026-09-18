<!-- KONTEN TAB: KELOLA PRODUK -->
<div class="space-y-6" x-data="productManager()">
    <!-- Bagian Atas: Judul & Tombol Tambah Produk -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white/90 backdrop-blur-md p-6 rounded-3xl border border-brandPinkLight shadow-sm">
        <div>
            <h3 class="text-lg font-bold text-brandDeep">Katalog Produk Perca</h3>
            <p class="text-xs text-brandMauve mt-0.5">Kelola foto, harga, berat, bahan, dan manajemen stok produk sustainable Percanesia.</p>
        </div>
        <button @click="addNewProduct()" class="flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-gradient-to-r from-brandPink to-brandMauve text-white text-xs font-semibold shadow-md hover:opacity-95 transition-all">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Produk Baru</span>
        </button>
    </div>

    <!-- Tabel Daftar Produk -->
    <div class="bg-white/90 backdrop-blur-md rounded-3xl border border-brandPinkLight shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-brandPinkLight/30 text-brandMauve border-b border-brandPinkLight/50">
                        <th class="py-4 px-6 font-semibold">Nama Produk</th>
                        <th class="py-4 px-6 font-semibold">Harga</th>
                        <th class="py-4 px-6 font-semibold">Bahan & Berat</th>
                        <th class="py-4 px-6 font-semibold">Stok</th>
                        <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brandPinkLight/20">
                    <template x-for="product in products" :key="product.id">
                        <tr class="hover:bg-brandPinkLight/10 transition-colors">
                            <td class="py-4 px-6 font-semibold text-brandDeep flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-brandPinkLight/50 flex items-center justify-center text-brandMauve font-bold">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                </div>
                                <span x-text="product.name"></span>
                            </td>
                            <td class="py-4 px-6 font-medium text-brandText" x-text="formatRupiah(product.price)"></td>
                            <td class="py-4 px-6 text-brandText">
                                <span class="block font-medium" x-text="product.material || '-' "></span>
                                <span class="text-[10px] text-brandMauve" x-text="(product.weight || 0) + ' gram'"></span>
                            </td>
                            <td class="py-4 px-6">
                                <button @click="openQuickStockUpdate(product)" class="px-3 py-1 rounded-full text-[10px] font-bold transition-all hover:opacity-80"
                                    :class="product.stock <= 5 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-700'"
                                    x-text="product.stock + ' Unit (Update)'">
                                </button>
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <button @click="editProduct(product)" class="px-3 py-1.5 rounded-xl bg-brandPinkLight text-brandDeep font-medium hover:bg-brandMauve hover:text-white transition-all">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                <button @click="deleteProduct(product.id)" class="px-3 py-1.5 rounded-xl bg-red-50 text-red-500 font-medium hover:bg-red-500 hover:text-white transition-all">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form Input CRUD Produk -->
    <div x-show="openAddModal || editMode" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak style="display: none;">
        <div @click.outside="closeProductModal()" class="bg-white w-full max-w-xl rounded-3xl overflow-hidden shadow-xl border border-brandPinkLight flex flex-col max-h-[90vh]">
            <div class="bg-brandDeep text-white p-6 flex justify-between items-center">
                <h3 class="font-bold text-lg" x-text="editMode ? 'Edit Data Produk' : 'Tambah Produk Baru'"></h3>
                <button @click="closeProductModal()"><i class="fa-solid fa-xmark text-xl"></i></button>
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
                    <button type="submit" class="bg-brandMauve hover:bg-brandDeep text-white font-bold px-6 py-2.5 rounded-xl text-sm shadow-md transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Quick Stock Update -->
    <div x-show="openStockModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak style="display: none;">
        <div @click.outside="openStockModal = false" class="bg-white w-full max-w-sm rounded-2xl overflow-hidden shadow-xl p-6 space-y-4 border border-brandPinkLight">
            <h4 class="font-bold text-brandDeep text-base" x-text="'Update Stok: ' + (selectedProductForStock?.name || '')"></h4>
            <div>
                <label class="block text-xs font-bold text-brandDeep uppercase mb-1">Jumlah Stok Baru</label>
                <input type="number" x-model="quickStockValue" class="w-full px-4 py-2.5 rounded-xl border border-brandPinkLight text-sm focus:outline-none focus:ring-2 focus:ring-brandMauve/30">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" @click="openStockModal = false" class="px-4 py-2 rounded-xl text-xs font-bold border border-brandPinkLight text-brandText">Batal</button>
                <button type="button" @click="saveQuickStock()" class="bg-brandMauve hover:bg-brandDeep text-white text-xs font-bold px-4 py-2 rounded-xl shadow transition-all">Simpan</button>
            </div>
            <!-- Di bagian bawah file produk.blade.php sebelum penutup div utama -->
@include('pages.admin.modals')
        </div>
    </div>
</div>

<script>
    function productManager() {
        return {
            openAddModal: false,
            editMode: false,
            openStockModal: false,
            selectedProductForStock: null,
            quickStockValue: '',
            
            productForm: {
                id: null,
                name: '',
                price: '',
                stock: '',
                weight: '',
                material: ''
            },

            addNewProduct() {
                this.editMode = false;
                this.productForm = { id: null, name: '', price: '', stock: '', weight: '', material: '' };
                this.openAddModal = true;
            },

            editProduct(product) {
                this.editMode = true;
                this.productForm = { ...product };
                this.openAddModal = true;
            },

            closeProductModal() {
                this.openAddModal = false;
                this.editMode = false;
            },

            saveProduct() {
                if (this.editMode) {
                    let index = this.products.findIndex(p => p.id === this.productForm.id);
                    if (index !== -1) {
                        this.products[index] = { ...this.productForm };
                    }
                } else {
                    let newId = this.products.length ? Math.max(...this.products.map(p => p.id)) + 1 : 1;
                    this.products.push({ id: newId, ...this.productForm });
                }
                this.closeProductModal();
            },

            deleteProduct(id) {
                if(confirm('Yakin ingin menghapus produk ini?')) {
                    this.products = this.products.filter(p => p.id !== id);
                }
            },

            openQuickStockUpdate(product) {
                this.selectedProductForStock = product;
                this.quickStockValue = product.stock;
                this.openStockModal = true;
            },

            saveQuickStock() {
                if (this.selectedProductForStock) {
                    let product = this.products.find(p => p.id === this.selectedProductForStock.id);
                    if (product) {
                        product.stock = parseInt(this.quickStockValue) || 0;
                    }
                }
                this.openStockModal = false;
                this.selectedProductForStock = null;
            }
        }
    }
</script>