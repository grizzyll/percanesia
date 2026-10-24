<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AdminController extends Controller
{
    public function dashboard()
    {
        $products = Product::latest()->take(5)->get();
        $totalProducts = Product::count();
        return view('pages.admin.dashboard', compact('products', 'totalProducts'));
    }

    public function produk()
    {
        $products = Product::latest()->get();
        return view('pages.admin.produk', compact('products'));
    }

    public function pesanan()
    {
        return view('pages.admin.pesanan');
    }

    public function pesanMasuk()
    {
        return view('pages.admin.pesan-masuk');
    }

    /**
     * Menyimpan Produk Perca Baru ke Database
     */
    public function storeProduct(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:150',
            'kategori'  => 'required|string',
            'harga'     => 'required|numeric',
            'stok'      => 'required|numeric',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        // Upload Foto ke folder public/uploads/products
        $imagePath = null;
        if ($request->hasFile('foto')) {
            $imageName = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('uploads/products'), $imageName);
            $imagePath = 'uploads/products/' . $imageName;
        }

        // Simpan ke Database
        Product::create([
            'name'        => $request->nama,
            'category'    => $request->kategori,
            'price'       => $request->harga,
            'stock'       => $request->stok,
            'image'       => $imagePath,
            'description' => $request->deskripsi,
            'status'      => $request->stok > 0 ? 'Tersedia' : 'Habis',
        ]);

        return redirect()->back()->with('success', 'Produk perca baru berhasil disimpan ke database!');
    }
}