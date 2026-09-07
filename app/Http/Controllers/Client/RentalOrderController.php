<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;

class RentalOrderController extends Controller
{
    /**
     * Display the rental lifecycle and escrow status.
     */
    public function show(string $orderCode): View
    {
        $refundDeadline = Carbon::now()->addHours(17)->addMinutes(42);

        return view('client.pages.account.rental-detail', [
            'order' => [
                'code' => $orderCode,
                'placed_at' => '26/08/2026 · 09:42',
                'current_step' => 4,
                'product' => [
                    'name' => 'Noir Sculpted Gown',
                    'brand' => 'Maison Élan',
                    'size' => 'S',
                    'garment_code' => 'NSG-S-001',
                    'image' => asset('images/editorial/black-gown.webp'),
                ],
                'rental_period' => '28/08/2026 — 30/08/2026',
                'return_tracking' => 'LRX928401VN',
                'refund_deadline' => $refundDeadline->toIso8601String(),
                'refund_deadline_label' => $refundDeadline->format('H:i · d/m/Y'),
                'financials' => [
                    'rental_fee' => 2670000,
                    'shipping_fee' => 80000,
                    'deposit' => 2500000,
                    'paid_total' => 2750000,
                ],
            ],
            'steps' => [
                ['label' => 'Đã đặt & đóng băng cọc', 'description' => 'Thanh toán xác nhận'],
                ['label' => 'Shop đóng gói & giao', 'description' => 'Đã giao thành công'],
                ['label' => 'Đang sử dụng', 'description' => 'Kỳ thuê đã kết thúc'],
                ['label' => 'Trả hàng & kiểm tra', 'description' => 'Shop đang đối soát'],
                ['label' => 'Hoàn tất & hoàn cọc', 'description' => 'Tự động sau kiểm tra'],
            ],
            'breadcrumbs' => [
                ['name' => 'Trang chủ', 'url' => route('home')],
                ['name' => 'Đơn thuê '.$orderCode, 'url' => route('account.rentals.show', $orderCode)],
            ],
        ]);
    }
}
