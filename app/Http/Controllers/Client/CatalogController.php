<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use DateTimeImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CatalogController extends Controller
{
    /**
     * Display the public hybrid shopping catalogue.
     */
    public function index(Request $request): View
    {
        $filters = $this->filtersFromRequest($request);
        $products = $this->catalogProducts();

        $filteredProducts = $products
            ->when($filters['sizes'] !== [], fn (Collection $items): Collection => $items->filter(
                fn (array $product): bool => collect($product['sizes'])->intersect($filters['sizes'])->isNotEmpty(),
            ))
            ->when($filters['brands'] !== [], fn (Collection $items): Collection => $items->whereIn('brand', $filters['brands']))
            ->when($filters['min_price'] !== null, fn (Collection $items): Collection => $items->filter(
                fn (array $product): bool => $this->priceForTransaction($product, $filters['transaction']) >= $filters['min_price'],
            ))
            ->when($filters['max_price'] !== null, fn (Collection $items): Collection => $items->filter(
                fn (array $product): bool => $this->priceForTransaction($product, $filters['transaction']) <= $filters['max_price'],
            ))
            ->when($filters['available_from'] !== null, fn (Collection $items): Collection => $items->filter(
                fn (array $product): bool => $product['availableFrom'] <= $filters['available_from'],
            ))
            ->when($filters['available_to'] !== null, fn (Collection $items): Collection => $items->filter(
                fn (array $product): bool => $product['availableTo'] >= $filters['available_to'],
            ));

        $sortedProducts = match ($filters['sort']) {
            'price_asc' => $filteredProducts->sortBy(fn (array $product): int => $this->priceForTransaction($product, $filters['transaction'])),
            'price_desc' => $filteredProducts->sortByDesc(fn (array $product): int => $this->priceForTransaction($product, $filters['transaction'])),
            default => $filteredProducts->sortByDesc('createdAt'),
        };

        $currentPage = max(1, $request->integer('page', 1));
        $perPage = 9;
        $paginatedProducts = new LengthAwarePaginator(
            items: $sortedProducts->forPage($currentPage, $perPage)->values(),
            total: $sortedProducts->count(),
            perPage: $perPage,
            currentPage: $currentPage,
            options: [
                'path' => $request->url(),
                'query' => $request->query(),
            ],
        );

        return view('client.pages.catalog.index', [
            'products' => $paginatedProducts,
            'filters' => $filters,
            'sizes' => ['XS', 'S', 'M', 'L', 'XL'],
            'brands' => $products->pluck('brand')->unique()->sort()->values(),
            'breadcrumbs' => [
                ['name' => 'Trang chủ', 'url' => route('home')],
                ['name' => 'Mua sắm', 'url' => route('client.shop')],
            ],
        ]);
    }

    /**
     * Normalize catalogue filters from the query string.
     *
     * @return array{
     *     transaction: string,
     *     sizes: list<string>,
     *     brands: list<string>,
     *     min_price: int|null,
     *     max_price: int|null,
     *     available_from: string|null,
     *     available_to: string|null,
     *     sort: string
     * }
     */
    private function filtersFromRequest(Request $request): array
    {
        $transaction = match ($request->string('type')->toString()) {
            'rent' => 'rental',
            'buy' => 'purchase',
            default => $request->string('transaction')->toString(),
        };

        if ($transaction === '') {
            $transaction = $request->string('purpose')->toString();
        }

        $transaction = in_array($transaction, ['all', 'rental', 'purchase'], true) ? $transaction : 'all';

        $sort = $request->string('sort')->toString();
        $sort = in_array($sort, ['newest', 'price_asc', 'price_desc'], true) ? $sort : 'newest';

        $allowedSizes = ['XS', 'S', 'M', 'L', 'XL'];
        $sizes = array_values(array_intersect(
            $allowedSizes,
            array_map('strtoupper', $this->arrayQueryValue($request->query('sizes', []))),
        ));

        $allowedBrands = $this->catalogProducts()->pluck('brand')->unique()->all();
        $brands = array_values(array_intersect(
            $allowedBrands,
            $this->arrayQueryValue($request->query('brands', [])),
        ));

        $minPrice = $request->filled('min_price') ? max(0, $request->integer('min_price')) : null;
        $maxPrice = $request->filled('max_price') ? max(0, $request->integer('max_price')) : null;

        if ($minPrice !== null && $maxPrice !== null && $minPrice > $maxPrice) {
            [$minPrice, $maxPrice] = [$maxPrice, $minPrice];
        }

        $availableFrom = $this->validDate($request->query('available_from'));
        $availableTo = $this->validDate($request->query('available_to'));

        if ($availableFrom !== null && $availableTo !== null && $availableFrom > $availableTo) {
            [$availableFrom, $availableTo] = [$availableTo, $availableFrom];
        }

        return [
            'transaction' => $transaction,
            'sizes' => $sizes,
            'brands' => $brands,
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'available_from' => $availableFrom,
            'available_to' => $availableTo,
            'sort' => $sort,
        ];
    }

    /**
     * Convert a query-string value into a list of strings.
     *
     * @return list<string>
     */
    private function arrayQueryValue(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        return array_values(array_filter($value, fn (mixed $item): bool => is_string($item)));
    }

    private function validDate(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value);

        return $date !== false && $date->format('Y-m-d') === $value ? $value : null;
    }

    /**
     * Choose the price used by the active transaction filter.
     *
     * @param  array{rentalPrice: int, purchasePrice: int}  $product
     */
    private function priceForTransaction(array $product, string $transaction): int
    {
        return $transaction === 'purchase' ? $product['purchasePrice'] : $product['rentalPrice'];
    }

    /**
     * Provide catalogue data until the product repository is connected.
     *
     * @return Collection<int, array<string, mixed>>
     */
    private function catalogProducts(): Collection
    {
        return collect([
            $this->product('noir-sculpted-gown', 'Maison Élan', 'Noir Sculpted Gown', 'black-gown.webp', 'center', 890000, 2500000, 6800000, ['XS', 'S', 'M'], '2026-08-01', '2027-12-31', '2026-08-28'),
            $this->product('ivory-fluid-suit', 'Atelier Blanc', 'Ivory Fluid Suit', 'hero-campaign.webp', '52% center', 760000, 2200000, 5900000, ['S', 'M'], '2026-08-01', '2027-10-31', '2026-08-27'),
            $this->product('midnight-tuxedo', 'Noir Homme', 'Midnight Tuxedo', 'hero-campaign.webp', '88% center', 820000, 2400000, 6400000, ['M', 'L', 'XL'], '2026-09-01', '2027-12-31', '2026-08-26'),
            $this->product('graphite-column-dress', 'Studio N°5', 'Graphite Column Dress', 'city-lookbook.webp', '72% center', 690000, 1900000, 5200000, ['XS', 'S'], '2026-08-15', '2027-08-31', '2026-08-25'),
            $this->product('silk-cowl-evening-dress', 'Maison Élan', 'Silk Cowl Evening Dress', 'black-gown.webp', '42% center', 940000, 2800000, 7200000, ['S', 'M', 'L'], '2026-10-01', '2027-12-31', '2026-08-24'),
            $this->product('architectural-white-blazer', 'Atelier Blanc', 'Architectural White Blazer', 'hero-campaign.webp', '67% center', 640000, 1800000, 4800000, ['XS', 'S', 'M', 'L'], '2026-08-01', '2027-12-31', '2026-08-23'),
            $this->product('velvet-peak-lapel-suit', 'Noir Homme', 'Velvet Peak Lapel Suit', 'hero-campaign.webp', '83% center', 970000, 3000000, 7600000, ['M', 'L', 'XL'], '2026-09-15', '2027-11-30', '2026-08-22'),
            $this->product('slate-draped-midi', 'Studio N°5', 'Slate Draped Midi', 'city-lookbook.webp', '32% center', 590000, 1600000, 4400000, ['XS', 'S', 'M'], '2026-08-01', '2027-09-30', '2026-08-21'),
            $this->product('monochrome-tuxedo-dress', 'Forme Privée', 'Monochrome Tuxedo Dress', 'city-lookbook.webp', '58% center', 780000, 2100000, 6100000, ['S', 'M', 'L'], '2026-08-20', '2027-12-31', '2026-08-20'),
            $this->product('black-organza-column', 'Forme Privée', 'Black Organza Column', 'black-gown.webp', '60% center', 860000, 2600000, 6700000, ['XS', 'S'], '2026-11-01', '2027-12-31', '2026-08-19'),
            $this->product('pearl-satin-co-ord', 'Étage Studio', 'Pearl Satin Co-ord', 'hero-campaign.webp', '63% center', 720000, 2000000, 5500000, ['S', 'M', 'L'], '2026-08-01', '2027-06-30', '2026-08-18'),
            $this->product('charcoal-sculpted-jacket', 'Étage Studio', 'Charcoal Sculpted Jacket', 'city-lookbook.webp', '76% center', 610000, 1700000, 4900000, ['XS', 'S', 'M', 'L'], '2026-08-01', '2027-12-31', '2026-08-17'),
        ]);
    }

    /**
     * Build one product-card payload.
     *
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
        string $availableFrom,
        string $availableTo,
        string $createdAt,
    ): array {
        return [
            'id' => $id,
            'brand' => $brand,
            'name' => $name,
            'image' => asset('images/editorial/'.$image),
            'position' => $position,
            'url' => route('products.show', $id),
            'status' => 'CÓ SẴN',
            'rentalPrice' => $rentalPrice,
            'deposit' => $deposit,
            'purchasePrice' => $purchasePrice,
            'sizes' => $sizes,
            'availableFrom' => $availableFrom,
            'availableTo' => $availableTo,
            'createdAt' => $createdAt,
        ];
    }
}
