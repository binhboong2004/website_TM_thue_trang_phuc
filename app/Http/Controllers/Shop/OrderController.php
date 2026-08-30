<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class OrderController extends Controller
{
    /**
     * Display orders belonging to the authenticated seller.
     */
    public function index(): View
    {
        return view('shop.pages.orders.index', [
            'orders' => [],
        ]);
    }

    /**
     * Display a seller order.
     */
    public function show(string $order): View
    {
        return view('shop.pages.orders.show', [
            'order' => [
                'code' => $order,
                'status' => 'Chờ đồng bộ',
                'customer' => 'Chưa có dữ liệu',
                'total' => '0 ₫',
                'items' => [],
            ],
        ]);
    }
}
