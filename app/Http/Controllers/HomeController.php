<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan Halaman Home Percanesia dengan Produk Unggulan Riil
     */
    public function index()
    {
        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(4)
            ->get();

        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::where('is_active', true)
                ->latest()
                ->take(4)
                ->get();
        }

        return view('pages.home.index', compact('featuredProducts'));
    }
}
