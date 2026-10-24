<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - Percanesia Studio')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Alpine.js CDN (Wajib agar x-text, x-for, dan fungsi klik berjalan) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Definisi Warna Pink & Mauve Pasti Muncul Tanpa Bergantung Cache Vite -->
    <style>
        .bg-brandBg { background-color: #FDF8F9 !important; }
        .bg-brandPinkLight { background-color: #FCE7EC !important; }
        .bg-brandPinkLight\/60 { background-color: rgba(252, 231, 236, 0.6) !important; }
        .border-brandPinkLight { border-color: #FCE7EC !important; }
        .border-brandPinkLight\/30 { border-color: rgba(252, 231, 236, 0.3) !important; }
        .border-brandPinkLight\/40 { border-color: rgba(252, 231, 236, 0.4) !important; }
        .border-brandPinkLight\/50 { border-color: rgba(252, 231, 236, 0.5) !important; }
        .border-brandPinkLight\/20 { border-color: rgba(252, 231, 236, 0.2) !important; }
        .text-brandMauve { color: #B86B7F !important; }
        .bg-brandMauve { background-color: #B86B7F !important; }
        .text-brandDeep { color: #2D1F25 !important; }
        .text-brandText { color: #5A4950 !important; }
    </style>
</head>
<body class="bg-brandBg text-brandText font-sans antialiased min-h-screen flex"
      x-data="{
          modalTambahProduk: false,
          modalUpdateStok: false,
          selectedProduct: { id: null, name: '', stock: 0 },
          totals: {
              sales: 5420000,
          },
          orders: [
              { id: 1, order_number: '#PCN-1201', customer: 'Tania Syabandia', item: 'Patchwork Tote Bag (1x)', grand_total: 200000, status: 'Diproses', date: '18 Okt 2025' },
              { id: 2, order_number: '#PCN-1202', customer: 'Sarah Miller', item: 'Bawana Quilt (1x)', grand_total: 695000, status: 'Dikirim', date: '17 Okt 2025' },
              { id: 3, order_number: '#PCN-1203', customer: 'Budi Santoso', item: 'Dompet Perca (2x)', grand_total: 145000, status: 'Selesai', date: '16 Okt 2025' }
          ],
          products: [
              { id: 1, name: 'Patchwork Tote Bag', category: 'Tas', price: 185000, stock: 3, img: 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=200&q=80' },
              { id: 2, name: 'Dompet Perca Lipat', category: 'Dompet', price: 75000, stock: 2, img: 'https://images.unsplash.com/photo-1544441893-675973e31985?auto=format&fit=crop&w=200&q=80' },
              { id: 3, name: 'Sarung Bantal Perca', category: 'Sarung Bantal', price: 75000, stock: 1, img: 'https://images.unsplash.com/photo-1579656381226-5fc0f0100c3b?auto=format&fit=crop&w=200&q=80' },
              { id: 4, name: 'Selimut Perca Vintage', category: 'Selimut', price: 240000, stock: 5, img: 'https://images.unsplash.com/photo-1584100936595-c0654b55a2e2?auto=format&fit=crop&w=200&q=80' }
          ],
          formatRupiah(num) {
              return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
          },
          openQuickStockUpdate(product) {
              this.selectedProduct = Object.assign({}, product);
              this.modalUpdateStok = true;
          }
      }">

    {{-- SIDEBAR ADMIN --}}
    @include('components.sidebar')

    {{-- KONTEN UTAMA --}}
    <main class="flex-1 p-6 sm:p-10 overflow-y-auto">
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @yield('admin-content')
    </main>

    {{-- MODAL POPUP --}}
    @include('pages.admin.modals')

</body>
</html>