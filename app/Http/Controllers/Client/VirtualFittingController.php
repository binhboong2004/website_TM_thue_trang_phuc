<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class VirtualFittingController extends Controller
{
    /**
     * Display the dedicated virtual fitting studio.
     */
    public function index(): View
    {
        $product = [
            'id' => 'noir-sculpted-gown',
            'brand' => 'Maison Élan',
            'name' => 'Noir Sculpted Gown',
            'image' => asset('images/editorial/black-gown.webp'),
            'position' => 'center',
            'url' => route('products.show', 'noir-sculpted-gown'),
            'rentalPrice' => 890000,
            'deposit' => 2500000,
            'purchasePrice' => 6800000,
            'sizes' => ['XS', 'S', 'M'],
        ];

        return view('client.pages.virtual-fitting.index', [
            'product' => $product,
            'breadcrumbs' => [
                ['name' => 'Trang chủ', 'url' => route('home')],
                ['name' => 'Phòng thử đồ ảo', 'url' => route('client.virtual-fitting')],
            ],
        ]);
    }
}
