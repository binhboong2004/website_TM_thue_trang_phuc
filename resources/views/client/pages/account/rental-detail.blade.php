@extends('client.layouts.account')

@php
    $rentalPageTitle = sprintf('Theo dõi đơn thuê %s | LUXE ROTATE', $order['code']);
    $rentalPageDescription = sprintf('Theo dõi vòng đời đơn thuê, trạng thái tiền cọc trung gian và hồ sơ đối soát của đơn %s.', $order['code']);
    $rentalCanonicalUrl = route('account.rentals.show', $order['code']);
@endphp

@section('title', $rentalPageTitle)
@section('meta_description', $rentalPageDescription)
@section('canonical', $rentalCanonicalUrl)
@section('robots', 'noindex, nofollow')

@section('account_content')
    <div
        class="min-w-0"
        x-data="rentalEvidence(@js(['deadline' => $order['refund_deadline']]))"
        x-init="init()"
    >
        <header class="mb-10">
            <p class="mb-3 text-[10px] font-medium uppercase tracking-widest text-neutral-500">
                Đơn thuê {{ $order['code'] }}
            </p>
            <h1 class="text-4xl font-serif mb-2">Theo dõi đơn thuê</h1>
            <p class="max-w-2xl text-sm leading-6 text-neutral-600">
                Theo dõi món đồ vật lý, hồ sơ đối soát và trạng thái tiền cọc trong cùng một luồng minh bạch.
            </p>
        </header>

        <div class="border border-neutral-200 p-6 mb-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-[10px] font-medium uppercase tracking-widest text-neutral-500">Trạng thái hiện tại</p>
                    <p class="mt-2 font-serif text-2xl text-black">Shop đang kiểm tra đồ trả</p>
                </div>
                <p class="self-start border border-neutral-300 px-3 py-2 text-[10px] font-medium uppercase tracking-widest text-neutral-700 sm:self-center">
                    Cập nhật hôm nay · 14:20
                </p>
            </div>
        </div>

        <section class="min-w-0 border border-neutral-200 p-6 mb-8" aria-labelledby="lifecycle-title">
            <div>
                <p class="text-[10px] font-medium uppercase tracking-widest text-neutral-500">Vòng đời đơn thuê</p>
                <h2 id="lifecycle-title" class="mt-2 font-serif text-2xl text-black">5 bước bảo vệ giao dịch</h2>
            </div>

            <ol class="mt-8 hidden min-w-0 grid-cols-5 xl:grid" aria-label="Tiến trình đơn thuê">
                @foreach ($steps as $index => $step)
                    @php
                        $number = $index + 1;
                        $isComplete = $number < $order['current_step'];
                        $isCurrent = $number === $order['current_step'];
                    @endphp
                    <li class="relative min-w-0 pr-3 last:pr-0" @if ($isCurrent) aria-current="step" @endif>
                        @if (! $loop->last)
                            <span
                                class="absolute left-10 right-0 top-5 h-px {{ $number < $order['current_step'] ? 'bg-black' : 'bg-neutral-200' }}"
                                aria-hidden="true"
                            ></span>
                        @endif
                        <span class="relative z-10 flex size-10 items-center justify-center border text-xs font-semibold {{ $isComplete ? 'border-black bg-black text-white' : ($isCurrent ? 'border-black bg-white text-black ring-4 ring-neutral-100' : 'border-neutral-200 bg-white text-neutral-500') }}">
                            @if ($isComplete)
                                <svg aria-hidden="true" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="m5 12 4 4L19 6" />
                                </svg>
                            @else
                                {{ $number }}
                            @endif
                        </span>
                        <p class="mt-4 pr-2 text-xs font-semibold leading-5 text-black">{{ $step['label'] }}</p>
                        <p class="mt-1 pr-2 text-[11px] leading-5 text-neutral-500">{{ $step['description'] }}</p>
                    </li>
                @endforeach
            </ol>

            <ol class="mt-8 space-y-0 xl:hidden" aria-label="Tiến trình đơn thuê trên thiết bị di động">
                @foreach ($steps as $index => $step)
                    @php
                        $number = $index + 1;
                        $isComplete = $number < $order['current_step'];
                        $isCurrent = $number === $order['current_step'];
                    @endphp
                    <li class="relative grid grid-cols-[2.5rem_minmax(0,1fr)] gap-4 pb-6 last:pb-0" @if ($isCurrent) aria-current="step" @endif>
                        @if (! $loop->last)
                            <span
                                class="absolute bottom-0 left-5 top-10 w-px {{ $number < $order['current_step'] ? 'bg-black' : 'bg-neutral-200' }}"
                                aria-hidden="true"
                            ></span>
                        @endif
                        <span class="relative z-10 flex size-10 items-center justify-center border text-xs font-semibold {{ $isComplete ? 'border-black bg-black text-white' : ($isCurrent ? 'border-black bg-white text-black ring-4 ring-neutral-100' : 'border-neutral-200 bg-white text-neutral-500') }}">
                            @if ($isComplete)
                                <svg aria-hidden="true" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="m5 12 4 4L19 6" />
                                </svg>
                            @else
                                {{ $number }}
                            @endif
                        </span>
                        <div class="min-w-0 pt-1">
                            <p class="text-sm font-semibold text-black">{{ $step['label'] }}</p>
                            <p class="mt-1 text-xs leading-5 text-neutral-500">{{ $step['description'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </section>

        <div class="grid min-w-0 gap-6 mb-8 xl:grid-cols-2">
            <section class="border border-neutral-200 p-6" aria-labelledby="order-summary-title">
                <header class="border-b border-neutral-200 pb-5">
                    <p class="text-[10px] font-medium uppercase tracking-widest text-neutral-500">Món đồ đang đối soát</p>
                    <h2 id="order-summary-title" class="mt-2 font-serif text-2xl text-black">Chi tiết kỳ thuê</h2>
                </header>

                <div class="grid gap-6 pt-6 sm:grid-cols-[7rem_minmax(0,1fr)]">
                    <img
                        src="{{ $order['product']['image'] }}"
                        alt="{{ $order['product']['name'] }}"
                        width="224"
                        height="299"
                        class="aspect-[3/4] w-28 bg-neutral-100 object-cover"
                    >
                    <div class="min-w-0">
                        <p class="text-[10px] font-medium uppercase tracking-widest text-neutral-500">{{ $order['product']['brand'] }}</p>
                        <h3 class="mt-2 font-serif text-2xl text-black">{{ $order['product']['name'] }}</h3>
                        <dl class="mt-5 grid gap-4 text-sm sm:grid-cols-2">
                            <div>
                                <dt class="text-xs text-neutral-500">Garment Item</dt>
                                <dd class="mt-1 font-semibold text-black">{{ $order['product']['garment_code'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-neutral-500">Kích cỡ</dt>
                                <dd class="mt-1 font-semibold text-black">{{ $order['product']['size'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-neutral-500">Kỳ thuê</dt>
                                <dd class="mt-1 font-medium text-black">{{ $order['rental_period'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-neutral-500">Mã vận đơn trả</dt>
                                <dd class="mt-1 font-medium text-black">{{ $order['return_tracking'] }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </section>

            <section class="space-y-4" aria-labelledby="escrow-title">
                <div class="border border-neutral-200 p-6">
                    <p class="text-[10px] font-medium uppercase tracking-widest text-neutral-500">Phí thuê đã thanh toán</p>
                    <div class="mt-3 flex items-end justify-between gap-5">
                        <h2 class="text-sm font-medium text-neutral-700">Tiền thuê + giao nhận</h2>
                        <p class="text-xl font-semibold tabular-nums text-black">
                            {{ number_format($order['financials']['rental_fee'] + $order['financials']['shipping_fee'], 0, ',', '.') }}đ
                        </p>
                    </div>
                    <dl class="mt-4 space-y-2 border-t border-neutral-100 pt-4 text-xs text-neutral-500">
                        <div class="flex justify-between gap-4">
                            <dt>Tiền thuê</dt>
                            <dd class="tabular-nums">{{ number_format($order['financials']['rental_fee'], 0, ',', '.') }}đ</dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt>Phí giao nhận</dt>
                            <dd class="tabular-nums">{{ number_format($order['financials']['shipping_fee'], 0, ',', '.') }}đ</dd>
                        </div>
                    </dl>
                </div>

                <div class="border border-neutral-200 p-6">
                    <p class="text-[10px] font-medium uppercase tracking-widest text-neutral-500">Escrow · Không chuyển cho Shop</p>
                    <div class="mt-3 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between sm:gap-5">
                        <h2 id="escrow-title" class="font-serif text-2xl text-black">Tiền cọc đang giữ trung gian</h2>
                        <p class="text-xl font-semibold tabular-nums text-black">
                            {{ number_format($order['financials']['deposit'], 0, ',', '.') }}đ
                        </p>
                    </div>
                    <div class="mt-5 border-t border-neutral-100 pt-5">
                        <p class="text-[10px] font-medium uppercase tracking-widest text-neutral-500">Tự động hoàn cọc dự kiến sau</p>
                        <p class="mt-2 font-serif text-3xl tabular-nums text-black" x-text="countdown" aria-live="polite">17:42:00</p>
                        <p class="mt-2 text-xs leading-5 text-neutral-500">
                            Hạn xử lý: {{ $order['refund_deadline_label'] }}. Nếu Shop không mở tranh chấp hợp lệ trong 24 giờ sau khi nhận hàng trả, hệ thống gửi lệnh hoàn cọc về phương thức thanh toán ban đầu.
                        </p>
                    </div>
                </div>
            </section>
        </div>

        <section class="border border-neutral-200 p-6" aria-labelledby="evidence-title">
            <div class="max-w-3xl">
                <p class="text-[10px] font-medium uppercase tracking-widest text-neutral-500">Hồ sơ bảo vệ tiền cọc</p>
                <h2 id="evidence-title" class="mt-2 font-serif text-3xl text-black">Đối soát hình ảnh</h2>
                <p class="mt-3 text-sm leading-6 text-neutral-600">
                    Chụp toàn cảnh, tem mã và cận cảnh tình trạng trang phục. Ảnh hoặc video có thời điểm rõ ràng giúp xử lý tranh chấp nhanh hơn.
                </p>
            </div>

            <form class="mt-8 grid gap-6 xl:grid-cols-2" @submit.prevent="saved = true">
                @foreach ([
                    'received' => ['Đối soát khi nhận đồ', 'Ghi nhận ngay trong 2 giờ từ lúc nhận'],
                    'returned' => ['Đối soát khi trả đồ', 'Chụp trước khi niêm phong gói trả'],
                ] as $bucket => [$title, $description])
                    <fieldset class="border border-neutral-200 p-5">
                        <legend class="px-1 text-base font-semibold text-black">{{ $title }}</legend>
                        <p class="mt-1 text-xs text-neutral-500">{{ $description }}</p>

                        <label class="mt-5 flex min-h-40 cursor-pointer flex-col items-center justify-center border border-dashed border-neutral-300 bg-neutral-50 px-5 text-center transition-colors hover:border-black hover:bg-white">
                            <svg aria-hidden="true" class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4">
                                <path d="M12 16V4m0 0L7.5 8.5M12 4l4.5 4.5" />
                                <path d="M5 13v6h14v-6" />
                            </svg>
                            <span class="mt-3 text-xs font-semibold uppercase tracking-widest">Chọn ảnh hoặc video</span>
                            <span class="mt-2 text-[11px] leading-5 text-neutral-500">JPG, PNG, WEBP hoặc MP4/MOV · tối đa 20 MB/tệp</span>
                            <input
                                type="file"
                                class="sr-only"
                                multiple
                                accept="image/jpeg,image/png,image/webp,video/mp4,video/quicktime"
                                @change="addFiles('{{ $bucket }}', $event.target.files); $event.target.value = ''"
                            >
                        </label>

                        <ul class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3" x-show="files.{{ $bucket }}.length">
                            <template x-for="file in files.{{ $bucket }}" :key="file.id">
                                <li class="relative border border-neutral-200 bg-neutral-50">
                                    <template x-if="file.isImage">
                                        <img :src="file.url" :alt="'Xem trước ' + file.name" class="aspect-square w-full object-cover">
                                    </template>
                                    <template x-if="! file.isImage">
                                        <div class="flex aspect-square items-center justify-center p-3 text-center text-[10px] font-semibold uppercase tracking-wider" x-text="file.name"></div>
                                    </template>
                                    <button
                                        type="button"
                                        class="absolute right-1 top-1 flex size-9 items-center justify-center bg-white"
                                        :aria-label="'Xóa ' + file.name"
                                        @click="removeFile('{{ $bucket }}', file.id)"
                                    >
                                        <svg aria-hidden="true" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path d="M5 5l14 14M19 5 5 19" />
                                        </svg>
                                    </button>
                                </li>
                            </template>
                        </ul>
                    </fieldset>
                @endforeach

                <div class="flex flex-col gap-4 border-t border-neutral-200 pt-5 xl:col-span-2 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs text-neutral-500" x-show="! saved">Tệp chỉ được lưu khi bạn xác nhận gửi hồ sơ.</p>
                    <p class="text-xs font-semibold text-black" x-show="saved" x-cloak role="status">Đã lưu bản nháp hồ sơ trên thiết bị.</p>
                    <button
                        type="submit"
                        class="min-h-12 self-start bg-black px-7 py-3 text-[10px] font-medium uppercase tracking-widest text-white transition-colors hover:bg-neutral-800"
                    >
                        Lưu hồ sơ đối soát
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        window.rentalEvidence = function (config) {
            return {
                deadline: new Date(config.deadline).getTime(),
                countdown: '00:00:00',
                timer: null,
                saved: false,
                files: { received: [], returned: [] },

                init() {
                    this.updateCountdown();
                    this.timer = window.setInterval(() => this.updateCountdown(), 1000);
                },

                destroy() {
                    if (this.timer) {
                        window.clearInterval(this.timer);
                    }

                    Object.values(this.files).flat().forEach((file) => {
                        URL.revokeObjectURL(file.url);
                    });
                },

                updateCountdown() {
                    const remaining = Math.max(0, this.deadline - Date.now());
                    const totalSeconds = Math.floor(remaining / 1000);
                    const hours = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
                    const minutes = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
                    const seconds = String(totalSeconds % 60).padStart(2, '0');

                    this.countdown = hours + ':' + minutes + ':' + seconds;

                    if (remaining === 0 && this.timer) {
                        window.clearInterval(this.timer);
                    }
                },

                addFiles(bucket, selectedFiles) {
                    Array.from(selectedFiles).forEach((file) => {
                        if (file.size > 20 * 1024 * 1024) {
                            return;
                        }

                        this.files[bucket].push({
                            id: crypto.randomUUID(),
                            name: file.name,
                            url: URL.createObjectURL(file),
                            isImage: file.type.startsWith('image/'),
                        });
                    });

                    this.saved = false;
                },

                removeFile(bucket, id) {
                    const file = this.files[bucket].find((item) => item.id === id);

                    if (file) {
                        URL.revokeObjectURL(file.url);
                    }

                    this.files[bucket] = this.files[bucket].filter((item) => item.id !== id);
                    this.saved = false;
                },
            };
        };
    </script>
@endpush
