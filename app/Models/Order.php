<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    public const MENUNGGU_PEMBAYARAN = 'menunggu_pembayaran';
    public const MENUNGGU_VERIFIKASI = 'menunggu_verifikasi';
    public const DIBAYAR = 'dibayar';
    public const DIKIRIM = 'dikirim';
    public const SELESAI = 'selesai';
    public const DIBATALKAN = 'dibatalkan';

    protected $fillable = [
        'order_number', 'user_id', 'recipient_name', 'phone', 'address', 'city',
        'postal_code', 'note', 'subtotal', 'shipping_cost', 'total', 'status',
    ];

    /** URL pakai nomor order, bukan id, contoh: /pembayaran/PRC-261014-AB12C */
    public function getRouteKeyName(): string
    {
        return 'order_number';
    }

    public static function generateNumber(): string
    {
        do {
            $number = 'PRC-' . now()->format('ymd') . '-' . strtoupper(Str::random(5));
        } while (static::where('order_number', $number)->exists());

        return $number;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::MENUNGGU_PEMBAYARAN => 'Menunggu pembayaran',
            self::MENUNGGU_VERIFIKASI => 'Menunggu verifikasi',
            self::DIBAYAR => 'Sudah dibayar',
            self::DIKIRIM => 'Dikirim',
            self::SELESAI => 'Selesai',
            self::DIBATALKAN => 'Dibatalkan',
            default => $this->status,
        };
    }
}
