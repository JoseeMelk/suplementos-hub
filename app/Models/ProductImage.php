<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable([
    'path',
    'source',
    'is_primary',
    'sort_order',
    'product_id'
])]
class ProductImage extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Relación: imagen pertenece a producto
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope: imagen principal
     */
    public function scopePrimary(Builder $query): Builder
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope: ordenadas
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')
            ->orderByDesc('is_primary');
    }
}
