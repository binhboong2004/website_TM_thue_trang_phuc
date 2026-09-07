<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class LookbookController extends Controller
{
    /**
     * Display the community lookbook with shoppable product tags.
     */
    public function index(): View
    {
        return view('client.pages.lookbook.index', [
            'looks' => $this->looks(),
            'breadcrumbs' => [
                ['name' => 'Trang chủ', 'url' => route('home')],
                ['name' => 'Lookbook', 'url' => route('client.lookbook')],
            ],
        ]);
    }

    /**
     * Temporary community feed until Lookbook posts are persisted.
     *
     * @return list<array<string, mixed>>
     */
    private function looks(): array
    {
        return [
            $this->look('linh-nguyen', 'city-lookbook.webp', '3/4', '54% center', 'Linh Nguyễn', 'Gallery opening', 'Dáng suit mềm cho một buổi tối giữa thành phố.', 128, 62, 45, 'right', 'Studio N°5', 'Graphite Column Dress', 690000, 'graphite-column-dress'),
            $this->look('an-tran', 'black-gown.webp', '4/5', 'center', 'An Trần', 'Black tie', 'Một đường cắt đen, không cần thêm điều gì.', 246, 48, 39, 'left', 'Maison Élan', 'Noir Sculpted Gown', 890000, 'noir-sculpted-gown'),
            $this->look('minh-chau', 'hero-campaign.webp', '3/4', '52% center', 'Minh Châu', 'Weekend edit', 'Mượn từ tủ đồ tuần hoàn, mang vào câu chuyện của riêng mình.', 94, 42, 42, 'right', 'Atelier Blanc', 'Ivory Fluid Suit', 760000, 'ivory-fluid-suit'),
            $this->look('bao-anh', 'city-lookbook.webp', '4/5', '78% center', 'Bảo Anh', 'City ceremony', 'Graphite, ánh sáng và một đường vai thật gọn.', 173, 68, 36, 'left', 'Forme Privée', 'Monochrome Tuxedo Dress', 780000, 'monochrome-tuxedo-dress'),
            $this->look('quang-minh', 'hero-campaign.webp', '3/5', '88% center', 'Quang Minh', 'After dark', 'Tuxedo cổ điển được mặc theo một nhịp điệu mới.', 211, 73, 38, 'left', 'Noir Homme', 'Midnight Tuxedo', 820000, 'midnight-tuxedo'),
            $this->look('thao-nhi', 'black-gown.webp', '3/4', '42% center', 'Thảo Nhi', 'Wedding guest', 'Lụa đen chuyển động nhẹ qua những khoảnh khắc cuối ngày.', 156, 47, 34, 'right', 'Maison Élan', 'Silk Cowl Evening Dress', 940000, 'silk-cowl-evening-dress'),
            $this->look('gia-han', 'city-lookbook.webp', '4/5', '31% center', 'Gia Hân', 'Museum afternoon', 'Một dáng midi tối giản giữa kiến trúc thành thị.', 87, 39, 47, 'right', 'Studio N°5', 'Slate Draped Midi', 590000, 'slate-draped-midi'),
            $this->look('duc-anh', 'hero-campaign.webp', '3/4', '81% center', 'Đức Anh', 'Formal dinner', 'Nhung đen và tỷ lệ may đo cho buổi tối trang trọng.', 139, 76, 37, 'left', 'Noir Homme', 'Velvet Peak Lapel Suit', 970000, 'velvet-peak-lapel-suit'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function look(
        string $id,
        string $image,
        string $aspect,
        string $position,
        string $author,
        string $occasion,
        string $caption,
        int $likes,
        int $hotspotX,
        int $hotspotY,
        string $popoverSide,
        string $brand,
        string $productName,
        int $rentalPrice,
        string $productSlug,
    ): array {
        return [
            'id' => $id,
            'image' => asset('images/editorial/'.$image),
            'aspect' => $aspect,
            'position' => $position,
            'author' => $author,
            'occasion' => $occasion,
            'caption' => $caption,
            'likes' => $likes,
            'hotspot' => [
                'x' => $hotspotX,
                'y' => $hotspotY,
                'popoverSide' => $popoverSide,
            ],
            'product' => [
                'brand' => $brand,
                'name' => $productName,
                'rentalPrice' => $rentalPrice,
                'url' => route('products.show', ['slug' => $productSlug, 'mode' => 'rent']),
            ],
        ];
    }
}
