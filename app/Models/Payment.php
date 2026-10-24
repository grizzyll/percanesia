<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public const PENDING = 'pending';
    public const MENUNGGU_VERIFIKASI = 'menunggu_verifikasi';
    public const BERHASIL = 'berhasil';
    public const DITOLAK = 'ditolak';
    public const KEDALUWARSA = 'kedaluwarsa';

    protected $fillable = ['order_id', 'method', 'amount', 'status', 'proof_path', 'expires_at', 'paid_at'];

    protected $casts = [
        'expires_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /** Detail metode (rekening, QRIS, dll) dari config/shop.php */
    public function getMethodConfigAttribute(): array
    {
        return config('shop.payment_methods.' . $this->method, []);
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    /** Boleh upload bukti kalau belum diverifikasi dan belum kedaluwarsa */
    public function canUploadProof(): bool
    {
        return in_array($this->status, [self::PENDING, self::DITOLAK], true) && ! $this->isExpired();
    }
}
