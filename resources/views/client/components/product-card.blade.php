@props(['product'])

@php
    $productId = data_get($product, 'id');
    $productUrl = data_get($product, 'url');
    $productImage = data_get($product, 'image');
    $productPosition = data_get($product, 'position', 'center');
    $productBrand = data_get($product, 'brand');
    $productName = data_get($product, 'name');
    $productStatus = data_get($product, 'status', 'CÓ SẴN');
    $rentalPrice = (int) data_get($product, 'rentalPrice', data_get($product, 'rental_price'));
    $deposit = (int) data_get($product, 'deposit');
    $purchasePrice = (int) data_get($product, 'purchasePrice', data_get($product, 'purchase_price'));
    $sizes = data_get($product, 'sizes', []);
    $modalTitleId = 'rental-modal-title-'.$productId;
    $isAuthenticated = auth()->check();
    $isFavorited = $isAuthenticated && auth()->user()->favoriteProducts->contains($productId);

    $cartProduct = [
        'id' => $productId,
        'url' => $productUrl,
        'image' => $productImage,
        'brand' => $productBrand,
        'name' => $productName,
        'rentalPrice' => $rentalPrice,
        'deposit' => $deposit,
        'purchasePrice' => $purchasePrice,
    ];
@endphp

<article
    class="group min-w-0"
    x-data="{
        visible: true,
        rentalOpen: false,
        rentalStart: '',
        rentalEnd: '',
        rentalSize: '',
        purchaseSize: @js($sizes[0] ?? ''),
        product: @js($cartProduct),
        lastFocusedElement: null,
        get today() {
            const now = new Date();
            const offset = now.getTimezoneOffset();

            return new Date(now.getTime() - (offset * 60 * 1000)).toISOString().slice(0, 10);
        },
        get rentalIsValid() {
            return this.rentalStart !== ''
                && this.rentalEnd !== ''
                && this.rentalSize !== ''
                && new Date(`${this.rentalEnd}T00:00:00`) >= new Date(`${this.rentalStart}T00:00:00`);
        },
        openRentalModal() {
            this.lastFocusedElement = document.activeElement;
            this.rentalOpen = true;
            this.$nextTick(() => this.$refs.rentalStartInput?.focus());
        },
        closeRentalModal() {
            this.rentalOpen = false;
            this.$nextTick(() => this.lastFocusedElement?.focus());
        },
        addPurchaseToCart() {
            this.$store.cart.addPurchase(this.product, this.purchaseSize);
            this.$dispatch('cart-drawer-open');
        },
        confirmRental() {
            if (!this.rentalIsValid) {
                return;
            }

            this.$store.cart.addRental(this.product, {
                startDate: this.rentalStart,
                endDate: this.rentalEnd,
                size: this.rentalSize,
            });
            this.closeRentalModal();
            this.$nextTick(() => this.$dispatch('cart-drawer-open'));
        },
    }"
    x-show="visible"
    x-transition.opacity.duration.300ms
