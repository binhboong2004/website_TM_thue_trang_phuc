<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    /**
     * Display a hybrid rental and purchase product detail page.
     */
    public function show(string $slug): View
    {
        $product = $this->products()[$slug] ?? null;

        abort_if($product === null, 404);

        $product['url'] = route('products.show', $slug);
        $product['gallery'] = $this->galleryFor($product);
        $product['measurements'] = collect($this->measurementChart())
            ->only($product['sizes'])
            ->all();

        return view('client.pages.products.show', [
            'product' => $product,
            'breadcrumbs' => [
                ['name' => 'Trang chủ', 'url' => route('home')],
                ['name' => 'Mua sắm', 'url' => route('client.shop')],
                ['name' => $product['name'], 'url' => $product['url']],
            ],
        ]);
    }

    /**
     * Temporary product catalogue until the Product model is connected.
     *
     * @return array<string, array<string, mixed>>
     */
    private function products(): array
    {
        return [
            'noir-sculpted-gown' => $this->product('noir-sculpted-gown', 'Maison Élan', 'Noir Sculpted Gown', 'black-gown.webp', 'center', 890000, 2500000, 6800000, ['XS', 'S', 'M'], 'Đầm dạ tiệc dựng phom trên nền crepe đen, tạo đường cong kiến trúc và chuyển động mềm khi bước đi.'),
            'ivory-fluid-suit' => $this->product('ivory-fluid-suit', 'Atelier Blanc', 'Ivory Fluid Suit', 'hero-campaign.webp', '52% center', 760000, 2200000, 5900000, ['S', 'M'], 'Suit ivory phom thả với ve áo dài, hoàn thiện thủ công cho vẻ ngoài thanh lịch và hiện đại.'),
            'midnight-tuxedo' => $this->product('midnight-tuxedo', 'Noir Homme', 'Midnight Tuxedo', 'hero-campaign.webp', '88% center', 820000, 2400000, 6400000, ['M', 'L', 'XL'], 'Tuxedo đen midnight với ve satin sắc nét, cân bằng giữa cấu trúc cổ điển và tỷ lệ đương đại.'),
            'graphite-column-dress' => $this->product('graphite-column-dress', 'Studio N°5', 'Graphite Column Dress', 'city-lookbook.webp', '72% center', 690000, 1900000, 5200000, ['XS', 'S'], 'Đầm cột graphite tối giản với bề mặt lì và đường may định hình cơ thể tinh tế.'),
            'silk-cowl-evening-dress' => $this->product('silk-cowl-evening-dress', 'Maison Élan', 'Silk Cowl Evening Dress', 'black-gown.webp', '42% center', 940000, 2800000, 7200000, ['S', 'M', 'L'], 'Lụa rủ cổ đổ mềm, được cắt chéo sợi để ôm dáng tự nhiên trong những buổi tiệc trang trọng.'),
            'architectural-white-blazer' => $this->product('architectural-white-blazer', 'Atelier Blanc', 'Architectural White Blazer', 'hero-campaign.webp', '67% center', 640000, 1800000, 4800000, ['XS', 'S', 'M', 'L'], 'Blazer trắng kiến trúc với vai dựng nhẹ và đường eo tinh gọn, phù hợp cả tiệc tối lẫn sự kiện ban ngày.'),
            'velvet-peak-lapel-suit' => $this->product('velvet-peak-lapel-suit', 'Noir Homme', 'Velvet Peak Lapel Suit', 'hero-campaign.webp', '83% center', 970000, 3000000, 7600000, ['M', 'L', 'XL'], 'Suit nhung ve nhọn với sắc đen sâu, hoàn thiện dành cho dress code black-tie.'),
            'slate-draped-midi' => $this->product('slate-draped-midi', 'Studio N°5', 'Slate Draped Midi', 'city-lookbook.webp', '32% center', 590000, 1600000, 4400000, ['XS', 'S', 'M'], 'Đầm midi slate xếp rủ bất đối xứng, nhẹ và linh hoạt cho nhiều bối cảnh sự kiện.'),
            'monochrome-tuxedo-dress' => $this->product('monochrome-tuxedo-dress', 'Forme Privée', 'Monochrome Tuxedo Dress', 'city-lookbook.webp', '58% center', 780000, 2100000, 6100000, ['S', 'M', 'L'], 'Tuxedo dress đơn sắc với đường ve tương phản và cấu trúc ôm eo mạnh mẽ.'),
            'black-organza-column' => $this->product('black-organza-column', 'Forme Privée', 'Black Organza Column', 'black-gown.webp', '60% center', 860000, 2600000, 6700000, ['XS', 'S'], 'Đầm cột organza đen nhiều lớp, trong nhẹ nhưng vẫn giữ đường nét couture rõ ràng.'),
            'pearl-satin-co-ord' => $this->product('pearl-satin-co-ord', 'Étage Studio', 'Pearl Satin Co-ord', 'hero-campaign.webp', '63% center', 720000, 2000000, 5500000, ['S', 'M', 'L'], 'Bộ satin ánh ngọc trai gồm áo dựng phom và quần suông, mang tinh thần tối giản thanh lịch.'),
            'charcoal-sculpted-jacket' => $this->product('charcoal-sculpted-jacket', 'Étage Studio', 'Charcoal Sculpted Jacket', 'city-lookbook.webp', '76% center', 610000, 1700000, 4900000, ['XS', 'S', 'M', 'L'], 'Áo khoác charcoal dựng khối với chi tiết eo điêu khắc và hàng khuy ẩn tối giản.'),
        ];
    }

    /**
     * @param  list<string>  $sizes
     * @return array<string, mixed>
     */
    private function product(
        string $id,
        string $brand,
        string $name,
        string $image,
        string $position,
        int $rentalPrice,
        int $deposit,
        int $purchasePrice,
        array $sizes,
        string $description,
    ): array {
        return [
            'id' => $id,
            'sku' => 'LR-'.strtoupper(substr(hash('crc32b', $id), 0, 8)),
            'brand' => $brand,
            'name' => $name,
            'image' => asset('images/editorial/'.$image),
            'position' => $position,
            'status' => 'CÓ SẴN',
            'rentalPrice' => $rentalPrice,
            'deposit' => $deposit,
            'purchasePrice' => $purchasePrice,
            'sizes' => $sizes,
            'description' => $description,
            'condition' => 'Mới 100%',
            'material' => 'Vải cao cấp tuyển chọn · Lót viscose thoáng khí',
            'unavailableDates' => [
                now()->addDays(8)->toDateString(),
                now()->addDays(9)->toDateString(),
                now()->addDays(14)->toDateString(),
            ],
        ];
    }

    /**
     * @param  array<string, mixed>  $product
     * @return list<array{src: string, alt: string, position: string}>
     */
    private function galleryFor(array $product): array
    {
        return [
            ['src' => $product['image'], 'alt' => $product['name'].' — toàn bộ thiết kế', 'position' => $product['position']],
            ['src' => asset('images/editorial/city-lookbook.webp'), 'alt' => $product['name'].' — phối cảnh chuyển động', 'position' => '62% center'],
            ['src' => asset('images/editorial/black-gown.webp'), 'alt' => $product['name'].' — chi tiết chất liệu và đường may', 'position' => '45% center'],
            ['src' => asset('images/editorial/hero-campaign.webp'), 'alt' => $product['name'].' — góc nhìn phía sau', 'position' => '78% center'],
        ];
    }

    /**
     * @return array<string, array{bust: int, waist: int, hips: int, length: int}>
     */
    private function measurementChart(): array
    {
        return [
            'XS' => ['bust' => 80, 'waist' => 62, 'hips' => 88, 'length' => 145],
            'S' => ['bust' => 84, 'waist' => 66, 'hips' => 92, 'length' => 146],
            'M' => ['bust' => 88, 'waist' => 70, 'hips' => 96, 'length' => 147],
            'L' => ['bust' => 92, 'waist' => 74, 'hips' => 100, 'length' => 148],
            'XL' => ['bust' => 98, 'waist' => 80, 'hips' => 106, 'length' => 149],
        ];
    }
}
