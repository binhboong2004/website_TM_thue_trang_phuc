<header class="sticky top-0 z-30 flex h-20 items-center justify-between border-b border-line bg-paper px-4 sm:px-6 lg:px-10">
    <div class="flex items-center gap-3">
        <button type="button" class="flex size-11 items-center justify-start lg:hidden" aria-label="Mở điều hướng quản trị" :aria-expanded="sidebarOpen" @click="sidebarOpen = true">
            <svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 7h18M3 12h18M3 17h18" /></svg>
        </button>
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-muted">Workspace</p>
            <p class="text-sm font-medium">Administration</p>
        </div>
    </div>

    <div class="flex items-center gap-3 border-l border-line pl-4 sm:pl-6">
        <div class="hidden text-right sm:block">
            <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
            <p class="text-xs text-muted">Quản trị viên</p>
        </div>
        <span class="flex size-10 items-center justify-center bg-ink text-xs font-semibold uppercase text-paper" aria-hidden="true">
            {{ str(auth()->user()->name)->substr(0, 2) }}
        </span>
    </div>
</header>