<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $products = Product::latest()->take(5)->get();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = (int) Order::where('status', '!=', Order::DIBATALKAN)->sum('total');
        $lowStockProducts = Product::where('stock', '<=', 3)->orderBy('stock', 'asc')->take(5)->get();
        $recentOrders = Order::with(['items', 'payment'])->latest()->take(5)->get();

        return view('pages.admin.dashboard', compact(
            'products',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'lowStockProducts',
            'recentOrders'
        ));
    }

    public function produk()
    {
        $products = Product::latest()->get();
        return view('pages.admin.produk', compact('products'));
    }

    public function pesanan()
    {
        $orders = Order::with(['items.product', 'payment', 'user'])->latest()->get();
        return view('pages.admin.pesanan', compact('orders'));
    }

    public function pesanMasuk()
    {
        $messages = ContactMessage::latest()->get();
        return view('pages.admin.pesan-masuk', compact('messages'));
    }

    /**
     * Menyimpan Produk Perca Baru ke Database
     */
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:150',
            'kategori'  => 'required|string|max:100',
            'harga'     => 'required|numeric|min:0',
            'stok'      => 'required|integer|min:0',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('foto')) {
            $imageName = time() . '_' . Str::slug(pathinfo($request->file('foto')->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->move(public_path('uploads/products'), $imageName);
            $imagePath = 'uploads/products/' . $imageName;
        }

        $baseSlug = Str::slug($validated['nama']);
        $slug = $baseSlug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        Product::create([
            'name'        => $validated['nama'],
            'slug'        => $slug,
            'category'    => $validated['kategori'],
            'price'       => (int) $validated['harga'],
            'stock'       => (int) $validated['stok'],
            'image'       => $imagePath,
            'description' => $validated['deskripsi'] ?? null,
            'status'      => (int) $validated['stok'] > 0 ? 'Tersedia' : 'Habis',
            'is_active'   => true,
            'is_featured' => false,
        ]);

        return redirect()->back()->with('success', 'Produk perca baru berhasil disimpan ke database!');
    }

    /**
     * Update Stok Produk Cepat
     */
    public function updateStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product->update([
            'stock'  => $validated['stock'],
            'status' => $validated['stock'] > 0 ? 'Tersedia' : 'Habis',
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'ok' => true,
                'message' => 'Stok produk berhasil diperbarui.',
                'product' => $product->fresh(),
            ]);
        }

        return redirect()->back()->with('success', 'Stok ' . $product->name . ' berhasil diperbarui.');
    }

    /**
     * Hapus Produk dari Database
     */
    public function destroyProduct(Request $request, Product $product)
    {
        $name = $product->name;
        $product->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'ok' => true,
                'message' => 'Produk ' . $name . ' berhasil dihapus.',
            ]);
        }

        return redirect()->back()->with('success', 'Produk ' . $name . ' berhasil dihapus.');
    }

    /**
     * Update Status Pesanan oleh Admin
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:' . implode(',', [
                Order::MENUNGGU_PEMBAYARAN,
                Order::MENUNGGU_VERIFIKASI,
                Order::DIPROSES,
                Order::DIBAYAR,
                Order::DIKIRIM,
                Order::SELESAI,
                Order::DIBATALKAN,
            ]),
        ]);

        $order->update(['status' => $validated['status']]);

        if ($request->wantsJson()) {
            return response()->json([
                'ok' => true,
                'message' => 'Status pesanan ' . $order->order_number . ' diperbarui.',
                'status' => $order->status,
                'status_label' => $order->status_label,
            ]);
        }

        return redirect()->back()->with('success', 'Status pesanan ' . $order->order_number . ' berhasil diperbarui.');
    }

    /**
     * Tandai Pesan Masuk Telah Dibaca
     */
    public function markMessageRead(Request $request, ContactMessage $message)
    {
        $message->update(['is_read' => true]);

        if ($request->wantsJson()) {
            return response()->json([
                'ok' => true,
                'message' => 'Pesan ditandai sudah dibaca.',
            ]);
        }

        return redirect()->back()->with('success', 'Pesan ditandai sudah dibaca.');
    }

    /**
     * Hapus Pesan Masuk
     */
    public function destroyMessage(Request $request, ContactMessage $message)
    {
        $message->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'ok' => true,
                'message' => 'Pesan berhasil dihapus.',
            ]);
        }

        return redirect()->back()->with('success', 'Pesan berhasil dihapus.');
    }
}
