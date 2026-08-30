<div>
    <div x-show="sidebarOpen" x-cloak x-transition.opacity class="fixed inset-0 z-40 bg-ink/50 lg:hidden" aria-hidden="true" @click="sidebarOpen = false"></div>

    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col border-r border-line bg-paper transition-transform duration-200 lg:translate-x-0"
        aria-label="Điều hướng quản trị"
    >
        <div class="flex h-20 shrink-0 items-center justify-between border-b border-line px-6">
            <a href="{{ route('admin.dashboard') }}" class="font-display text-lg tracking-[0.18em]" aria-label="LUXE ROTATE Admin">
                LUXE<span class="font-sans text-xs">/</span>ROTATE
            </a>
            <button type="button" class="flex size-11 items-center justify-end lg:hidden" aria-label="Đóng điều hướng quản trị" @click="sidebarOpen = false">
                <svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 5l14 14M19 5 5 19" /></svg>
            </button>
        </div>

        <div class="flex min-h-0 flex-1 flex-col overflow-y-auto px-4 py-6">
            <p class="px-3 text-[10px] font-semibold uppercase tracking-[0.18em] text-muted">Quản trị hệ thống</p>
            <nav class="mt-3" aria-label="Chức năng quản trị">
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex min-h-12 items-center gap-3 border-l-2 px-3 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'border-ink bg-fog text-ink' : 'border-transparent text-muted hover:bg-fog hover:text-ink' }}">
                            <svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4h6v6H4V4Zm10 0h6v6h-6V4ZM4 14h6v6H4v-6Zm10 0h6v6h-6v-6Z" /></svg>
                            Tổng quan
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="mt-auto border-t border-line pt-5">
                <a href="{{ route('home') }}" class="flex min-h-12 items-center gap-3 px-3 text-sm text-muted hover:bg-fog hover:text-ink">
                    <svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 5h5v5M19 5l-8 8" /><path d="M19 13v6H5V5h6" /></svg>
                    Xem cửa hàng
                </a>
            </div>
        </div>
    </aside>
</div>