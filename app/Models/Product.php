<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// OPSIONAL: pakai model Product milik tim kalau sudah ada.
// Yang dibutuhkan keranjang: name, price, dan image_url.
class Product extends Model
{
    protected $fillable = ['name', 'slug', 'price', 'image', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    /** image berisi path di folder public (contoh: images/products/dompet-perca.jpg) atau URL penuh */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return str_starts_with($this->image, 'http') ? $this->image : asset($this->image);
    }
}
