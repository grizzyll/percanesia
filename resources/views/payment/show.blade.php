@extends('layouts.percanesia')

@section('title', 'Status Pembayaran - Percanesia')

@section('content')
    <nav class="pc-breadcrumb" aria-label="Breadcrumb"><a href="{{ url('/') }}">Home</a><span>/</span><a href="{{ route('checkout.index') }}">Checkout</a><span>/</span>Pembayaran</nav>

    <div class="pc-head">
        <div>
            <h1 class="pc-title">Pembayaran</h1>
            <p class="pc-sub" id="order-sub"></p>
        </div>
        <div id="stepper" class="stepper" aria-label="Langkah pembelian"></div>
    </div>

    <div id="app" class="pc-layout"></div>
@endsection

@push('scripts')
<script>window.PC = @json($payload);</script>
<script src="{{ asset('js/payment-status.js') }}?v=3"></script>
@endpush
