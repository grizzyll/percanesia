<!-- KONTEN TAB: PESAN & KONTAK MASUK -->
<div class="space-y-6" x-data="messageManager()">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white/90 backdrop-blur-md p-6 rounded-3xl border border-brandPinkLight shadow-sm">
        <div>
            <h3 class="text-lg font-bold text-brandDeep">Pesan & Pertanyaan Pelanggan</h3>
            <p class="text-xs text-brandMauve mt-0.5">Daftar pesan masuk dari formulir kontak website Percanesia.</p>
        </div>
        <span class="px-3 py-1.5 rounded-xl bg-brandPinkLight text-brandDeep text-xs font-semibold w-fit">
            Total: <span x-text="messages.length"></span> Pesan
        </span>
    </div>

    <!-- Tabel Daftar Pesan -->
    <div class="bg-white/90 backdrop-blur-md rounded-3xl border border-brandPinkLight shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-brandPinkLight/30 text-brandMauve border-b border-brandPinkLight/50">
                        <th class="py-4 px-6 font-semibold">Pengirim</th>
                        <th class="py-4 px-6 font-semibold">Email / Kontak</th>
                        <th class="py-4 px-6 font-semibold">Pesan</th>
                        <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brandPinkLight/20">
                    <template x-for="msg in messages" :key="msg.id">
                        <tr class="hover:bg-brandPinkLight/10 transition-colors">
                            <td class="py-4 px-6 font-bold text-brandDeep" x-text="msg.name"></td>
                            <td class="py-4 px-6 font-medium text-brandText" x-text="msg.contact"></td>
                            <td class="py-4 px-6 text-brandText truncate max-w-xs" x-text="msg.content"></td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a :href="'https://wa.me/' + msg.phone" target="_blank" class="px-3 py-1.5 rounded-xl bg-green-50 text-green-700 font-medium hover:bg-green-600 hover:text-white transition-all inline-flex items-center gap-1">
                                    <i class="fa-brands fa-whatsapp"></i> Balas
                                </a>
                                <button @click="deleteMessage(msg.id)" class="px-3 py-1.5 rounded-xl bg-red-50 text-red-500 font-medium hover:bg-red-500 hover:text-white transition-all">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function messageManager() {
        return {
            messages: [
                { id: 1, name: "Rian Pratama", contact: "rian@example.com", phone: "628123456789", content: "Halo, apakah tas perca model patch bisa custom ukuran khusus?" },
                { id: 2, name: "Siti Aminah", contact: "siti@example.com", phone: "628987654321", content: "Mau tanya stok pouch sustainable warna biru apakah masih ada?" }
            ],
            deleteMessage(id) {
                if(confirm('Hapus pesan ini?')) {
                    this.messages = this.messages.filter(m => m.id !== id);
                }
            }
        }
    }
</script>