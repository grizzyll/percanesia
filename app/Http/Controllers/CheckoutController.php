<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::current();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        return view('checkout.index', [
            'cart' => $cart,
            'methods' => config('shop.payment_methods'),
            'user' => Auth::user(),
        ]);
    }

    public function store(Request $request)
    {
        $cart = Cart::current();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $data = $request->validate([
            'recipient_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'regex:/^[0-9+\-\s]{9,20}$/'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'digits:5'],
            'note' => ['nullable', 'string', 'max:300'],
            'payment_method' => ['required', 'in:' . implode(',', array_keys(config('shop.payment_methods')))],
        ], [
            'phone.regex' => 'Nomor telepon tidak valid.',
            'postal_code.digits' => 'Kode pos harus 5 digit.',
            'payment_method.required' => 'Pilih metode pembayaran dulu.',
        ]);

        // total dihitung ulang di server, tidak percaya angka dari form
        $order = DB::transaction(function () use ($cart, $data) {
            $order = Order::create([
                'order_number' => Order::generateNumber(),
                'user_id' => Auth::id(),
                'recipient_name' => $data['recipient_name'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'city' => $data['city'],
                'postal_code' => $data['postal_code'],
                'note' => $data['note'] ?? null,
                'subtotal' => $cart->subtotal(),
                'shipping_cost' => $cart->shippingCost(),
                'total' => $cart->total(),
                'status' => Order::MENUNGGU_PEMBAYARAN,
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'variant' => $item->variant,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ]);
            }

            $order->payment()->create([
                'method' => $data['payment_method'],
                'amount' => $order->total,
                'status' => Payment::PENDING,
                'expires_at' => now()->addHours((int) config('shop.payment_expiry_hours')),
            ]);

            CartItem::where('cart_id', $cart->id)->delete();

            return $order;
        });

        return redirect()->route('payment.show', $order);
    }
}
