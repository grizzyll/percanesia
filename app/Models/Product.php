<?php

namespace App\Models;

<<<<<<< HEAD
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
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'image',
        'description',
        'status',
        'is_featured',
    ];
}
>>>>>>> b0f49f9d925596baec365c3dd3e12c057965b300
