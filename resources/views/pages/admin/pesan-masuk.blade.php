<div class="bg-white rounded-2xl border border-brandLightSage/20 shadow-sm overflow-hidden">
    <div class="divide-y divide-brandLightSage/10">
        <template x-for="message in messages">
            <div class="p-6 flex gap-4 hover:bg-brandOffWhite/10">
                <div class="w-10 h-10 rounded-full bg-brandPink/30 flex items-center justify-center text-brandDarkGreen text-lg flex-shrink-0"><i class="fa-solid fa-envelope"></i></div>
                <div class="flex-grow">
                    <div class="flex justify-between">
                        <div>
                            <h5 class="font-bold text-brandDarkGreen" x-text="message.name"></h5>
                            <p class="text-xs text-brandSage" x-text="message.email"></p>
                        </div>
                        <span class="text-xs text-brandSage" x-text="message.date"></span>
                    </div>
                    <p class="text-brandDarkGreen text-sm mt-2 font-semibold" x-text="'Subjek: ' + message.subject"></p>
                    <p class="text-brandDarkGreen/80 text-sm mt-1" x-text="message.message"></p>
                    <div class="mt-3">
                        <a :href="'https://wa.me/' + message.phone" target="_blank" class="text-xs bg-[#25D366] text-white px-3 py-1.5 rounded-lg font-bold inline-flex items-center gap-1.5 hover:opacity-95"><i class="fa-brands fa-whatsapp"></i>Balas via WhatsApp</a>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>