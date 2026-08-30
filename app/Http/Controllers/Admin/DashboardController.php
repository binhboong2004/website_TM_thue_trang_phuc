<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display the administration dashboard.
     */
    public function index(): View
    {
        return view('admin.pages.dashboard.index', [
            'metrics' => [
                ['label' => 'Đơn thuê đang xử lý', 'value' => 0, 'change' => 'Chờ dữ liệu'],
                ['label' => 'Đơn mua mới', 'value' => 0, 'change' => 'Chờ dữ liệu'],
                ['label' => 'Tiền cọc đang giữ', 'value' => '0 ₫', 'change' => 'Không có phát sinh'],
                ['label' => 'Sản phẩm khả dụng', 'value' => 0, 'change' => 'Chưa đồng bộ kho'],
            ],
        ]);
    }
}
