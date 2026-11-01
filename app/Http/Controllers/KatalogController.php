<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class KatalogController extends Controller
{
    /**
     * Menampilkan Halaman Katalog dengan Filter Database
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter berdasarkan kategori jika dipilih
        if ($request->has('kategori') && $request->kategori != 'semua') {
            $query->where('category', 'like', '%' . $request->kategori . '%');
        }

        // Pencarian jika ada query q
        if ($request->has('q') && !empty($request->q)) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $products = $query->latest()->get();

        return view('pages.katalog.index', compact('products'));
    }

    /**
     * Menampilkan Halaman Detail Produk Berdasarkan ID Database
     */
    public function detail($id)
    {
        $product = Product::findOrFail($id);
        return view('pages.katalog.detail', compact('product'));
    }
}