<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    /**
     * Indicates if the model's ID is auto-incrementing.
     */
    public $incrementing = false;

    /**
     * The data type of the model's primary key.
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'brand',
        'name',
        'image',
        'position',
        'status',
        'rental_price',
        'deposit',
        'purchase_price',
        'sizes',
    ];

    /**
     * Get the users who have favorited this product.
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();
    }

    /**
     * Get the product detail URL.
     */
    protected function url(): Attribute
    {
        return Attribute::get(fn (): string => route('products.show', $this->getKey()));
    }

    /**
     * Resolve a stored product image path to its public URL.
     */
    protected function image(): Attribute
    {
        return Attribute::get(
            fn (string $value): string => str_contains($value, '://') ? $value : asset($value),
        );
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rental_price' => 'integer',
            'deposit' => 'integer',
            'purchase_price' => 'integer',
            'sizes' => 'array',
        ];
    }
}
