<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    /**
     * Display the seller product catalogue.
     */
    public function index(): View
    {
        return view('shop.pages.products.index', [
            'products' => [],
        ]);
    }

    /**
     * Display the product creation form.
     */
    public function create(): View
    {
        return view('shop.pages.products.create');
    }

    /**
     * Display the product editing form.
     */
    public function edit(string $product): View
    {
        return view('shop.pages.products.edit', [
            'product' => [
                'slug' => $product,
                'name' => str($product)->replace('-', ' ')->title()->toString(),
                'brand' => '',
                'rental_price' => null,
                'purchase_price' => null,
                'deposit' => null,
            ],
        ]);
    }
}