>
    <div class="relative aspect-[3/4] overflow-hidden bg-[#F7F7F7]">
        <a href="{{ $productUrl }}" class="block h-full overflow-hidden" aria-label="Xem {{ $productName }}">
            <img
                src="{{ $productImage }}"
                alt="{{ $productName }} của {{ $productBrand }}"
                class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-[1.025] motion-reduce:transition-none"
                style="object-position: {{ $productPosition }}"
                width="720"
                height="960"
                loading="lazy"
                decoding="async"
            >
        </a>

        <span class="absolute left-3 top-3 rounded-none border border-neutral-300 bg-white/80 px-2.5 py-1 text-[10px] font-medium uppercase tracking-widest text-neutral-900 backdrop-blur-sm">
            {{ $productStatus }}
        </span>

        <button
            type="button"
            x-data="{ favorited: @js($isFavorited), processing: false }"
            class="absolute top-4 right-4 z-10 p-2 focus:outline-none transition-transform duration-300 hover:scale-110"
            :aria-pressed="favorited"
            :aria-label="favorited ? @js('Bỏ '.$productName.' khỏi yêu thích') : @js('Thêm '.$productName.' vào yêu thích')"
            :disabled="processing"
            @click.prevent="
                if (!@js($isAuthenticated)) {
                    window.location.href = @js(route('login'));
                    return;
                }

                processing = true;

                fetch(@js(route('wishlist.toggle')), {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': @js(csrf_token()),
                    },
                    body: JSON.stringify({ product_id: @js($productId) }),
                })
                    .then(async response => {
                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'Không thể cập nhật danh sách yêu thích');
                        }

                        return data;
                    })
                    .then(data => {
                        favorited = data.status === 'added';
                        $dispatch('show-toast', { message: data.message });

                        const isWishlistPage = @js(request()->routeIs('account.wishlist'));

                        if (data.status === 'removed' && isWishlistPage) {
                            visible = false;
                        }
                    })
                    .catch(error => {
                        $dispatch('show-toast', { message: error.message });
                    })
                    .finally(() => {
                        processing = false;
                    });
            "
        >
            <svg
                aria-hidden="true"
                class="size-5 transition-colors duration-300 motion-reduce:transition-none"
                :class="favorited ? 'fill-white text-white drop-shadow-[0_2px_8px_rgba(0,0,0,0.5)]' : 'fill-transparent text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.6)] hover:fill-white/30'"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.5"
            >
                <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.5 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z" />
            </svg>
        </button>

        <div class="absolute inset-x-0 bottom-0 grid translate-y-0 grid-cols-2 opacity-100 transition-all duration-300 ease-out motion-reduce:transition-none md:translate-y-2 md:opacity-0 md:group-focus-within:translate-y-0 md:group-focus-within:opacity-100 md:group-hover:translate-y-0 md:group-hover:opacity-100">
            <button
                type="button"
                class="flex min-h-12 items-center justify-center border border-neutral-950 bg-white px-2 text-[10px] font-semibold uppercase tracking-[0.16em] text-neutral-950 transition-colors hover:bg-neutral-100 focus-visible:z-10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-[-3px] focus-visible:outline-neutral-950 sm:text-[11px]"
                @click="openRentalModal()"
            >
                THUÊ ĐỒ
            </button>
            <button
                type="button"
                class="flex min-h-12 items-center justify-center border border-neutral-950 bg-neutral-950 px-2 text-[10px] font-semibold uppercase tracking-[0.16em] text-white transition-colors hover:bg-neutral-800 focus-visible:z-10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-[-3px] focus-visible:outline-white sm:text-[11px]"
                @click="addPurchaseToCart()"
            >
                MUA NGAY
            </button>
        </div>
    </div>

    <div class="pt-4">
        <p class="text-xs font-medium uppercase tracking-widest text-neutral-500">{{ $productBrand }}</p>
        <h3 class="mt-1 min-w-0">
            <a href="{{ $productUrl }}" class="block truncate font-display text-base leading-6 text-neutral-900 group-hover:underline group-hover:underline-offset-4">
                {{ $productName }}
            </a>
        </h3>

        <div class="mt-3 space-y-2 border-t border-neutral-200 pt-3 tabular-nums">
            <div>
                <p class="text-sm font-semibold text-neutral-950">Thuê: {{ number_format($rentalPrice, 0, ',', '.') }}đ <span class="font-normal text-neutral-500">/ ngày</span></p>
                <p class="mt-1 text-[10px] leading-4 text-neutral-500 sm:text-[11px]">(Cọc: {{ number_format($deposit, 0, ',', '.') }}đ — Hoàn sau khi trả đồ)</p>
            </div>
            <p class="text-xs text-neutral-600">Mua đứt: {{ number_format($purchasePrice, 0, ',', '.') }}đ</p>
        </div>

        <div class="mt-4 flex flex-wrap gap-1.5" aria-label="Kích cỡ khả dụng">
            @foreach ($sizes as $size)
                <span class="inline-flex min-w-8 items-center justify-center border border-neutral-300 px-2 py-1 text-[10px] font-medium uppercase tracking-[0.12em] text-neutral-700">{{ $size }}</span>
            @endforeach
        </div>
    </div>

    <template x-teleport="body">
        <div
            x-show="rentalOpen"
            x-cloak
            class="fixed inset-0 z-[100]"
            @keydown.escape.window="if (rentalOpen) closeRentalModal()"
        >
            <div
                x-show="rentalOpen"
                x-transition.opacity.duration.200ms
                class="absolute inset-0 bg-neutral-950/60"
                aria-hidden="true"
                @click="closeRentalModal()"
            ></div>

            <section
                x-show="rentalOpen"
                x-trap.noscroll="rentalOpen"
                x-transition:enter="transition ease-out duration-300 motion-reduce:transition-none"
                x-transition:enter-start="translate-y-4 opacity-0"
                x-transition:enter-end="translate-y-0 opacity-100"
                x-transition:leave="transition ease-in duration-200 motion-reduce:transition-none"
                x-transition:leave-start="translate-y-0 opacity-100"
                x-transition:leave-end="translate-y-4 opacity-0"
                class="absolute inset-x-0 bottom-0 max-h-[92svh] overflow-y-auto bg-white px-5 py-6 sm:left-1/2 sm:top-1/2 sm:bottom-auto sm:w-[min(100%-2rem,34rem)] sm:-translate-x-1/2 sm:-translate-y-1/2 sm:px-8 sm:py-8"
                role="dialog"
                aria-modal="true"
                aria-labelledby="{{ $modalTitleId }}"
            >
                <header class="flex items-start justify-between gap-6 border-b border-neutral-200 pb-5">
                    <div>
                        <p class="text-[10px] font-medium uppercase tracking-[0.18em] text-neutral-500">Giữ lịch thiết kế</p>
                        <h2 id="{{ $modalTitleId }}" class="mt-2 font-display text-2xl text-neutral-950">{{ $productName }}</h2>
                    </div>
                    <button type="button" class="-mr-2 flex size-11 shrink-0 items-center justify-center" aria-label="Đóng cửa sổ chọn lịch thuê" @click="closeRentalModal()">
                        <svg aria-hidden="true" class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M5 5l14 14M19 5 5 19" /></svg>
                    </button>
                </header>

                <div class="mt-6 grid gap-5 sm:grid-cols-2">
                    <label class="block text-xs font-medium uppercase tracking-[0.1em] text-neutral-700">
                        Ngày nhận
                        <input x-ref="rentalStartInput" x-model="rentalStart" type="date" :min="today" class="mt-2 min-h-12 w-full rounded-none border border-neutral-300 bg-white px-3 text-sm normal-case tracking-normal text-neutral-950 focus:border-neutral-950 focus:outline-none focus:ring-1 focus:ring-neutral-950">
                    </label>
                    <label class="block text-xs font-medium uppercase tracking-[0.1em] text-neutral-700">
                        Ngày trả
                        <input x-model="rentalEnd" type="date" :min="rentalStart || today" class="mt-2 min-h-12 w-full rounded-none border border-neutral-300 bg-white px-3 text-sm normal-case tracking-normal text-neutral-950 focus:border-neutral-950 focus:outline-none focus:ring-1 focus:ring-neutral-950">
                    </label>
                </div>

                <fieldset class="mt-6">
                    <legend class="text-xs font-medium uppercase tracking-[0.1em] text-neutral-700">Chọn kích cỡ</legend>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($sizes as $size)
                            <button
                                type="button"
                                class="flex min-h-11 min-w-12 items-center justify-center border px-3 text-xs font-medium transition-colors"
                                :class="rentalSize === @js($size) ? 'border-neutral-950 bg-neutral-950 text-white' : 'border-neutral-300 bg-white text-neutral-950 hover:border-neutral-950'"
                                :aria-pressed="rentalSize === @js($size)"
                                @click="rentalSize = @js($size)"
                            >
                                {{ $size }}
                            </button>
                        @endforeach
                    </div>
                </fieldset>

                <dl class="mt-7 space-y-2 border-y border-neutral-200 py-4 text-sm tabular-nums">
                    <div class="flex justify-between gap-4"><dt>Đơn giá thuê</dt><dd class="font-medium">{{ number_format($rentalPrice, 0, ',', '.') }}đ / ngày</dd></div>
                    <div class="flex justify-between gap-4 text-neutral-600"><dt>Cọc hoàn lại</dt><dd>{{ number_format($deposit, 0, ',', '.') }}đ</dd></div>
                </dl>

                <p x-show="rentalStart && rentalEnd && !rentalIsValid" class="mt-4 text-xs text-red-700" role="alert">Ngày trả phải bằng hoặc sau ngày nhận.</p>

                <button
                    type="button"
                    class="mt-6 flex min-h-12 w-full items-center justify-center bg-neutral-950 px-5 text-xs font-semibold uppercase tracking-[0.16em] text-white transition-opacity disabled:cursor-not-allowed disabled:opacity-35"
                    :disabled="!rentalIsValid"
                    @click="confirmRental()"
                >
                    Xác nhận thuê đồ
                </button>
            </section>
        </div>
    </template>
</article>
