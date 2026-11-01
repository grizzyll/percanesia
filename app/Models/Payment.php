<?php

namespace App\Models;

use App\Services\MidtransService;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public const PENDING = 'pending';
    public const MENUNGGU_VERIFIKASI = 'menunggu_verifikasi'; // bukti transfer internasional sudah diupload
    public const BERHASIL = 'berhasil';
    public const GAGAL = 'gagal';
    public const KEDALUWARSA = 'kedaluwarsa';

    protected $fillable = [
        'order_id', 'method', 'channel', 'attempt', 'gateway_order_id', 'amount', 'status',
        'proof_path', 'snap_token', 'gateway_payment_type', 'gateway_transaction_id', 'payment_info',
        'expires_at', 'paid_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'paid_at' => 'datetime',
        'payment_info' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /** gateway | cod | manual (dari config/shop.php) */
    public function getTypeAttribute(): string
    {
        return config("shop.payment_methods.{$this->method}.type", 'gateway');
    }

    public function isGateway(): bool
    {
        return $this->type === 'gateway';
    }

    public function isCod(): bool
    {
        return $this->type === 'cod';
    }

    public function isManual(): bool
    {
        return $this->type === 'manual';
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    /** Boleh upload bukti transfer internasional */
    public function canUploadProof(): bool
    {
        return $this->isManual() && $this->status === self::PENDING && ! $this->isExpired();
    }

    /**
     * Terapkan hasil dari Midtrans (notifikasi webhook atau cek status).
     * Aman dipanggil berulang kali: pembayaran yang sudah berhasil tidak diubah lagi.
     */
    public function applyGatewayResult(array $data): void
    {
        if ($this->status === self::BERHASIL) {
            return;
        }

        $this->gateway_payment_type = $data['payment_type'] ?? $this->gateway_payment_type;
        $this->gateway_transaction_id = $data['transaction_id'] ?? $this->gateway_transaction_id;

        if ($info = self::extractInfo($data)) {
            $this->payment_info = $info;
        }

        $result = MidtransService::mapStatus($data);

        if ($result === 'berhasil') {
            $this->status = self::BERHASIL;
            $this->paid_at = now();
            $this->save();
            $this->order->update(['status' => Order::DIBAYAR]);

            return;
        }

        if ($result === 'gagal' || $result === 'kedaluwarsa') {
            $this->status = $result === 'gagal' ? self::GAGAL : self::KEDALUWARSA;
            $this->save();
            $this->order->update(['status' => Order::DIBATALKAN]);

            return;
        }

        $this->save(); // masih pending (misal VA sudah dibuat tapi belum dibayar)
    }

    /** Ambil nomor VA / kode bayar dari respons Midtrans untuk ditampilkan ke pembeli */
    public static function extractInfo(array $d): ?array
    {
        if (! empty($d['va_numbers'][0]['va_number'])) {
            return [
                'type' => 'va',
                'bank' => strtoupper($d['va_numbers'][0]['bank'] ?? ''),
                'number' => $d['va_numbers'][0]['va_number'],
            ];
        }

        if (! empty($d['permata_va_number'])) {
            return ['type' => 'va', 'bank' => 'PERMATA', 'number' => $d['permata_va_number']];
        }

        if (! empty($d['bill_key'])) {
            return [
                'type' => 'bill',
                'bank' => 'MANDIRI',
                'biller_code' => $d['biller_code'] ?? '',
                'bill_key' => $d['bill_key'],
            ];
        }

        return null;
    }
}
