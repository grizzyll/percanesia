@extends('main')

@section('title', 'Tentang Kami - Percanesia')

@section('content')
<div class="bg-[#FAF7F2] text-[#2C3A3F] min-h-screen py-8 sm:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- 1. BREADCRUMB --}}
        <nav class="text-xs text-stone-500 mb-8 flex items-center space-x-2">
            <a href="{{ route('home') }}" class="hover:text-[#2C3A3F]">Home</a>
            <span>/</span>
            <span class="text-[#2C3A3F] font-medium">About Us</span>
        </nav>

        {{-- 2. HERO STORY SECTION --}}
        <section class="max-w-3xl mx-auto text-center space-y-5 mb-16 sm:mb-20">
            <span class="text-xs uppercase tracking-widest font-semibold text-[#C07A65]">
                Kisah & Filosofi Percanesia
            </span>
            <h1 class="text-3xl sm:text-5xl font-serif font-normal leading-[1.2] text-[#2C3A3F]">
                Menghidupkan Cerita di Balik Setiap Potongan Kain Perca
            </h1>
            <p class="text-sm sm:text-base text-stone-600 font-light leading-relaxed">
                Percanesia lahir di Malang dari sebuah kepedulian sederhana: mengapa sisa kain berkualitas harus berakhir mencemari bumi jika bisa dirangkai menjadi karya seni fungsional yang bernilai abadi?
            </p>
        </section>

        {{-- 3. FOTO UTAMA & CERITA PERJALANAN --}}
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center mb-20">
            <div class="lg:col-span-6">
                <div class="aspect-[4/3] rounded-[2.5rem] overflow-hidden shadow-sm bg-stone-200 border border-[#EBE5DC]">
                    <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?auto=format&fit=crop&w=1000&q=80" 
                         alt="Proses Jahit Kain Perca" 
                         class="w-full h-full object-cover">
                </div>
            </div>

            <div class="lg:col-span-6 space-y-5">
                <span class="text-xs uppercase tracking-widest font-semibold text-[#879685]">
                    Dari Limbah Menjadi Berkah
                </span>
                <h2 class="text-2xl sm:text-3xl font-serif font-normal text-[#2C3A3F]">
                    Bukan Sekadar Daur Ulang, Tapi Menenun Harapan
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 font-light leading-relaxed">
                    Setiap tahunnya, industri garmen menghasilkan ribuan ton potongan kain sisa (*pre-consumer textile waste*). Di studio kami di Malang, kami mengumpulkan kain-kain pilihan tersebut, membersihkannya secara higienis, dan memotongnya menjadi pola geometris presisi.
                </p>
                <p class="text-xs sm:text-sm text-stone-600 font-light leading-relaxed">
                    Bagi kami, kain perca bukan sampah. Setiap warna, tekstur, dan serat kain memiliki kepribadian unik yang ketika disatukan akan melahirkan produk kriya eksklusif yang tiada duanya di dunia.
                </p>
            </div>
        </section>

        {{-- 4. MISI PEMBERDAYAAN PEREMPUAN LOKAL (MALANG) --}}
        <section class="bg-white rounded-3xl p-8 sm:p-12 border border-[#EBE5DC] shadow-sm mb-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-7 space-y-4">
                    <span class="text-xs uppercase tracking-widest font-semibold text-[#C07A65]">
                        Pemberdayaan Komunitas
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-serif font-normal text-[#2C3A3F]">
                        Tangan Terampil Para Ibu di Malang
                    </h2>
                    <p class="text-xs sm:text-sm text-stone-600 font-light leading-relaxed">
                        Misi utama Percanesia adalah kemandirian ekonomi perempuan lokal. Kami bekerja sama dengan para ibu rumah tangga di pedesaan Malang, memberikan pelatihan teknik jahit halus berstandar ekspor, serta menerapkan sistem upah adil (*fair trade*).
                    </p>
                    <p class="text-xs sm:text-sm text-stone-600 font-light leading-relaxed">
                        Dengan jam kerja yang fleksibel, para ibu dapat tetap menjaga kehangatan keluarganya sambil berkarya dan memperoleh penghasilan mandiri yang membanggakan.
                    </p>
                </div>

                {{-- Quote Box --}}
                <div class="lg:col-span-5 bg-[#FAF7F2] p-6 sm:p-8 rounded-2xl border border-[#EBE5DC] text-center sm:text-left">
                    <p class="text-sm font-serif italic text-[#2C3A3F] leading-relaxed">
                        "Menjahit perca bagi saya bukan sekadar pekerjaan harian, tapi cara saya menghidupkan seni tradisi dan mandiri secara ekonomi untuk pendidikan anak-anak saya."
                    </p>
                    <div class="mt-4 pt-3 border-t border-[#EBE5DC]">
                        <p class="text-xs font-semibold text-[#2C3A3F]">Ibu Siti Rohmah</p>
                        <p class="text-[11px] text-stone-500">Ketua Kelompok Pengrajin Percanesia Malang</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 5. EDUKASI SENI TEKSTIL BERKELANJUTAN (3 PILAR PROSES) --}}
        <section class="mb-20">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs uppercase tracking-widest font-semibold text-[#879685]">Standar Pengerjaan</span>
                <h2 class="text-2xl sm:text-3xl font-serif font-normal text-[#2C3A3F] mt-1">
                    Proses Kriya Percanesia
                </h2>
                <p class="text-xs sm:text-sm text-stone-500 mt-2 font-light">Setiap langkah pengerjaan dirancang untuk menjaga mutu dan kelestarian alam.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                {{-- Step 1 --}}
                <div class="bg-white p-7 rounded-3xl border border-[#EBE5DC] shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-[#FAF7F2] text-[#2C3A3F] font-serif font-bold flex items-center justify-center mb-5 border border-[#EBE5DC]">
                        01
                    </div>
                    <h3 class="text-base font-serif font-medium text-[#2C3A3F] mb-2">Kurasi & Pencucian Higienis</h3>
                    <p class="text-xs text-stone-600 font-light leading-relaxed">
                        Kain perca katun dan linen dipilah berdasarkan gramasi, dicuci dengan sabun alami ramah lingkungan, dan disetrika uap steril sebelum dipotong.
                    </p>
                </div>

                {{-- Step 2 --}}
                <div class="bg-white p-7 rounded-3xl border border-[#EBE5DC] shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-[#FAF7F2] text-[#2C3A3F] font-serif font-bold flex items-center justify-center mb-5 border border-[#EBE5DC]">
                        02
                    </div>
                    <h3 class="text-base font-serif font-medium text-[#2C3A3F] mb-2">Desain Pola & Harmoni Warna</h3>
                    <p class="text-xs text-stone-600 font-light leading-relaxed">
                        Potongan perca disusun manual menggunakan paduan warna bumi (*earth tone*) agar menghasilkan komposisi estetika kontemporer yang elegan.
                    </p>
                </div>

                {{-- Step 3 --}}
                <div class="bg-white p-7 rounded-3xl border border-[#EBE5DC] shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-[#FAF7F2] text-[#2C3A3F] font-serif font-bold flex items-center justify-center mb-5 border border-[#EBE5DC]">
                        03
                    </div>
                    <h3 class="text-base font-serif font-medium text-[#2C3A3F] mb-2">Jahitan Ganda Kuat & Awet</h3>
                    <p class="text-xs text-stone-600 font-light leading-relaxed">
                        Setiap sambungan diperkuat jahitan ganda halus serta furing dalam yang tebal sehingga produk dapat digunakan bertahun-tahun tanpa mudah sobek.
                    </p>
                </div>
            </div>
        </section>

        {{-- 6. METRIK DAMPAK / IMPACT IN NUMBERS --}}
        <section class="bg-[#4F6774] text-white rounded-3xl p-8 sm:p-12 shadow-sm text-center mb-16">
            <h2 class="text-2xl sm:text-3xl font-serif font-normal mb-8">Dampak Nyata Bersama Anda</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                <div>
                    <p class="text-3xl sm:text-4xl font-serif font-semibold">1.400+ Kg</p>
                    <p class="text-xs sm:text-sm text-white/80 mt-1 font-light">Limbah Tekstil Diselamatkan dari TPA</p>
                </div>
                <div>
                    <p class="text-3xl sm:text-4xl font-serif font-semibold">35+ Orang</p>
                    <p class="text-xs sm:text-sm text-white/80 mt-1 font-light">Ibu Pengrajin Lokal Diberdayakan</p>
                </div>
                <div>
                    <p class="text-3xl sm:text-4xl font-serif font-semibold">14+ Negara</p>
                    <p class="text-xs sm:text-sm text-white/80 mt-1 font-light">Tujuan Ekspor Kriya Indonesia</p>
                </div>
            </div>

            <div class="pt-10">
                <a href="{{ url('/katalog') }}" class="inline-block px-8 py-3 rounded-full bg-white text-[#4F6774] text-xs sm:text-sm font-semibold hover:bg-stone-100 transition shadow-sm">
                    Jelajahi Koleksi Kami &rarr;
                </a>
            </div>
        </section>

    </div>
</div>
@endsection