<div
    id="ai-stylist-widget"
    class="fixed bottom-6 right-6 z-[80]"
    x-data="{ open: false }"
    @ai-stylist-open.window="open = true; $nextTick(() => $refs.chatInput?.focus())"
    @keydown.escape.window="if (open) { open = false; $nextTick(() => $refs.launcher?.focus()) }"
>
    <section
        id="ai-stylist-dialog"
        x-show="open"
        x-cloak
        x-trap="open"
        x-transition:enter="transition duration-200 ease-out motion-reduce:transition-none"
        x-transition:enter-start="translate-y-2 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition duration-150 ease-in motion-reduce:transition-none"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-2 opacity-0"
        class="absolute bottom-[4.25rem] right-0 flex h-[min(31.25rem,calc(100dvh-7rem))] w-[min(24rem,calc(100vw-3rem))] flex-col border border-neutral-200 bg-white shadow-2xl"
        role="dialog"
        aria-modal="false"
        aria-labelledby="ai-stylist-dialog-title"
        aria-describedby="ai-stylist-dialog-description"
    >
        <header class="flex min-h-20 shrink-0 items-center justify-between border-b border-neutral-200 px-5">
            <div class="min-w-0 pr-4">
                <p class="text-[9px] font-semibold uppercase tracking-[0.2em] text-neutral-500">Private styling</p>
                <h2 id="ai-stylist-dialog-title" class="mt-1 font-display text-xl text-neutral-950">Trợ Lý Phong Cách</h2>
            </div>
            <button
                type="button"
                class="flex size-11 shrink-0 items-center justify-end text-neutral-700 transition-colors hover:text-black"
                aria-label="Đóng Trợ Lý Phong Cách"
                @click="open = false; $nextTick(() => $refs.launcher?.focus())"
            >
                <svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25">
                    <path d="M5 5l14 14M19 5 5 19" />
                </svg>
            </button>
        </header>

        <p id="ai-stylist-dialog-description" class="sr-only">Trao đổi với trợ lý về dịp, phong cách, vóc dáng và ngân sách của bạn.</p>

        <div
            class="flex min-h-0 flex-1 flex-col"
            x-data="{
                draft: '',
                isReplying: false,
                messages: [],
                sendMessage() {
                    const content = this.draft.trim();

                    if (!content || this.isReplying) {
                        return;
                    }

                    this.messages.push({ role: 'user', text: content });
                    this.draft = '';
                    this.isReplying = true;
                    this.scrollToLatest();

                    window.setTimeout(() => {
                        this.messages.push({
                            role: 'ai',
                            text: 'Tôi đã ghi nhận. Bạn có thể cho tôi biết thêm chiều cao, size thường mặc hoặc phong cách mong muốn để lựa chọn chính xác hơn.'
                        });
                        this.isReplying = false;
                        this.scrollToLatest();
                    }, 600);
                },
                scrollToLatest() {
                    this.$nextTick(() => {
                        const messageList = this.$refs.messageList;
                        messageList.scrollTo({ top: messageList.scrollHeight, behavior: 'smooth' });
                    });
                }
            }"
        >
            <div
                x-ref="messageList"
                class="min-h-0 flex-1 space-y-4 overflow-y-auto overscroll-contain px-5 py-5"
                role="log"
                aria-live="polite"
                aria-label="Nội dung trò chuyện"
            >
                <div class="flex items-start gap-3">
                    <span class="flex size-7 shrink-0 items-center justify-center bg-black text-[9px] font-semibold tracking-wider text-white" aria-hidden="true">AI</span>
                    <p class="max-w-[82%] bg-neutral-50 px-4 py-3 text-sm leading-6 text-neutral-800">
                        Chào bạn. Hãy kể cho tôi về dịp sắp tới, địa điểm và ngân sách mong muốn.
                    </p>
                </div>

                <div class="flex justify-end">
                    <p class="max-w-[82%] border border-black bg-white px-4 py-3 text-sm leading-6 text-neutral-950">
                        Tôi cần một thiết kế thanh lịch cho tiệc cưới buổi tối.
                    </p>
                </div>

                <template x-for="(message, index) in messages" :key="index">
                    <div class="flex items-start gap-3" :class="message.role === 'user' ? 'justify-end' : 'justify-start'">
                        <span
                            x-show="message.role === 'ai'"
                            class="flex size-7 shrink-0 items-center justify-center bg-black text-[9px] font-semibold tracking-wider text-white"
                            aria-hidden="true"
                        >AI</span>
                        <p
                            class="max-w-[82%] px-4 py-3 text-sm leading-6"
                            :class="message.role === 'user' ? 'border border-black bg-white text-neutral-950' : 'bg-neutral-50 text-neutral-800'"
                            x-text="message.text"
                        ></p>
                    </div>
                </template>

                <div x-show="isReplying" class="flex items-center gap-3" role="status">
                    <span class="flex size-7 items-center justify-center bg-black text-[9px] font-semibold tracking-wider text-white" aria-hidden="true">AI</span>
                    <span class="bg-neutral-50 px-4 py-3 text-xs text-neutral-500">Đang soạn gợi ý…</span>
                </div>
            </div>

            <form class="shrink-0 border-t border-neutral-200 bg-white px-5 py-4" @submit.prevent="sendMessage()">
                <label for="global-ai-stylist-input" class="text-[9px] font-semibold uppercase tracking-[0.16em] text-neutral-500">
                    Tin nhắn của bạn
                </label>
                <div class="mt-1 flex items-end border-b border-black">
                    <textarea
                        id="global-ai-stylist-input"
                        x-ref="chatInput"
                        x-model="draft"
                        rows="1"
                        class="max-h-24 min-h-12 min-w-0 flex-1 resize-none border-0 bg-transparent py-3 pr-3 text-base leading-6 text-neutral-950 outline-none placeholder:text-neutral-400 focus:ring-0"
                        placeholder="Ví dụ: Váy dự tiệc dưới 1 triệu"
                        @keydown.enter="if (!$event.shiftKey) { $event.preventDefault(); sendMessage(); }"
                    ></textarea>
                    <button
                        type="submit"
                        class="flex size-12 shrink-0 items-center justify-end text-black transition-opacity disabled:cursor-not-allowed disabled:opacity-30"
                        :disabled="!draft.trim() || isReplying"
                        aria-label="Gửi tin nhắn"
                    >
                        <svg aria-hidden="true" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25">
                            <path d="M5 12h13M13 6l6 6-6 6" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <button
        x-ref="launcher"
        type="button"
        class="flex min-h-12 items-center gap-2.5 bg-black px-4 text-[10px] font-semibold uppercase tracking-[0.16em] text-white shadow-lg transition duration-200 hover:scale-105 hover:shadow-xl focus-visible:outline-white focus-visible:outline-offset-[-4px] motion-reduce:transform-none motion-reduce:transition-none sm:px-5"
        aria-controls="ai-stylist-dialog"
        :aria-expanded="open"
        @click="open = !open; if (open) { $nextTick(() => $refs.chatInput?.focus()) }"
    >
        <svg aria-hidden="true" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25">
            <path d="m12 3 1.3 4.2L17.5 8.5l-4.2 1.3L12 14l-1.3-4.2-4.2-1.3 4.2-1.3L12 3ZM18 14l.8 2.2L21 17l-2.2.8L18 20l-.8-2.2L15 17l2.2-.8L18 14Z" />
        </svg>
        <span>AI Stylist</span>
    </button>
</div>