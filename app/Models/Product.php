<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'price',
        'stock',
        'image',
        'description',
        'status',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'price'       => 'integer',
        'stock'       => 'integer',
        'is_active'   => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * `image` berisi path relatif di folder public
     * (contoh: images/products/dompet-perca.jpg) atau URL penuh.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        if (preg_match('#^https?://#i', $this->image)) {
            return $this->image;
        }

        return asset($this->image);
    }
}
