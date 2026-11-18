@extends('layouts.percanesia')

@section('title', 'Pembayaran - Percanesia')

@section('content')
    {{-- Breadcrumb navigasi toko --}}
    <nav class="text-xs text-stone-500 mb-6 flex items-center space-x-2" aria-label="Breadcrumb">
        <a href="{{ url('/') }}" class="hover:text-[#2C3A3F]">Home</a>
        <span>/</span>
        <a href="{{ route('checkout.index') }}" class="hover:text-[#2C3A3F]">Checkout</a>
        <span>/</span>
        <span class="text-[#2C3A3F] font-medium">Pembayaran</span>
    </nav>

    {{-- Header halaman --}}
    <div class="pc-head mb-8">
        <div>
            <h1 class="text-3xl sm:text-4xl font-serif text-[#2C3A3F] font-normal">Pembayaran</h1>
            <p class="text-xs sm:text-sm text-stone-600 font-light mt-1">Pilih metode pembayaran yang kamu inginkan.</p>
        </div>
        <div id="stepper" class="stepper stepper--sage" aria-label="Langkah pembelian"></div>
    </div>

    <div id="app" class="pc-layout"></div>
@endsection

@push('scripts')
<script>window.PC = @json($payload);</script>
<script src="{{ asset('js/payment-select.js') }}?v=4"></script>
@endpush
