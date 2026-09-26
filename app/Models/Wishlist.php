<?php

namespace App\Models;

use Database\Factories\WishlistFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    /** @use HasFactory<WishlistFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    /**
     * Get the user who owns the wishlist entry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the favorited product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
