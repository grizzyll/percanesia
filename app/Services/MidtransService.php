<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Pembungkus API Midtrans (Snap). Memakai HTTP client bawaan Laravel,
 * jadi tidak perlu install package tambahan.
 */
class MidtransService
{
    public function serverKey(): string
    {
        $key = (string) config('midtrans.server_key');
        if ($key === '') {
            throw new RuntimeException('MIDTRANS_SERVER_KEY belum diisi di file .env');
        }

        return $key;
    }

    public function clientKey(): string
    {
        return (string) config('midtrans.client_key');
    }

    public function isProduction(): bool
    {
        return (bool) config('midtrans.is_production');
    }

    public function snapJsUrl(): string
    {
        return $this->isProduction()
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    }

    protected function snapBaseUrl(): string
    {
        return $this->isProduction()
            ? 'https://app.midtrans.com/snap/v1'
            : 'https://app.sandbox.midtrans.com/snap/v1';
    }

    protected function apiBaseUrl(): string
    {
        return $this->isProduction()
            ? 'https://api.midtrans.com/v2'
            : 'https://api.sandbox.midtrans.com/v2';
    }

    protected function client()
    {
        return Http::withBasicAuth($this->serverKey(), '')
            ->acceptJson()
            ->asJson()
            ->timeout(20);
    }

    /**
     * Bentuk payload Snap dari data order. Total item harus sama persis dengan gross_amount.
     *
     * @param  string  $gatewayOrderId  order_id di sisi Midtrans (nomor order + percobaan ke-n)
     * @param  array   $enabledPayments contoh ['bca_va'], supaya popup hanya menampilkan metode pilihan pembeli
     */
    public function buildPayload(Order $order, string $gatewayOrderId, array $enabledPayments, ?int $expiryMinutes, string $finishUrl): array
    {
        $order->loadMissing('items');

        $items = [];
        foreach ($order->items as $item) {
            $items[] = [
                'id' => (string) ($item->product_id ?? 'P' . $item->id),
                'price' => (int) $item->price,
                'quantity' => (int) $item->quantity,
                'name' => mb_substr($item->product_name . ($item->variant ? ' - ' . $item->variant : ''), 0, 50),
            ];
        }

        if ((int) $order->shipping_cost > 0) {
            $items[] = ['id' => 'ONGKIR', 'price' => (int) $order->shipping_cost, 'quantity' => 1, 'name' => mb_substr('Ongkir ' . ($order->shipping_label ?: ''), 0, 50)];
        }

        $countryCode = config('shop.countries.' . $order->country, 'IDN');

        $address = [
            'first_name' => mb_substr($order->recipient_name, 0, 50),
            'phone' => $order->phone,
            'address' => mb_substr($order->address, 0, 200),
            'city' => $order->city,
            'postal_code' => $order->postal_code,
            'country_code' => $countryCode,
        ];

        $payload = [
            'transaction_details' => [
                'order_id' => $gatewayOrderId,
                'gross_amount' => (int) $order->total,
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => mb_substr($order->recipient_name, 0, 50),
                'email' => $order->email,
                'phone' => $order->phone,
                'billing_address' => $address,
                'shipping_address' => $address,
            ],
            'callbacks' => ['finish' => $finishUrl],
        ];

        if ($enabledPayments) {
            $payload['enabled_payments'] = array_values($enabledPayments);
        }

        if ($expiryMinutes && $expiryMinutes > 0) {
            $payload['expiry'] = ['unit' => 'minutes', 'duration' => $expiryMinutes];
        }

        return $payload;
    }

    /** Minta token Snap. Hasil: ['token' => ..., 'redirect_url' => ...] */
    public function createSnapTransaction(array $payload): array
    {
        $response = $this->client()->post($this->snapBaseUrl() . '/transactions', $payload);

        if ($response->failed()) {
            $msg = $response->json('error_messages.0') ?? $response->body();
            throw new RuntimeException('Midtrans menolak permintaan: ' . $msg);
        }

        return $response->json();
    }

    /** Ambil status terbaru transaksi langsung dari Midtrans (dipakai saat pembeli kembali ke situs). */
    public function getStatus(string $gatewayOrderId): ?array
    {
        $response = $this->client()->get($this->apiBaseUrl() . '/' . rawurlencode($gatewayOrderId) . '/status');

        // transaksi belum pernah dibuka di popup: Midtrans menjawab 404
        if ($response->failed()) {
            return null;
        }

        $data = $response->json();

        return (string) ($data['status_code'] ?? '') === '404' ? null : $data;
    }

    /** Cek keaslian notifikasi dari Midtrans: sha512(order_id + status_code + gross_amount + server_key) */
    public function isValidSignature(array $payload): bool
    {
        foreach (['order_id', 'status_code', 'gross_amount', 'signature_key'] as $field) {
            if (! isset($payload[$field])) {
                return false;
            }
        }

        $expected = hash('sha512', $payload['order_id'] . $payload['status_code'] . $payload['gross_amount'] . $this->serverKey());

        return hash_equals($expected, (string) $payload['signature_key']);
    }

    /**
     * Terjemahkan status Midtrans ke status internal Payment:
     * berhasil | pending | gagal | kedaluwarsa
     */
    public static function mapStatus(array $data): string
    {
        $status = $data['transaction_status'] ?? '';
        $fraud = $data['fraud_status'] ?? 'accept';

        return match (true) {
            $status === 'settlement' => 'berhasil',
            $status === 'capture' && $fraud === 'accept' => 'berhasil',
            $status === 'capture' => 'pending', // fraud_status challenge, tunggu keputusan
            $status === 'pending' => 'pending',
            $status === 'expire' => 'kedaluwarsa',
            in_array($status, ['deny', 'cancel', 'failure'], true) => 'gagal',
            default => 'pending',
        };
    }
}
