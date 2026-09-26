<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['id' => 'noir-sculpted-gown', 'brand' => 'Maison Élan', 'name' => 'Noir Sculpted Gown', 'image' => 'images/editorial/black-gown.webp', 'position' => 'center', 'rental_price' => 890000, 'deposit' => 2500000, 'purchase_price' => 6800000, 'sizes' => ['XS', 'S', 'M']],
            ['id' => 'ivory-fluid-suit', 'brand' => 'Atelier Blanc', 'name' => 'Ivory Fluid Suit', 'image' => 'images/editorial/hero-campaign.webp', 'position' => '52% center', 'rental_price' => 760000, 'deposit' => 2200000, 'purchase_price' => 5900000, 'sizes' => ['S', 'M']],
            ['id' => 'midnight-tuxedo', 'brand' => 'Noir Homme', 'name' => 'Midnight Tuxedo', 'image' => 'images/editorial/hero-campaign.webp', 'position' => '88% center', 'rental_price' => 820000, 'deposit' => 2400000, 'purchase_price' => 6400000, 'sizes' => ['M', 'L', 'XL']],
            ['id' => 'graphite-column-dress', 'brand' => 'Studio N°5', 'name' => 'Graphite Column Dress', 'image' => 'images/editorial/city-lookbook.webp', 'position' => '72% center', 'rental_price' => 690000, 'deposit' => 1900000, 'purchase_price' => 5200000, 'sizes' => ['XS', 'S']],
            ['id' => 'silk-cowl-evening-dress', 'brand' => 'Maison Élan', 'name' => 'Silk Cowl Evening Dress', 'image' => 'images/editorial/black-gown.webp', 'position' => '42% center', 'rental_price' => 940000, 'deposit' => 2800000, 'purchase_price' => 7200000, 'sizes' => ['S', 'M', 'L']],
            ['id' => 'architectural-white-blazer', 'brand' => 'Atelier Blanc', 'name' => 'Architectural White Blazer', 'image' => 'images/editorial/hero-campaign.webp', 'position' => '67% center', 'rental_price' => 640000, 'deposit' => 1800000, 'purchase_price' => 4800000, 'sizes' => ['XS', 'S', 'M', 'L']],
            ['id' => 'velvet-peak-lapel-suit', 'brand' => 'Noir Homme', 'name' => 'Velvet Peak Lapel Suit', 'image' => 'images/editorial/hero-campaign.webp', 'position' => '83% center', 'rental_price' => 970000, 'deposit' => 3000000, 'purchase_price' => 7600000, 'sizes' => ['M', 'L', 'XL']],
            ['id' => 'slate-draped-midi', 'brand' => 'Studio N°5', 'name' => 'Slate Draped Midi', 'image' => 'images/editorial/city-lookbook.webp', 'position' => '32% center', 'rental_price' => 590000, 'deposit' => 1600000, 'purchase_price' => 4400000, 'sizes' => ['XS', 'S', 'M']],
            ['id' => 'monochrome-tuxedo-dress', 'brand' => 'Forme Privée', 'name' => 'Monochrome Tuxedo Dress', 'image' => 'images/editorial/city-lookbook.webp', 'position' => '58% center', 'rental_price' => 780000, 'deposit' => 2100000, 'purchase_price' => 6100000, 'sizes' => ['S', 'M', 'L']],
            ['id' => 'black-organza-column', 'brand' => 'Forme Privée', 'name' => 'Black Organza Column', 'image' => 'images/editorial/black-gown.webp', 'position' => '60% center', 'rental_price' => 860000, 'deposit' => 2600000, 'purchase_price' => 6700000, 'sizes' => ['XS', 'S']],
            ['id' => 'pearl-satin-co-ord', 'brand' => 'Étage Studio', 'name' => 'Pearl Satin Co-ord', 'image' => 'images/editorial/hero-campaign.webp', 'position' => '63% center', 'rental_price' => 720000, 'deposit' => 2000000, 'purchase_price' => 5500000, 'sizes' => ['S', 'M', 'L']],
            ['id' => 'charcoal-sculpted-jacket', 'brand' => 'Étage Studio', 'name' => 'Charcoal Sculpted Jacket', 'image' => 'images/editorial/city-lookbook.webp', 'position' => '76% center', 'rental_price' => 610000, 'deposit' => 1700000, 'purchase_price' => 4900000, 'sizes' => ['XS', 'S', 'M', 'L']],
        ];

        foreach ($products as $product) {
            Product::query()->updateOrCreate(
                ['id' => $product['id']],
                $product,
            );
        }
    }
}
