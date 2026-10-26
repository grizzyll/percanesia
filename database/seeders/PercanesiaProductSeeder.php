<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

// Data contoh untuk mengetes keranjang (sama dengan desain). Jalankan:
// php artisan db:seed --class=PercanesiaProductSeeder
class PercanesiaProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Patchwork Tote Bag', 'slug' => 'patchwork-tote-bag', 'price' => 185000, 'image' => 'images/products/patchwork-tote-bag.jpg'],
            ['name' => 'Dompet Perca', 'slug' => 'dompet-perca', 'price' => 65000, 'image' => 'images/products/dompet-perca.jpg'],
            ['name' => 'Sarung Bantal Perca', 'slug' => 'sarung-bantal-perca', 'price' => 75000, 'image' => 'images/products/sarung-bantal-perca.jpg'],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['slug' => $product['slug']], $product);
        }
    }
}
