<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;

class InventoryController extends Controller
{
    /**
     * Display physical garment availability by product template.
     */
    public function index(): View
    {
        $timeline = collect(range(0, 13))->map(function (int $offset): array {
            $date = Carbon::today()->addDays($offset);

            return [
                'key' => $date->toDateString(),
                'day' => $date->translatedFormat('D'),
                'date' => $date->format('d/m'),
                'is_today' => $offset === 0,
            ];
        })->all();

        $templates = [
            [
                'id' => 'noir-sculpted-gown',
                'code' => 'TPL-NSG',
                'brand' => 'Maison Élan',
                'name' => 'Noir Sculpted Gown',
                'image' => asset('images/editorial/black-gown.webp'),
                'items' => [
                    ['code' => 'NSG-XS-001', 'qr' => 'LR-NSG-XS-001', 'size' => 'XS', 'condition' => 'Xuất sắc', 'status' => 'available', 'status_label' => 'Sẵn sàng', 'schedule' => []],
                    ['code' => 'NSG-S-001', 'qr' => 'LR-NSG-S-001', 'size' => 'S', 'condition' => 'Xuất sắc', 'status' => 'rented', 'status_label' => 'Đang cho thuê', 'schedule' => [
                        ['start' => 0, 'span' => 4, 'type' => 'rented', 'label' => 'LR-2026-0001'],
                        ['start' => 4, 'span' => 2, 'type' => 'buffer', 'label' => 'Giặt hấp'],
                    ]],
                    ['code' => 'NSG-M-001', 'qr' => 'LR-NSG-M-001', 'size' => 'M', 'condition' => 'Tốt', 'status' => 'buffer', 'status_label' => 'Đệm bảo dưỡng', 'schedule' => [
                        ['start' => 0, 'span' => 2, 'type' => 'buffer', 'label' => 'Kiểm tra'],
                        ['start' => 8, 'span' => 4, 'type' => 'rented', 'label' => 'LR-2026-0018'],
                        ['start' => 12, 'span' => 2, 'type' => 'buffer', 'label' => 'Giặt hấp'],
                    ]],
                ],
            ],
            [
                'id' => 'ivory-fluid-suit',
                'code' => 'TPL-IFS',
                'brand' => 'Atelier No. 7',
                'name' => 'Ivory Fluid Suit',
                'image' => asset('images/editorial/hero-campaign.webp'),
                'items' => [
                    ['code' => 'IFS-S-001', 'qr' => 'LR-IFS-S-001', 'size' => 'S', 'condition' => 'Xuất sắc', 'status' => 'available', 'status_label' => 'Sẵn sàng', 'schedule' => [
                        ['start' => 6, 'span' => 3, 'type' => 'rented', 'label' => 'LR-2026-0024'],
                        ['start' => 9, 'span' => 2, 'type' => 'buffer', 'label' => 'Giặt hấp'],
                    ]],
                    ['code' => 'IFS-M-001', 'qr' => 'LR-IFS-M-001', 'size' => 'M', 'condition' => 'Cần theo dõi', 'status' => 'maintenance', 'status_label' => 'Bảo dưỡng', 'schedule' => [
                        ['start' => 0, 'span' => 5, 'type' => 'maintenance', 'label' => 'Sửa khóa'],
                    ]],
                ],
            ],
        ];

        return view('shop.pages.inventory.index', [
            'timeline' => $timeline,
            'templates' => $templates,
            'metrics' => [
                ['label' => 'Mẫu thiết kế', 'value' => count($templates)],
                ['label' => 'Món đồ vật lý', 'value' => 5],
                ['label' => 'Đang cho thuê', 'value' => 1],
                ['label' => 'Đệm / bảo dưỡng', 'value' => 2],
            ],
        ]);
    }
}
