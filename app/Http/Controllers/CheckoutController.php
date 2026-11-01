<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Support\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = Cart::current();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $user = Auth::user();

        $methods = [];
        foreach (config('shop.shipping_methods') as $key => $m) {
            $methods[] = [
                'key' => $key,
                'label' => $m['label'],
                'desc' => $m['desc'],
                'cost' => (int) $m['cost'],
                'icon' => $m['icon'] ?? 'truck',
                'scope' => $m['scope'] ?? 'domestic',
                'onlyCities' => $m['only_cities'] ?? null,
            ];
        }

        return view('checkout.index', [
            'cart' => $cart,
            'payload' => [
                'csrf' => csrf_token(),
                'cartUrl' => route('cart.index'),
                'homeCountry' => config('shop.home_country'),
                'freeShippingMin' => config('shop.free_shipping_min'),
                'shippingMethods' => $methods,
                'countries' => array_keys(config('shop.countries')),
                'cities' => config('shop.cities'),
                'items' => $cart->items->map(fn ($item) => [
                    'id' => $item->id,
                    'name' => $item->product->name,
                    'variant' => $item->variant,
                    'qty' => $item->quantity,
                    'price' => (int) $item->product->price,
                    'image' => $item->product->image_url,
                    'removeUrl' => route('cart.destroy', $item->id),
                ])->values(),
                'old' => $request->old(),
                'errors' => session('errors') ? session('errors')->getBag('default')->toArray() : (object) [],
                'user' => ['name' => $user->name ?? '', 'email' => $user->email ?? ''],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $cart = Cart::current();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $isIndonesia = Shipping::isDomestic($request->input('country'));

        $data = $request->validate([
            'recipient_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'email' => ['required', 'email', 'max:150'],
            'country' => ['required', Rule::in(array_keys(config('shop.countries')))],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
            'postal_code' => $isIndonesia
                ? ['required', 'digits:5']
                : ['required', 'string', 'regex:/^[A-Za-z0-9\- ]{3,10}$/'],
            'shipping_method' => ['required', Rule::in(array_keys(config('shop.shipping_methods')))],
        ], [
            'recipient_name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.regex' => 'Nomor WhatsApp tidak valid.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'city.required' => 'Kota / kabupaten wajib diisi.',
            'postal_code.required' => 'Kode pos wajib diisi.',
            'postal_code.digits' => 'Kode pos harus 5 digit.',
            'postal_code.regex' => 'Kode pos tidak valid.',
            'shipping_method.required' => 'Pilih metode pengiriman.',
        ]);

        // metode pengiriman harus cocok dengan negara dan kota (dicek ulang di server)
        if (! Shipping::isAvailable($data['shipping_method'], $data['country'], $data['city'])) {
            return back()->withInput()->withErrors([
                'shipping_method' => 'Metode pengiriman ini tidak tersedia untuk alamat tujuanmu.',
            ]);
        }

        $subtotal = $cart->subtotal();
        $shipping = Shipping::cost($data['shipping_method'], $subtotal);
        $label = config('shop.shipping_methods.' . $data['shipping_method'] . '.label');

        $order = DB::transaction(function () use ($cart, $data, $subtotal, $shipping, $label) {
            // pesanan lama yang belum pernah masuk ke tahap bayar dibatalkan, supaya tidak menumpuk
            Order::where('user_id', Auth::id())
                ->where('status', Order::MENUNGGU_PEMBAYARAN)
                ->whereDoesntHave('payment')
                ->update(['status' => Order::DIBATALKAN]);

            $order = Order::create([
                'order_number' => Order::generateNumber(),
                'user_id' => Auth::id(),
                'recipient_name' => $data['recipient_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'city' => $data['city'],
                'country' => $data['country'],
                'postal_code' => $data['postal_code'],
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping,
                'shipping_method' => $data['shipping_method'],
                'shipping_label' => $label,
                'total' => $subtotal + $shipping,
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

            return $order;
        });

        return redirect()->route('payment.show', $order);
    }
}
