{{-- 1. MODAL TAMBAH PRODUK BARU --}}
<div x-show="modalTambahProduk" 
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-brandDeep/40 backdrop-blur-sm" 
     style="display: none;">
    <div @click.away="modalTambahProduk = false" 
         class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-brandPinkLight shadow-2xl space-y-5">
        
        <div class="flex items-center justify-between pb-3 border-b border-brandPinkLight">
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-4 rounded-full bg-brandMauve"></span>
                <h3 class="text-lg font-serif font-bold text-brandDeep">Tambah Produk Perca Baru</h3>
            </div>
            <button @click="modalTambahProduk = false" class="text-stone-400 hover:text-brandDeep text-lg">&times;</button>
        </div>

        <form action="{{ url('/admin/produk/store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block text-brandText font-semibold mb-1">Nama Produk</label>
                <input type="text" name="nama" required placeholder="Contoh: Arunika Patchwork Kimono"
                       class="w-full px-4 py-2.5 rounded-2xl border border-brandPinkLight text-brandDeep focus:outline-none focus:ring-1 focus:ring-brandMauve bg-brandBg/40">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-brandText font-semibold mb-1">Kategori</label>
                    <select name="kategori" class="w-full px-4 py-2.5 rounded-2xl border border-brandPinkLight text-brandDeep bg-white">
                        <option value="Tas">Tas</option>
                        <option value="Dompet">Dompet</option>
                        <option value="Sarung Bantal">Sarung Bantal</option>
                        <option value="Selimut">Selimut</option>
                        <option value="Taplak">Taplak</option>
                        <option value="Aksesoris">Aksesoris</option>
                    </select>
                </div>
                <div>
                    <label class="block text-brandText font-semibold mb-1">Harga (Rp)</label>
                    <input type="number" name="harga" required placeholder="185000"
                           class="w-full px-4 py-2.5 rounded-2xl border border-brandPinkLight text-brandDeep focus:outline-none focus:ring-1 focus:ring-brandMauve bg-brandBg/40">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-brandText font-semibold mb-1">Jumlah Stok Unit</label>
                    <input type="number" name="stok" required placeholder="10"
                           class="w-full px-4 py-2.5 rounded-2xl border border-brandPinkLight text-brandDeep focus:outline-none focus:ring-1 focus:ring-brandMauve bg-brandBg/40">
                </div>
                <div>
                    <label class="block text-brandText font-semibold mb-1">Upload Foto Produk</label>
                    <input type="file" name="foto" class="w-full text-stone-500 file:mr-2 file:py-1 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:bg-brandPinkLight file:text-brandMauve">
                </div>
            </div>

            <div>
                <label class="block text-brandText font-semibold mb-1">Deskripsi & Perawatan Perca</label>
                <textarea name="deskripsi" rows="3" placeholder="Bahan perca katun, teknik jahit halus, ukuran..."
                          class="w-full px-4 py-2.5 rounded-2xl border border-brandPinkLight text-brandDeep bg-brandBg/40"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-brandPinkLight">
                <button type="button" @click="modalTambahProduk = false" class="px-5 py-2.5 rounded-full border border-brandPinkLight text-brandText hover:bg-brandBg">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-full bg-brandMauve text-white font-semibold hover:bg-brandDeep transition shadow-sm">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>

{{-- 2. MODAL QUICK UPDATE STOK --}}
<div x-show="modalUpdateStok" 
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-brandDeep/40 backdrop-blur-sm" 
     style="display: none;">
    <div @click.away="modalUpdateStok = false" 
         class="bg-white rounded-3xl p-6 sm:p-7 max-w-sm w-full border border-brandPinkLight shadow-2xl space-y-4">
        
        <div class="flex items-center justify-between pb-2 border-b border-brandPinkLight">
            <h4 class="font-serif font-bold text-brandDeep text-base">Update Stok Unit</h4>
            <button @click="modalUpdateStok = false" class="text-stone-400 hover:text-brandDeep">&times;</button>
        </div>

        <div class="space-y-3 text-xs">
            <p class="text-brandText">Produk: <strong class="text-brandDeep" x-text="selectedProduct.name"></strong></p>
            <div>
                <label class="block text-brandText font-semibold mb-1">Stok Saat Ini</label>
                <input type="number" x-model="selectedProduct.stock" min="0"
                       class="w-full px-4 py-2.5 rounded-2xl border border-brandPinkLight text-brandDeep focus:outline-none focus:ring-1 focus:ring-brandMauve bg-brandBg/40">
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-2 border-t border-brandPinkLight text-xs">
            <button type="button" @click="modalUpdateStok = false" class="px-4 py-2 rounded-xl border border-brandPinkLight text-brandText">Batal</button>
            <button type="button" @click="
                let p = products.find(i => i.id === selectedProduct.id);
                if (p) p.stock = selectedProduct.stock;
                modalUpdateStok = false;
            " class="px-5 py-2 rounded-xl bg-brandMauve text-white font-medium hover:bg-brandDeep">
                Perbarui
            </button>
        </div>
    </div>
</div>