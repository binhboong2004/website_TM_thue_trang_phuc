@props([
    'rentalItems' => session('cart.rentals', []),
    'purchaseItems' => session('cart.purchases', []),
])

<div
    x-data="{
        open: false,
        lastFocusedElement: null,
        openDrawer() {
            this.lastFocusedElement = document.activeElement;
            this.open = true;
            this.$nextTick(() => this.$refs.closeButton?.focus());
        },
        closeDrawer() {
            this.open = false;
            this.$nextTick(() => this.lastFocusedElement?.focus());
        },
    }"
    x-init="$store.cart.hydrate(@js($rentalItems), @js($purchaseItems))"
    @cart-drawer-open.window="openDrawer()"
    @keydown.escape.window="if (open) closeDrawer()"
    x-show="open"
    x-cloak
    class="relative z-[90]"
    aria-labelledby="cart-drawer-title"
>
    <div
        x-show="open"
        x-transition:enter="transition-opacity ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-ink/55"
        aria-hidden="true"
        @click="closeDrawer()"
    ></div>

    <aside
        x-show="open"
        x-trap.noscroll="open"
        x-transition:enter="transform transition ease-out duration-[250ms]"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in duration-[180ms]"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 right-0 flex w-full max-w-[34rem] flex-col bg-paper"
        role="dialog"
        aria-modal="true"
    >
        <header class="flex min-h-20 shrink-0 items-center justify-between border-b border-line px-5 sm:px-7">
            <div>
                <p class="eyebrow text-muted">Đơn hàng kết hợp</p>
                <h2 id="cart-drawer-title" class="mt-1 font-sans text-base font-medium">Giỏ hàng <span class="text-muted" x-text="`(${$store.cart.itemCount})`"></span></h2>
            </div>
            <button x-ref="closeButton" type="button" class="flex size-11 items-center justify-end" aria-label="Đóng giỏ hàng" @click="closeDrawer()">
                <svg aria-hidden="true" class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 5l14 14M19 5 5 19" /></svg>
            </button>
        </header>

        <div class="min-h-0 flex-1 overflow-y-auto overscroll-contain px-5 py-7 sm:px-7">
            <section aria-labelledby="rental-cart-title">
                <div class="flex items-end justify-between gap-4 border-b border-ink pb-3">
                    <div>
                        <p class="eyebrow text-muted">Ngăn 01</p>
                        <h3 id="rental-cart-title" class="mt-1 font-sans text-sm font-semibold uppercase tracking-[0.1em]">Đồ thuê theo lịch</h3>
                    </div>
                    <span class="text-xs text-muted" x-text="`${$store.cart.rentalItems.length} thiết kế`"></span>
                </div>

                <div class="divide-y divide-line">
                    <template x-for="(item, index) in $store.cart.rentalItems" :key="item.id">
                        <article class="grid grid-cols-[5.5rem_1fr] gap-4 py-5 sm:grid-cols-[7rem_1fr]">
                            <a :href="item.url" class="block aspect-[3/4] overflow-hidden bg-fog">
                                <img :src="item.image" :alt="item.name" class="h-full w-full object-cover" width="224" height="299">
                            </a>
                            <div class="min-w-0">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-muted" x-text="item.brand"></p>
                                        <h4 class="mt-1 text-sm font-medium leading-5" x-text="item.name"></h4>
                                    </div>
                                    <button type="button" class="-mr-2 flex min-h-11 shrink-0 items-start px-2 pt-0.5 text-[10px] uppercase tracking-[0.12em] text-muted underline underline-offset-4 hover:text-ink" @click="$store.cart.removeRental(index)">Xóa</button>
                                </div>
                                <dl class="mt-3 grid grid-cols-2 gap-x-3 gap-y-2 text-xs">
                                    <div><dt class="text-muted">Size</dt><dd class="mt-0.5 font-medium" x-text="item.size"></dd></div>
                                    <div><dt class="text-muted">Thời hạn</dt><dd class="mt-0.5 font-medium" x-text="`${item.days} ngày`"></dd></div>
                                    <div class="col-span-2"><dt class="text-muted">Ngày nhận — ngày trả</dt><dd class="mt-0.5 font-medium tabular-nums" x-text="`${item.startDate} — ${item.endDate}`"></dd></div>
                                </dl>
                                <div class="mt-4 space-y-1 border-t border-line pt-3 text-xs tabular-nums">
                                    <div class="flex justify-between gap-3"><span>Tiền thuê</span><span class="font-medium" x-text="$store.cart.formatCurrency(item.rentalTotal)"></span></div>
                                    <div class="flex justify-between gap-3 text-muted"><span>Cọc hoàn lại · đóng băng</span><span x-text="$store.cart.formatCurrency(item.deposit)"></span></div>
                                </div>
                            </div>
                        </article>
                    </template>
                </div>

                <div x-show="$store.cart.rentalItems.length === 0" class="border-b border-line py-7 text-sm text-muted">
                    <p>Chưa có thiết kế thuê trong giỏ.</p>
                    <a href="{{ route('client.shop', ['purpose' => 'rental']) }}" class="text-link mt-2 text-ink">Chọn đồ thuê</a>
                </div>
            </section>

            <section class="mt-9" aria-labelledby="purchase-cart-title">
                <div class="flex items-end justify-between gap-4 border-b border-ink pb-3">
                    <div>
                        <p class="eyebrow text-muted">Ngăn 02</p>
                        <h3 id="purchase-cart-title" class="mt-1 font-sans text-sm font-semibold uppercase tracking-[0.1em]">Sản phẩm mua đứt</h3>
                    </div>
                    <span class="text-xs text-muted" x-text="`${$store.cart.purchaseItems.length} thiết kế`"></span>
                </div>

                <div class="divide-y divide-line">
                    <template x-for="(item, index) in $store.cart.purchaseItems" :key="item.id">
                        <article class="grid grid-cols-[5.5rem_1fr] gap-4 py-5 sm:grid-cols-[7rem_1fr]">
                            <a :href="item.url" class="block aspect-[3/4] overflow-hidden bg-fog">
                                <img :src="item.image" :alt="item.name" class="h-full w-full object-cover" width="224" height="299">
                            </a>
                            <div class="min-w-0">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-muted" x-text="item.brand"></p>
                                        <h4 class="mt-1 text-sm font-medium leading-5" x-text="item.name"></h4>
                                    </div>
                                    <button type="button" class="-mr-2 flex min-h-11 shrink-0 items-start px-2 pt-0.5 text-[10px] uppercase tracking-[0.12em] text-muted underline underline-offset-4 hover:text-ink" @click="$store.cart.removePurchase(index)">Xóa</button>
                                </div>
                                <dl class="mt-3 grid grid-cols-2 gap-3 text-xs">
                                    <div><dt class="text-muted">Size</dt><dd class="mt-0.5 font-medium" x-text="item.size"></dd></div>
                                    <div><dt class="text-muted">Đơn giá</dt><dd class="mt-0.5 font-medium tabular-nums" x-text="$store.cart.formatCurrency(item.unitPrice)"></dd></div>
                                </dl>
                                <div class="mt-4 flex items-center justify-between gap-4 border-t border-line pt-3">
                                    <div class="inline-grid grid-cols-3 border border-line" aria-label="Điều chỉnh số lượng">
                                        <button type="button" class="flex size-9 items-center justify-center text-base disabled:cursor-not-allowed disabled:opacity-40" :disabled="item.quantity <= 1" @click="$store.cart.updateQuantity(index, -1)" aria-label="Giảm số lượng">−</button>
                                        <span class="flex size-9 items-center justify-center border-x border-line text-xs tabular-nums" x-text="item.quantity"></span>
                                        <button type="button" class="flex size-9 items-center justify-center text-base" @click="$store.cart.updateQuantity(index, 1)" aria-label="Tăng số lượng">+</button>
                                    </div>
                                    <p class="text-sm font-medium tabular-nums" x-text="$store.cart.formatCurrency(item.unitPrice * item.quantity)"></p>
                                </div>
                            </div>
                        </article>
                    </template>
                </div>

                <div x-show="$store.cart.purchaseItems.length === 0" class="border-b border-line py-7 text-sm text-muted">
                    <p>Chưa có sản phẩm mua đứt trong giỏ.</p>
                    <a href="{{ route('client.shop', ['purpose' => 'purchase']) }}" class="text-link mt-2 text-ink">Khám phá sản phẩm</a>
                </div>
            </section>
        </div>

        <footer class="shrink-0 border-t border-ink bg-paper px-5 py-5 sm:px-7">
            <dl class="space-y-2 text-sm tabular-nums">
                <div class="flex justify-between gap-4"><dt>Tạm tính thuê & mua</dt><dd class="font-medium" x-text="$store.cart.formatCurrency($store.cart.payableSubtotal)"></dd></div>
                <div class="flex justify-between gap-4 text-muted"><dt>Tiền cọc trung gian · đóng băng</dt><dd x-text="$store.cart.formatCurrency($store.cart.frozenDeposit)"></dd></div>
                <div class="flex justify-between gap-4 border-t border-line pt-3 text-base"><dt class="font-medium">Thanh toán dự kiến</dt><dd class="font-semibold" x-text="$store.cart.formatCurrency($store.cart.payableSubtotal + $store.cart.frozenDeposit)"></dd></div>
            </dl>
            <p class="mt-3 text-[11px] leading-5 text-muted">Tiền cọc được tách riêng, đóng băng qua cổng thanh toán và hoàn sau khi sản phẩm thuê vượt qua kiểm định.</p>

            <template x-if="$store.cart.itemCount > 0">
                <a href="{{ route('checkout') }}" class="button-primary mt-4 w-full">Tiếp tục thanh toán</a>
            </template>
            <template x-if="$store.cart.itemCount === 0">
                <button type="button" class="button-primary mt-4 w-full cursor-not-allowed opacity-40" disabled>Giỏ hàng đang trống</button>
            </template>
        </footer>
    </aside>
</div>