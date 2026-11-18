<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    /**
     * Menampilkan Halaman Katalog dengan Filter & Sorting Database
     */
    public function index(Request $request)
    {
        $query = Product::query()->where('is_active', true);

        // Filter berdasarkan kategori jika dipilih
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $categoryMap = [
                'tas' => 'Tas',
                'dompet' => 'Dompet',
                'sarung-bantal' => 'Sarung Bantal',
                'selimut' => 'Selimut',
                'taplak' => 'Taplak',
                'aksesoris' => 'Aksesoris',
            ];

            $categoryName = $categoryMap[$request->kategori] ?? str_replace('-', ' ', $request->kategori);
            $query->where('category', 'like', '%' . $categoryName . '%');
        }

        // Pencarian jika ada query q
        if ($request->filled('q')) {
            $searchTerm = trim($request->q);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('category', 'like', '%' . $searchTerm . '%');
            });
        }

        // Sorting
        $sort = $request->get('sort', 'terbaru');
        switch ($sort) {
            case 'termurah':
                $query->orderBy('price', 'asc');
                break;
            case 'termahal':
                $query->orderBy('price', 'desc');
                break;
            case 'terpopuler':
                $query->orderByDesc('is_featured')->latest();
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(9)->withQueryString();

        return view('pages.katalog.index', compact('products'));
    }

    /**
     * Menampilkan Halaman Detail Produk Berdasarkan ID Database
     */
    public function detail($id)
    {
        $product = Product::where('is_active', true)->findOrFail($id);

        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where('category', $product->category)
            ->take(4)
            ->get();

        if ($relatedProducts->isEmpty()) {
            $relatedProducts = Product::where('is_active', true)
                ->where('id', '!=', $product->id)
                ->take(4)
                ->get();
        }

        return view('pages.katalog.detail', compact('product', 'relatedProducts'));
    }
}
