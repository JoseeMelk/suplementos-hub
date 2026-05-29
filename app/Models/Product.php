<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'name',
    'description',
    'price',
    'brand',
    'flavor',
    'weight_grams',
    'serving_size',
    'quantity',
    'is_visible',
    'user_id',
    'category_id'
])]
class Product extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_visible' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Product.php — agregar estos dos métodos

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    /**
     * Devuelve la imagen principal o la primera disponible.
     * Uso: $product->main_image ?? 'placeholder.webp'
     */
    public function getMainImageAttribute(): ?string
    {
        return $this->primaryImage?->path
            ?? $this->images()->ordered()->first()?->path;
    }

    /**
     * Devuelve el url de la imagen principal o la primera disponible.
     * Uso: $product->url_main_image
     */
    public function getUrlMainImageAttribute(): string
    {
        return $this->main_image
            ? Storage::url($this->main_image)
            : asset('images/placeholder.webp');
    }
}
