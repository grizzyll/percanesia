@extends('main')

@section('title', 'Masuk - Percanesia')

@section('content')
<div class="bg-[#FAF7F2] text-[#2C3A3F] min-h-[85vh] flex items-center py-10 sm:py-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <div class="bg-white rounded-[2.5rem] overflow-hidden border border-[#EBE5DC] shadow-sm grid grid-cols-1 lg:grid-cols-12">
            
            <div class="lg:col-span-6 p-8 sm:p-12 lg:p-14 flex flex-col justify-center">
                <div class="max-w-sm w-full mx-auto space-y-6">
                    
                    <div>
                        <h1 class="text-3xl font-serif text-[#2C3A3F] font-normal">
                            Welcome Back!
                        </h1>
                        <p class="text-xs sm:text-sm text-stone-500 font-light mt-1.5">
                            Masuk untuk melanjutkan pesanan Anda.
                        </p>
                    </div>

                    {{-- Pesan Notifikasi (Misal diarahkan dari Checkout) --}}
                    @if(session('info'))
                        <div class="p-3 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs">
                            {{ session('info') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="p-3 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('login.process') }}" method="POST" class="space-y-4 text-xs">
                        @csrf

                        <div>
                            <label class="block text-stone-600 font-medium mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@mail.com"
                                   class="w-full px-4 py-3 rounded-xl border border-stone-300 text-stone-800 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F]">
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-stone-600 font-medium">Password</label>
                            </div>
                            <input type="password" name="password" required placeholder="••••••••"
                                   class="w-full px-4 py-3 rounded-xl border border-stone-300 text-stone-800 focus:outline-none focus:ring-1 focus:ring-[#2C3A3F]">
                        </div>

                        <div class="flex items-center gap-2 pt-1">
                            <input type="checkbox" id="remember" name="remember" class="rounded border-stone-300 text-[#7D8F7B] focus:ring-0">
                            <label for="remember" class="text-stone-500 cursor-pointer">Ingat saya</label>
                        </div>

                        <div class="pt-2">
                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center px-6 py-3.5 rounded-full bg-[#7D8F7B] text-white text-xs sm:text-sm font-medium hover:bg-[#6c7d6a] transition shadow-sm">
                                Masuk
                            </button>
                        </div>

                        <div class="text-center pt-3">
                            <p class="text-xs text-stone-500 font-light">
                                Belum punya akun? 
                                <a href="{{ route('register') }}" class="text-[#2C3A3F] font-semibold hover:underline">Daftar di sini</a>
                            </p>
                        </div>
                    </form>

                </div>
            </div>

            <div class="hidden lg:block lg:col-span-6 relative bg-stone-100">
                <img src="https://images.unsplash.com/photo-1584100936595-c0654b55a2e2?auto=format&fit=crop&w=900&q=80" 
                     alt="Percanesia Bedding Decor" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-stone-900/10"></div>
            </div>

        </div>

    </div>
</div>
@endsection