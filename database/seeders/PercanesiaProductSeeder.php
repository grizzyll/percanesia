<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class PercanesiaProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Patchwork Tote Bag',
                'slug' => 'patchwork-tote-bag',
                'category' => 'Tas',
                'price' => 185000,
                'stock' => 12,
                'image' => 'images/products/patchwork-tote-bag.jpg',
                'description' => 'Tas tote cantik dari kain perca pilihan dengan motif patchwork yang unik. Dibuat dengan cinta oleh pengrajin lokal untuk gaya hidup ramah lingkungan.',
                'status' => 'Tersedia',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Canvas Perca Bag',
                'slug' => 'canvas-perca-bag',
                'category' => 'Tas',
                'price' => 165000,
                'stock' => 8,
                'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=600&q=80',
                'description' => 'Kombinasi bahan kanvas premium dan aksen perca etnik. Kuat, stylish, dan berkapasitas besar untuk menemani aktivitas harian Anda.',
                'status' => 'Tersedia',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Bucket Bag Perca',
                'slug' => 'bucket-bag-perca',
                'category' => 'Tas',
                'price' => 175000,
                'stock' => 7,
                'image' => 'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?auto=format&fit=crop&w=600&q=80',
                'description' => 'Tas model bucket dengan serutan tali katun lembut dan kombinasi motif kain perca artistik bergaya kontemporer.',
                'status' => 'Tersedia',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Dompet Perca',
                'slug' => 'dompet-perca',
                'category' => 'Dompet',
                'price' => 65000,
                'stock' => 15,
                'image' => 'images/products/dompet-perca.jpg',
                'description' => 'Dompet koin dan kartu berukuran compact dari kain perca halus dengan resleting berkualitas.',
                'status' => 'Tersedia',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Dompet Lipat Perca',
                'slug' => 'dompet-lipat-perca',
                'category' => 'Dompet',
                'price' => 75000,
                'stock' => 5,
                'image' => 'https://images.unsplash.com/photo-1544441893-675973e31985?auto=format&fit=crop&w=600&q=80',
                'description' => 'Dompet lipat dua dengan kompartemen uang kertas, kartu, dan kantong koin beresleting.',
                'status' => 'Tersedia',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Sarung Bantal Perca',
                'slug' => 'sarung-bantal-perca',
                'category' => 'Sarung Bantal',
                'price' => 75000,
                'stock' => 9,
                'image' => 'images/products/sarung-bantal-perca.jpg',
                'description' => 'Sarung bantal sofa ukuran 40x40 cm dengan motif kolase kain perca warna earthy tone yang menghangatkan ruang santai keluarga.',
                'status' => 'Tersedia',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Selimut Perca Vintage',
                'slug' => 'selimut-perca-vintage',
                'category' => 'Selimut',
                'price' => 240000,
                'stock' => 4,
                'image' => 'https://images.unsplash.com/photo-1584100936595-c0654b55a2e2?auto=format&fit=crop&w=600&q=80',
                'description' => 'Selimut patchwork quilt tebal dan lembut dengan lapisan dacron halus di bagian tengah untuk kenyamanan tidur optimal.',
                'status' => 'Tersedia',
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Taplak Meja Perca',
                'slug' => 'taplak-meja-perca',
                'category' => 'Taplak',
                'price' => 120000,
                'stock' => 6,
                'image' => 'https://images.unsplash.com/photo-1605371924599-2d0365da1ae0?auto=format&fit=crop&w=600&q=80',
                'description' => 'Taplak meja makan atau meja kopi bermotif geometris perca dengan tepian jahitan rapi yang mempercantik suasana makan.',
                'status' => 'Tersedia',
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Bros Bunga Perca',
                'slug' => 'bros-bunga-perca',
                'category' => 'Aksesoris',
                'price' => 25000,
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=600&q=80',
                'description' => 'Aksesoris bros hijab dan blazer berbentuk bunga mekar dari potongan perca katun sutra.',
                'status' => 'Tersedia',
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }
    }
}
