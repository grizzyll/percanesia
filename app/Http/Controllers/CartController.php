<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::current();

        return view('cart.index', compact('cart'));
    }

    /** Dipanggil dari halaman produk / shop: POST product_id, quantity, variant */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
            'variant' => ['nullable', 'string', 'max:100'],
        ]);

        $product = Product::where('is_active', true)->findOrFail($data['product_id']);

        $item = Cart::current()->items()->firstOrNew([
            'product_id' => $product->id,
            'variant' => $data['variant'] ?? null,
        ]);

        $item->quantity = min(99, ($item->exists ? $item->quantity : 0) + ($data['quantity'] ?? 1));
        $item->save();

        return redirect()->route('cart.index')->with('success', $product->name . ' masuk ke keranjang.');
    }

    public function update(Request $request, int $item)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        // cari lewat keranjang aktif supaya tidak bisa mengubah item milik orang lain
        $cartItem = Cart::current()->items()->findOrFail($item);
        $cartItem->update(['quantity' => $data['quantity']]);

        return redirect()->route('cart.index');
    }

    public function destroy(int $item)
    {
        $cartItem = Cart::current()->items()->findOrFail($item);
        $name = $cartItem->product->name;
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', $name . ' dihapus dari keranjang.');
    }
}
