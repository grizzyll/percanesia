<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Payment;
use App\Services\MidtransService;
use App\Support\Shipping;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class PaymentController extends Controller
{
    /**
     * Satu alamat, dua tampilan:
     * - belum memilih metode (atau menekan "ganti metode") -> halaman pilih metode pembayaran
     * - sudah memilih -> halaman status (nomor VA, menunggu, berhasil, dst)
     */
    public function show(Request $request, Order $order, MidtransService $midtrans)
    {
        $this->ensureOwner($order);

        $order->load('payment');

        if ($order->payment && $order->payment->isGateway() && $order->payment->status === Payment::PENDING && $order->payment->gateway_order_id) {
            $this->syncFromGateway($order, $midtrans);
        }
        $this->expireIfNeeded($order);

        $order = $order->fresh(['items.product', 'payment']);
        $payment = $order->payment;

        if (! $payment && $order->status === Order::DIBATALKAN) {
            return redirect()->route('cart.index')->with('error', 'Pesanan itu sudah dibatalkan. Silakan checkout ulang.');
        }

        $wantsChange = $request->boolean('ganti') && $payment && $payment->status === Payment::PENDING;

        if (! $payment || $wantsChange) {
            return view('payment.select', ['payload' => $this->selectPayload($order, $midtrans)]);
        }

        return view('payment.show', ['payload' => $this->statePayload($order, $midtrans)]);
    }

    /** Pembeli menekan "Bayar Sekarang". Membuat/memperbarui data pembayaran lalu mengembalikan token Snap, atau alamat tujuan. */
    public function pay(Request $request, Order $order, MidtransService $midtrans): JsonResponse
    {
        $this->ensureOwner($order);
        $order->load('payment', 'items');

        $methods = config('shop.payment_methods');

        $data = $request->validate([
            'method' => ['required', 'in:' . implode(',', array_keys($methods))],
            'channel' => ['nullable', 'string', 'max:30'],
        ]);

        $method = $data['method'];
        $channel = $data['channel'] ?? null;
        $config = $methods[$method];
        $payment = $order->payment;

        if ($order->status === Order::DIBATALKAN || ($payment && $payment->status !== Payment::PENDING)) {
            return response()->json(['message' => 'Pesanan ini sudah tidak bisa dibayar. Silakan checkout ulang.'], 422);
        }

        if ($method === 'cod' && ! Shipping::codAvailable($order->country, $order->city)) {
            return response()->json(['message' => 'COD belum tersedia untuk alamatmu. Pilih metode pembayaran lain.'], 422);
        }

        if ($method === 'intl_transfer' && Shipping::isDomestic($order->country)) {
            return response()->json(['message' => 'Transfer internasional hanya untuk alamat di luar Indonesia.'], 422);
        }

        if ($config['channels'] && ! isset($config['channels'][$channel])) {
            return response()->json(['message' => 'Pilih salah satu pilihan pembayaran dulu.'], 422);
        }

        // ---- COD ----
        if ($config['type'] === 'cod') {
            $this->savePayment($order, $payment, [
                'method' => 'cod', 'channel' => null, 'snap_token' => null, 'gateway_order_id' => null, 'expires_at' => null,
            ]);
            $order->update(['status' => Order::DIPROSES]);
            $this->clearCart();

            return response()->json(['type' => 'redirect', 'url' => route('payment.show', $order)]);
        }

        // ---- Transfer internasional (manual, upload bukti) ----
        if ($config['type'] === 'manual') {
            $this->savePayment($order, $payment, [
                'method' => $method, 'channel' => $channel, 'snap_token' => null, 'gateway_order_id' => null,
                'expires_at' => now()->addHours((int) config('shop.intl_expiry_hours')),
            ]);
            $order->update(['status' => Order::MENUNGGU_PEMBAYARAN]);
            $this->clearCart();

            return response()->json(['type' => 'redirect', 'url' => route('payment.show', $order)]);
        }

        // ---- Lewat Midtrans (bank, e-wallet, kartu) ----
        $payment = $this->savePayment($order, $payment, [
            'method' => $method,
            'channel' => $channel,
            'expires_at' => $payment && $payment->isGateway() && $payment->expires_at
                ? $payment->expires_at
                : now()->addHours((int) config('shop.payment_expiry_hours')),
        ], false);

        $reuse = $payment->snap_token
            && $payment->getOriginal('method') === $method
            && $payment->getOriginal('channel') === $channel
            && ! $payment->isExpired();

        try {
            if (! $reuse) {
                $payment->attempt = (int) $payment->attempt + 1;
                $payment->gateway_order_id = $order->order_number . '-' . $payment->attempt;
                $minutes = max(1, (int) ceil(now()->diffInMinutes($payment->expires_at, false)));

                $snap = $midtrans->createSnapTransaction($midtrans->buildPayload(
                    $order,
                    $payment->gateway_order_id,
                    [$config['channels'][$channel]['snap']],
                    $minutes,
                    route('payment.show', $order)
                ));

                $payment->snap_token = $snap['token'];
            }

            $payment->save();
        } catch (Throwable $e) {
            Log::error('Midtrans snap token gagal', ['order' => $order->order_number, 'error' => $e->getMessage()]);

            return response()->json(['message' => 'Gagal menghubungi Midtrans. Coba lagi sebentar lagi.'], 502);
        }

        $order->update(['status' => Order::MENUNGGU_PEMBAYARAN]);
        $this->clearCart();

        return response()->json([
            'type' => 'snap',
            'token' => $payment->snap_token,
            'url' => route('payment.show', $order),
        ]);
    }

    /** Dipanggil JavaScript tiap beberapa detik di halaman status untuk melihat perubahan status */
    public function poll(Order $order, MidtransService $midtrans): JsonResponse
    {
        $this->ensureOwner($order);
        $order->load('payment');

        if ($order->payment && $order->payment->isGateway() && $order->payment->status === Payment::PENDING && $order->payment->gateway_order_id) {
            $this->syncFromGateway($order, $midtrans);
        }
        $this->expireIfNeeded($order);

        $order = $order->fresh(['items.product', 'payment']);

        return response()->json($this->statePayload($order, $midtrans)['payment']);
    }

    /** Upload bukti transfer internasional. Verifikasi dilakukan admin (di luar bagian ini). */
    public function uploadProof(Request $request, Order $order)
    {
        $this->ensureOwner($order);
        $order->load('payment');
        $this->expireIfNeeded($order);
        $payment = $order->payment?->fresh();

        if (! $payment || ! $payment->canUploadProof()) {
            return response()->json(['message' => 'Pembayaran ini sudah tidak bisa diubah.'], 422);
        }

        $request->validate([
            'proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ], [
            'proof.required' => 'Pilih file bukti transfer dulu.',
            'proof.mimes' => 'Format file harus JPG, PNG, atau PDF.',
            'proof.max' => 'Ukuran file maksimal 4 MB.',
        ]);

        $path = $request->file('proof')->store('payment-proofs', 'public');

        $payment->update(['proof_path' => $path, 'status' => Payment::MENUNGGU_VERIFIKASI]);
        $order->update(['status' => Order::MENUNGGU_VERIFIKASI]);

        return response()->json(['ok' => true]);
    }

    /**
     * Webhook dari Midtrans (isi di dashboard Midtrans: Payment Notification URL).
     * Tanpa login, keasliannya dicek lewat signature.
     */
    public function notification(Request $request, MidtransService $midtrans)
    {
        $data = $request->all();

        if (! $midtrans->isValidSignature($data)) {
            Log::warning('Midtrans notifikasi dengan signature tidak valid', ['order_id' => $data['order_id'] ?? null]);

            return response()->json(['message' => 'invalid signature'], 403);
        }

        $payment = Payment::with('order')->where('gateway_order_id', $data['order_id'])->first();

        if (! $payment) {
            return response()->json(['message' => 'payment not found'], 404);
        }

        // nominal yang dibayar harus sama dengan total order
        if ((int) round((float) $data['gross_amount']) !== (int) $payment->order->total) {
            Log::warning('Midtrans nominal tidak cocok', ['order_id' => $data['order_id']]);

            return response()->json(['message' => 'amount mismatch'], 422);
        }

        $payment->applyGatewayResult($data);

        return response()->json(['message' => 'ok']);
    }

    // ------------------------------------------------------------------ data untuk halaman

    protected function orderSummary(Order $order): array
    {
        return [
            'number' => $order->order_number,
            'recipient' => $order->recipient_name,
            'phone' => $order->phone,
            'email' => $order->email,
            'address' => $order->address,
            'city' => $order->city,
            'country' => $order->country,
            'postalCode' => $order->postal_code,
            'shippingLabel' => $order->shipping_label,
            'subtotal' => (int) $order->subtotal,
            'shipping' => (int) $order->shipping_cost,
            'total' => (int) $order->total,
            'items' => $order->items->map(fn ($i) => [
                'name' => $i->product_name,
                'variant' => $i->variant,
                'qty' => (int) $i->quantity,
                'price' => (int) $i->price,
                'subtotal' => (int) $i->subtotal,
                'image' => $i->product?->image_url,
            ])->values(),
        ];
    }

    /** Cari file logo di public/images/payments/{kunci}.(png|svg|webp|jpg). Kalau tidak ada, tampil teks. */
    protected function logo(string $key): ?string
    {
        foreach (['svg', 'png', 'webp', 'jpg'] as $ext) {
            if (file_exists(public_path("images/payments/$key.$ext"))) {
                return asset("images/payments/$key.$ext");
            }
        }

        return null;
    }

    protected function brand(string $key): array
    {
        return ['key' => $key, 'label' => config("shop.brand_labels.$key", strtoupper($key)), 'logo' => $this->logo($key)];
    }

    protected function selectPayload(Order $order, MidtransService $midtrans): array
    {
        $domestic = Shipping::isDomestic($order->country);
        $codOk = Shipping::codAvailable($order->country, $order->city);
        $methods = [];

        foreach (config('shop.payment_methods') as $key => $m) {
            $available = true;
            $note = null;

            if ($key === 'cod' && ! $codOk) {
                $available = false;
                $note = 'COD belum tersedia untuk alamatmu (' . $order->city . ').';
            }

            if ($key === 'intl_transfer' && $domestic) {
                continue; // transfer internasional hanya muncul untuk pembeli luar negeri
            }

            $channels = [];
            foreach ($m['channels'] as $ck => $c) {
                $channels[] = $this->brand($ck) + ['label' => $c['label']];
            }

            $methods[] = [
                'key' => $key,
                'type' => $m['type'],
                'label' => $m['label'],
                'desc' => $m['desc'],
                'badge' => $m['badge'] ?? null,
                'brands' => array_map(fn ($b) => $this->brand($b), $m['brands']),
                'channels' => $channels,
                'available' => $available,
                'note' => $note,
                'account' => $m['account'] ?? null,
            ];
        }

        $current = $order->payment;

        return [
            'csrf' => csrf_token(),
            'payUrl' => route('payment.pay', $order),
            'backUrl' => route('checkout.index'),
            'cartUrl' => route('cart.index'),
            'snapJs' => $midtrans->snapJsUrl(),
            'clientKey' => $midtrans->clientKey(),
            'usdRate' => (int) config('shop.usd_rate'),
            'methods' => $methods,
            'current' => $current ? ['method' => $current->method, 'channel' => $current->channel] : null,
            'order' => $this->orderSummary($order),
            'domestic' => $domestic,
        ];
    }

    protected function statePayload(Order $order, MidtransService $midtrans): array
    {
        $payment = $order->payment;

        $state = match (true) {
            $payment->status === Payment::BERHASIL => 'berhasil',
            $payment->status === Payment::GAGAL => 'gagal',
            $payment->status === Payment::KEDALUWARSA => 'kedaluwarsa',
            $payment->status === Payment::MENUNGGU_VERIFIKASI => 'verifikasi',
            $payment->isCod() => 'cod',
            $payment->isManual() => 'manual',
            default => 'menunggu',
        };

        $methodConf = config("shop.payment_methods.{$payment->method}", []);
        $channelLabel = $methodConf['channels'][$payment->channel]['label'] ?? null;

        return [
            'csrf' => csrf_token(),
            'urls' => [
                'poll' => route('payment.poll', $order),
                'pay' => route('payment.pay', $order),
                'proof' => route('payment.proof', $order),
                'change' => route('payment.show', ['order' => $order, 'ganti' => 1]),
                'shop' => url('/shop'),
                'cart' => route('cart.index'),
            ],
            'snapJs' => $midtrans->snapJsUrl(),
            'clientKey' => $midtrans->clientKey(),
            'usdRate' => (int) config('shop.usd_rate'),
            'order' => $this->orderSummary($order),
            'payment' => [
                'state' => $state,
                'method' => $payment->method,
                'methodLabel' => $methodConf['label'] ?? $payment->method,
                'channel' => $payment->channel,
                'channelLabel' => $channelLabel,
                'amount' => (int) $payment->amount,
                'expiresAt' => $payment->expires_at?->toIso8601String(),
                'paidAt' => $payment->paid_at?->toIso8601String(),
                'info' => $payment->payment_info,
                'paymentType' => $payment->gateway_payment_type,
                'hasProof' => (bool) $payment->proof_path,
                'account' => $payment->isManual() ? ($methodConf['account'] ?? null) : null,
                'canChange' => $payment->status === Payment::PENDING && ! $payment->isCod(),
            ],
        ];
    }

    // ------------------------------------------------------------------ pembantu

    protected function ensureOwner(Order $order): void
    {
        abort_unless($order->user_id === Auth::id(), 403);
    }

    /** Buat atau perbarui baris payment milik order. $save=false hanya mengisi atribut tanpa menyimpan. */
    protected function savePayment(Order $order, ?Payment $payment, array $attributes, bool $save = true): Payment
    {
        $payment = $payment ?? new Payment([
            'order_id' => $order->id,
            'attempt' => 0,
            'status' => Payment::PENDING,
        ]);

        $payment->fill($attributes + ['amount' => $order->total, 'status' => Payment::PENDING]);

        if ($save) {
            $payment->save();
        }

        return $payment;
    }

    protected function clearCart(): void
    {
        CartItem::where('cart_id', Cart::current()->id)->delete();
    }

    protected function syncFromGateway(Order $order, MidtransService $midtrans): void
    {
        try {
            $data = $midtrans->getStatus($order->payment->gateway_order_id);

            if ($data) {
                $order->payment->applyGatewayResult($data);
            }
        } catch (Throwable $e) {
            // gagal cek status bukan masalah besar, status akan masuk lewat webhook
            Log::warning('Midtrans cek status gagal', ['order' => $order->order_number, 'error' => $e->getMessage()]);
        }
    }

    /** Lewat batas waktu dan belum dibayar: tandai kedaluwarsa */
    protected function expireIfNeeded(Order $order): void
    {
        $payment = $order->payment?->fresh();

        if ($payment && $payment->status === Payment::PENDING && $payment->isExpired()) {
            $payment->update(['status' => Payment::KEDALUWARSA]);
            $order->update(['status' => Order::DIBATALKAN]);
        }
    }
}
