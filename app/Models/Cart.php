<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Cart extends Model
{
    protected $fillable = ['user_id', 'token'];

    public function items()
    {
        return $this->hasMany(CartItem::class)->with('product')->orderBy('id');
    }

    /**
     * Keranjang aktif.
     * - Sudah login: keranjang milik user (keranjang tamu otomatis digabung).
     * - Belum login: keranjang yang diikat ke token di session.
     */
    public static function current(): self
    {
        $token = session('cart_token');
        if (! $token) {
            $token = Str::random(40);
            session(['cart_token' => $token]);
        }

        $guestCart = static::where('token', $token)->first();

        if (Auth::check()) {
            $userCart = static::firstOrCreate(['user_id' => Auth::id()]);

            if ($guestCart && $guestCart->id !== $userCart->id) {
                $userCart->absorb($guestCart);
            }

            return $userCart;
        }

        return $guestCart ?? static::create(['token' => $token]);
    }

    /** Pindahkan isi keranjang tamu ke keranjang ini, lalu hapus keranjang tamu. */
    protected function absorb(Cart $guest): void
    {
        foreach ($guest->items as $item) {
            $mine = $this->items()->firstOrNew([
                'product_id' => $item->product_id,
                'variant' => $item->variant,
            ]);
            $mine->quantity = min(99, ($mine->exists ? $mine->quantity : 0) + $item->quantity);
            $mine->save();
        }

        $guest->delete();
    }

    public function itemCount(): int
    {
        return (int) $this->items->sum('quantity');
    }

    public function subtotal(): int
    {
        return (int) $this->items->sum(fn (CartItem $item) => $item->subtotal);
    }

    public function shippingCost(): int
    {
        $subtotal = $this->subtotal();
        $freeMin = config('shop.free_shipping_min');

        if ($subtotal === 0) {
            return 0;
        }

        if ($freeMin !== null && $subtotal >= $freeMin) {
            return 0;
        }

        return (int) config('shop.shipping_cost');
    }

    public function total(): int
    {
        return $this->subtotal() + $this->shippingCost();
    }
}
