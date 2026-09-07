<div>
    <div x-show="sidebarOpen" x-cloak x-transition.opacity class="fixed inset-0 z-40 bg-ink/50 lg:hidden" aria-hidden="true" @click="sidebarOpen = false"></div>

    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col border-r border-line bg-paper transition-transform duration-200 motion-reduce:transition-none lg:translate-x-0"
        aria-label="Điều hướng gian hàng"
    >
        <div class="flex h-20 shrink-0 items-center justify-between border-b border-line px-6">
            <a href="{{ route('shop.dashboard') }}" class="font-display text-lg tracking-[0.18em]" aria-label="LUXE ROTATE Shop">
                LUXE<span class="font-sans text-xs">/</span>ROTATE
            </a>
            <button type="button" class="flex size-11 items-center justify-end lg:hidden" aria-label="Đóng điều hướng gian hàng" @click="sidebarOpen = false">
                <svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 5l14 14M19 5 5 19" /></svg>
            </button>
        </div>

        <div class="flex min-h-0 flex-1 flex-col overflow-y-auto px-4 py-6">
            <p class="px-3 text-[10px] font-semibold uppercase tracking-[0.18em] text-muted">Seller workspace</p>
            <nav class="mt-3" aria-label="Chức năng người bán">
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('shop.dashboard') }}" class="flex min-h-12 items-center gap-3 border-l-2 px-3 text-sm font-medium {{ request()->routeIs('shop.dashboard') ? 'border-ink bg-fog text-ink' : 'border-transparent text-muted hover:bg-fog hover:text-ink' }}">
                            <svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4h6v6H4V4Zm10 0h6v6h-6V4ZM4 14h6v6H4v-6Zm10 0h6v6h-6v-6Z" /></svg>
                            Tổng quan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('shop.products.index') }}" class="flex min-h-12 items-center gap-3 border-l-2 px-3 text-sm font-medium {{ request()->routeIs('shop.products.*') ? 'border-ink bg-fog text-ink' : 'border-transparent text-muted hover:bg-fog hover:text-ink' }}">
                            <svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5v-9Z" /><path d="m4 7.5 8 4.5 8-4.5M12 12v9" /></svg>
                            Mẫu thiết kế
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('shop.inventory.index') }}" class="flex min-h-12 items-center gap-3 border-l-2 px-3 text-sm font-medium {{ request()->routeIs('shop.inventory.*') ? 'border-ink bg-fog text-ink' : 'border-transparent text-muted hover:bg-fog hover:text-ink' }}">
                            <svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 8h16v12H4V8Z" /><path d="M7 4h10v4H7V4Zm2 8v4m3-4v4m3-4v4" /></svg>
                            Kho món đồ
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('shop.orders.index') }}" class="flex min-h-12 items-center gap-3 border-l-2 px-3 text-sm font-medium {{ request()->routeIs('shop.orders.*') ? 'border-ink bg-fog text-ink' : 'border-transparent text-muted hover:bg-fog hover:text-ink' }}">
                            <svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 3h12v18l-3-2-3 2-3-2-3 2V3Z" /><path d="M9 8h6M9 12h6" /></svg>
                            Đơn hàng
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="mt-8 border-t border-line pt-5">
                <a href="{{ route('shop.products.create') }}" class="button-primary w-full">Thêm mẫu thiết kế</a>
            </div>

            <div class="mt-auto border-t border-line pt-5">
                <a href="{{ route('client.shop') }}" class="flex min-h-12 items-center gap-3 px-3 text-sm text-muted hover:bg-fog hover:text-ink">
                    <svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 5h5v5M19 5l-8 8" /><path d="M19 13v6H5V5h6" /></svg>
                    Xem catalog công khai
                </a>
            </div>
        </div>
    </aside>
</div>
