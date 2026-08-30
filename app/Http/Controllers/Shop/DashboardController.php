<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display the seller dashboard.
     */
    public function index(): View
    {
        return view('shop.pages.dashboard', [
            'metrics' => [
                ['label' => 'Sản phẩm đang bán', 'value' => 0, 'detail' => 'Chưa đồng bộ danh mục'],
                ['label' => 'Đơn cần xử lý', 'value' => 0, 'detail' => 'Không có đơn tồn đọng'],
                ['label' => 'Lịch thuê tuần này', 'value' => 0, 'detail' => 'Chưa có lịch mới'],
                ['label' => 'Doanh thu tạm tính', 'value' => '0 ₫', 'detail' => 'Tháng hiện tại'],
            ],
            'recentOrders' => [],
        ]);
    }
}
