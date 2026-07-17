<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Percanesia</title>
    
    <!-- Tailwind CSS & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Google Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandBg: '#FFFFFF',         // Putih bersih
                        brandDeep: '#2D1E2F',       // Ungu gelap untuk kontras teks
                        brandMauve: '#A36B7E',      // Deep Mauve sesuai request
                        brandPink: '#E1A2B8',       // Pink menyala soft
                        brandPinkLight: '#F4E0E9',  // Pink pastel untuk elemen sekunder
                        brandText: '#5A4A42',       // Cokelat earth tone halus
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        /* Base Styling & Polkadot */
        body { 
            background-color: #FFFFFF; 
            /* Polkadot Deep Mauve yang halus */
            background-image: radial-gradient(#A36B7E 1.2px, transparent 1.2px);
            background-size: 32px 32px;
            color: #5A4A42; 
            font-family: 'Inter', sans-serif;
            letter-spacing: -0.01em; 
        }

        /* Sidebar Active State dengan warna Pink-Mauve Pop */
        .sidebar-active {
            background: linear-gradient(135deg, #E1A2B8 0%, #A36B7E 100%);
            color: white !important;
            box-shadow: 0 8px 15px -5px rgba(163, 107, 126, 0.4);
        }

        /* Efek Kaca untuk Header agar polkadot di belakang terlihat blur halus */
        .glass-header { 
            background: rgba(255, 255, 255, 0.8); 
            backdrop-filter: blur(10px); 
            border-bottom: 1px solid rgba(163, 107, 126, 0.1);
        }

        /* Custom Scrollbar Mauve */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { background: #A36B7E; border-radius: 10px; }
    </style>
</head>
<body x-data="adminDashboard()">

    <div class="flex h-screen overflow-hidden">
        <!-- SIDEBAR -->
        <aside class="w-72 bg-white/95 backdrop-blur-md border-r border-brandPinkLight text-brandText flex flex-col justify-between z-20 shadow-sm">
            <div>
                <!-- Brand Logo Area -->
                <div class="p-10 flex flex-col items-start border-b border-brandPinkLight/50">
                    <div class="w-12 h-12 rounded-2xl bg-brandDeep flex items-center justify-center shadow-lg mb-4">
                        <i class="fa-solid fa-leaf text-brandPink text-xl"></i>
                    </div>
                    <h1 class="text-xl font-semibold text-brandDeep tracking-tight">Percanesia</h1>
                    <span class="text-[10px] text-brandMauve tracking-[0.2em] font-semibold uppercase mt-1">Studio Admin</span>
                </div>

                <!-- Navigation Links -->
                <nav class="mt-6 px-6 space-y-1.5">
                    <button @click="currentTab = 'overview'" 
                        :class="currentTab === 'overview' ? 'sidebar-active' : 'hover:bg-brandPinkLight/40 text-brandText/80' " 
                        class="w-full flex items-center gap-4 px-5 py-3 rounded-xl transition-all duration-300 text-sm font-medium group">
                        <i class="fa-solid fa-chart-pie w-5"></i><span>Ringkasan</span>
                    </button>
                    
                    <button @click="currentTab = 'products'" 
                        :class="currentTab === 'products' ? 'sidebar-active' : 'hover:bg-brandPinkLight/40 text-brandText/80' " 
                        class="w-full flex items-center gap-4 px-5 py-3 rounded-xl transition-all duration-300 text-sm font-medium group">
                        <i class="fa-solid fa-boxes-stacked w-5"></i><span>Produk Katalog</span>
                    </button>
                    
                    <button @click="currentTab = 'orders'" 
                        :class="currentTab === 'orders' ? 'sidebar-active' : 'hover:bg-brandPinkLight/40 text-brandText/80' " 
                        class="w-full flex items-center gap-4 px-5 py-3 rounded-xl transition-all duration-300 text-sm font-medium group">
                        <i class="fa-solid fa-shopping-bag w-5"></i>
                        <span class="flex-grow text-left">Pesanan</span>
                        <span :class="currentTab === 'orders' ? 'bg-white/20' : 'bg-brandPink text-white'" class="text-[10px] px-2 py-0.5 rounded-lg font-bold" x-text="orders.length"></span>
                    </button>
                </nav>
            </div>

            <!-- Admin Profile Area Section -->
            <div class="p-6">
                <div class="bg-brandDeep p-4 rounded-2xl flex items-center gap-3 shadow-xl">
                    <div class="w-9 h-9 rounded-lg bg-brandPink flex items-center justify-center font-medium text-brandDeep text-sm">AD</div>
                    <div class="flex-grow min-w-0">
                        <p class="text-xs font-semibold text-white truncate tracking-tight">Admin Percanesia</p>
                        <p class="text-[9px] text-brandPink font-bold uppercase tracking-widest opacity-80">Owner Mode</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-grow flex flex-col min-w-0 overflow-y-auto">
            <!-- Header -->
            <header class="glass-header px-10 py-6 flex items-center justify-between sticky top-0 z-10">
                <div class="space-y-0.5">
                    <h2 class="text-xl font-semibold text-brandDeep tracking-tight" x-text="getTabTitle()"></h2>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-brandPink"></span>
                        <p class="text-[10px] text-brandMauve font-semibold uppercase tracking-widest">Manajemen Inventori</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="bg-white/50 border border-brandPinkLight px-4 py-1.5 rounded-xl shadow-sm">
                        <p class="text-[11px] font-medium text-brandDeep" x-text="new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })"></p>
                    </div>
                    <button class="w-10 h-10 rounded-xl bg-white border border-brandPinkLight flex items-center justify-center text-brandMauve hover:text-brandPink shadow-sm transition-all">
                        <i class="fa-regular fa-bell"></i>
                    </button>
                </div>
            </header>

            <!-- Dashboard Content Injection -->
            <div class="p-10 max-w-7xl w-full mx-auto">
                <div x-show="currentTab === 'overview'" x-transition:enter="transition duration-300">
                    @include('pages.admin.dashboard')
                </div>
                <div x-show="currentTab === 'products'" x-transition>@include('pages.admin.produk')</div>
                <div x-show="currentTab === 'orders'" x-transition>@include('pages.admin.pesanan')</div>
            </div>
        </main>
    </div>

    <!-- SCRIPT LOGIC -->
    <script>
        function adminDashboard() {
            return {
                currentTab: 'overview',
                products: [
                    { id: 1, name: "Aesthetic Eco Pouch Blue Wave", stock: 3, price: 125000 },
                    { id: 2, name: "Sustainable Tote Bag Autumn Patch", stock: 12, price: 185000 }
                ],
                orders: [{ id: 1, order_number: "PRC-001", customer: "Dewi Safitri", grand_total: 145000 }],
                totals: { sales: 4235000 },
                getTabTitle() {
                    if(this.currentTab === 'overview') return 'Dashboard Ringkasan';
                    if(this.currentTab === 'products') return 'Kelola Produk Perca';
                    return 'Daftar Pesanan Masuk';
                },
                formatRupiah(val) { return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val); },
                openQuickStockUpdate(p) { alert('Update stok: ' + p.name); }
            }
        }
    </script>
</body>
</html>