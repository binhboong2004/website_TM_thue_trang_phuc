@if (session('success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="translate-y-2 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-2 opacity-0"
        class="fixed bottom-8 left-1/2 z-[100] w-[calc(100%-2rem)] -translate-x-1/2 rounded-none border border-white/20 bg-black sm:w-auto"
        role="status"
        aria-live="polite"
        aria-atomic="true"
    >
        <p class="px-6 py-3 text-center text-xs tracking-wide text-white">
            {{ session('success') }}
        </p>
    </div>
@endif