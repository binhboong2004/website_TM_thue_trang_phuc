<div
    x-data="{
        show: false,
        message: @js(session('success')),
        timeoutId: null,
        displayToast(newMessage) {
            this.message = newMessage;
            this.show = true;
            clearTimeout(this.timeoutId);
            this.timeoutId = setTimeout(() => this.show = false, 4000);
        },
    }"
    x-init="if (message) { displayToast(message) }"
    x-show="show"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="translate-y-10 opacity-0"
    x-transition:enter-end="translate-y-0 opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="translate-y-0 opacity-100"
    x-transition:leave-end="translate-y-10 opacity-0"
    @@show-toast.window="displayToast($event.detail.message)"
    class="fixed bottom-8 right-8 z-[100] flex max-w-[calc(100vw-4rem)] items-center gap-3 rounded-none bg-black px-8 py-4 text-[10px] font-medium uppercase tracking-widest text-white shadow-2xl"
    role="status"
    aria-live="polite"
    aria-atomic="true"
>
    <svg
        class="size-4 shrink-0"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="1.5"
        stroke-linecap="round"
        stroke-linejoin="round"
        aria-hidden="true"
    >
        <path d="m5 12 4 4L19 6" />
    </svg>
    <span x-text="message"></span>
</div>
