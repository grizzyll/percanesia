@extends('main')

@section('title', 'Daftar Akun Baru - Percanesia')

@section('content')
<div class="bg-[#FAF7F2] text-[#2C3A3F] min-h-[85vh] flex items-center py-10 sm:py-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <div class="bg-white rounded-[2.5rem] overflow-hidden border border-[#EBE5DC] shadow-sm grid grid-cols-1 lg:grid-cols-12">
            
            {{-- KOLOM KIRI: FORMULIR REGISTER --}}
            <div class="lg:col-span-6 p-8 sm:p-12 lg:p-14 flex flex-col justify-center">
                <div class="max-w-sm w-full mx-auto space-y-6">
                    
                    <div>
                        <h1 class="text-3xl font-serif text-[#2C3A3F] font-normal">
                            Bergabung Bersama Kami
                        </h1>
                        <p class="text-xs sm:text-sm text-stone-500 font-light mt-1.5">
                            Daftarkan akun untuk melanjutkan pesanan kriya perca Anda.
                        </p>
                    </div>

                    {{-- Pesan Error Validasi --}}
                    @if ($errors->any())
                        <div class="p-3 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs space-y-1">
                            @foreach ($errors->all() as $error)
                                <p>• {{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('register.process') }}" method="POST" class="space-y-3.5 text-xs">
                        @csrf

                        <div>
                            <label class="block text-stone-600 font-medium mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Tania Syabandia"
                                   class="w-full px-4 py-2.5 rounded-xl border border-stone-300 text-stone-800 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F]">
                        </div>

                        <div>
                            <label class="block text-stone-600 font-medium mb-1">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="tania@example.com"
                                   class="w-full px-4 py-2.5 rounded-xl border border-stone-300 text-stone-800 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F]">
                        </div>

                        <div>
                            <label class="block text-stone-600 font-medium mb-1">No. WhatsApp</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx"
                                   class="w-full px-4 py-2.5 rounded-xl border border-stone-300 text-stone-800 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F]">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-stone-600 font-medium mb-1">Password</label>
                                <input type="password" name="password" required placeholder="••••••••"
                                       class="w-full px-4 py-2.5 rounded-xl border border-stone-300 text-stone-800 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F]">
                            </div>
                            <div>
                                <label class="block text-stone-600 font-medium mb-1">Konfirmasi</label>
                                <input type="password" name="password_confirmation" required placeholder="••••••••"
                                       class="w-full px-4 py-2.5 rounded-xl border border-stone-300 text-stone-800 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F]">
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center px-6 py-3.5 rounded-full bg-[#7D8F7B] text-white text-xs sm:text-sm font-medium hover:bg-[#6c7d6a] transition shadow-sm">
                                Buat Akun & Lanjut Belanja
                            </button>
                        </div>

                        <div class="text-center pt-2">
                            <p class="text-xs text-stone-500 font-light">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}" class="text-[#2C3A3F] font-semibold hover:underline">Masuk di sini</a>
                            </p>
                        </div>
                    </form>

                </div>
            </div>

            {{-- KOLOM KANAN: FOTO LIFESTYLE --}}
            <div class="hidden lg:block lg:col-span-6 relative bg-stone-100">
                <img src="https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=900&q=80" 
                     alt="Percanesia Lifestyle" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-stone-900/10"></div>
                <div class="absolute bottom-8 left-8 right-8 text-white p-5 rounded-2xl bg-black/30 backdrop-blur-sm">
                    <p class="font-serif italic text-sm">"Dukung karya kriya berkelanjutan dari tangan para pengrajin perempuan Indonesia."</p>
                    <p class="text-[11px] text-white/80 mt-1 font-light">— Percanesia Malang</p>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection