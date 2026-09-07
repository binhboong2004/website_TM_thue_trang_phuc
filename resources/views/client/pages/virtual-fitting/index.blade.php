@extends('client.layouts.app')

@section('title', 'Phòng Thử Đồ Ảo | LUXE ROTATE')
@section('meta_description', 'Tải ảnh toàn thân, nhận phân tích tỷ lệ vóc dáng, gợi ý kích cỡ và xem bản mô phỏng trang phục trong phòng thử đồ ảo LUXE ROTATE.')
@section('canonical', route('client.virtual-fitting'))
@section('og_image', $product['image'])
@section('og_image_alt', 'Phòng thử đồ ảo với '.$product['name'].' của '.$product['brand'])

@section('content')
    <section
        class="border-b border-line bg-paper"
        x-data="{
            product: @js($product),
            selectedSize: @js($product['sizes'][1] ?? $product['sizes'][0]),
            uploadedImage: null,
            uploadedImageName: '',
            uploadError: '',
            isDragging: false,
            isAnalyzing: false,
            analysisReady: false,
            resultReady: false,
            acceptedTypes: ['image/jpeg', 'image/png', 'image/webp'],
            maxFileSize: 5 * 1024 * 1024,
            selectFile(event) {
                this.processFile(event.target.files[0]);
            },
            handleDrop(event) {
                this.isDragging = false;
                this.processFile(event.dataTransfer.files[0]);
            },
            processFile(file) {
                this.uploadError = '';

                if (!file) {
                    return;
                }

                if (!this.acceptedTypes.includes(file.type)) {
                    this.uploadError = 'Vui lòng chọn ảnh JPG, PNG hoặc WEBP.';
                    this.$refs.fileInput.value = '';

                    return;
                }

                if (file.size > this.maxFileSize) {
                    this.uploadError = 'Ảnh cần có dung lượng không quá 5 MB.';
                    this.$refs.fileInput.value = '';

                    return;
                }

                if (this.uploadedImage) {
                    URL.revokeObjectURL(this.uploadedImage);
                }

                this.uploadedImage = URL.createObjectURL(file);
                this.uploadedImageName = file.name;
                this.analysisReady = false;
                this.resultReady = false;
                this.isAnalyzing = true;

                window.setTimeout(() => {
                    this.isAnalyzing = false;
                    this.analysisReady = true;
                    this.resultReady = true;
                }, 900);
            },
            removeImage() {
                if (this.uploadedImage) {
                    URL.revokeObjectURL(this.uploadedImage);
                }

                this.uploadedImage = null;
                this.uploadedImageName = '';
                this.uploadError = '';
                this.isAnalyzing = false;
                this.analysisReady = false;
                this.resultReady = false;
                this.$refs.fileInput.value = '';
            },
            addToCart() {
                this.$store.cart.addPurchase(this.product, this.selectedSize);
                this.$dispatch('cart-drawer-open');
            }
        }"
    >
        <header class="shell border-b border-line py-14 sm:py-16 lg:py-20">
            <p class="eyebrow text-muted">Virtual fitting studio</p>
            <div class="mt-5 grid gap-6 lg:grid-cols-[1fr_0.75fr] lg:items-end">
                <h1 class="max-w-4xl font-display text-5xl leading-[0.96] tracking-[-0.025em] sm:text-6xl lg:text-7xl">Phòng Thử Đồ Ảo</h1>
                <p class="max-w-xl text-base leading-7 text-muted lg:justify-self-end">Hình dung thiết kế trên chính vóc dáng của bạn trước khi quyết định thuê hoặc sở hữu.</p>
            </div>
        </header>

        <div class="shell grid gap-12 py-12 lg:grid-cols-2 lg:gap-16 lg:py-20 xl:gap-24">
            <section aria-labelledby="vton-upload-title">
                <div class="flex items-end justify-between gap-6 border-b border-ink pb-4">
                    <div>
                        <p class="eyebrow text-muted">Bước 01</p>
                        <h2 id="vton-upload-title" class="mt-2 font-sans text-sm font-semibold uppercase tracking-[0.12em]">Ảnh & phân tích hình thể</h2>
                    </div>
                    <span class="text-[10px] uppercase tracking-[0.15em] text-muted">Tối đa 5 MB</span>
                </div>

                <div
                    class="relative mt-6 min-h-[31rem] border border-dashed bg-canvas transition-colors duration-200 motion-reduce:transition-none sm:min-h-[38rem]"
                    :class="isDragging ? 'border-black bg-neutral-100' : 'border-neutral-300'"
                    @dragenter.prevent="isDragging = true"
                    @dragover.prevent="isDragging = true"
                    @dragleave.prevent="isDragging = false"
                    @drop.prevent="handleDrop($event)"
                >
                    <template x-if="!uploadedImage">
                        <label for="virtual-fitting-image" class="flex min-h-[31rem] cursor-pointer flex-col items-center justify-center px-8 text-center sm:min-h-[38rem]">
                            <span class="flex size-16 items-center justify-center border border-black bg-white" aria-hidden="true">
                                <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                                    <path d="M12 16V4m0 0L7 9m5-5 5 5M5 14v5h14v-5" />
                                </svg>
                            </span>
                            <span class="mt-6 font-display text-2xl text-neutral-950 sm:text-3xl">Kéo thả ảnh chân dung / toàn thân</span>
                            <span class="mt-3 max-w-sm text-sm leading-6 text-neutral-500">Hoặc nhấn để chọn ảnh. Ưu tiên ảnh chụp thẳng, đủ sáng, nền đơn sắc và thấy rõ toàn bộ trang phục.</span>
                            <span class="mt-6 border-b border-black pb-1 text-[10px] font-semibold uppercase tracking-[0.16em] text-black">Chọn ảnh từ thiết bị</span>
                        </label>
                    </template>

                    <template x-if="uploadedImage">
                        <figure class="relative min-h-[31rem] bg-neutral-100 sm:min-h-[38rem]">
                            <img :src="uploadedImage" :alt="'Ảnh vóc dáng đã tải lên: ' + uploadedImageName" class="absolute inset-0 h-full w-full object-contain">
                            <figcaption class="absolute inset-x-0 bottom-0 flex items-center justify-between gap-4 border-t border-neutral-200 bg-white/95 px-5 py-4 backdrop-blur-sm">
                                <span class="min-w-0 truncate text-xs text-neutral-600" x-text="uploadedImageName"></span>
                                <button type="button" class="min-h-11 shrink-0 text-[10px] font-semibold uppercase tracking-[0.14em] underline decoration-neutral-400 underline-offset-4 hover:decoration-black" @click="removeImage()">Chọn ảnh khác</button>
                            </figcaption>
                        </figure>
                    </template>

                    <input x-ref="fileInput" id="virtual-fitting-image" type="file" class="sr-only" accept="image/jpeg,image/png,image/webp" @change="selectFile($event)">
                </div>

                <p x-show="uploadError" x-cloak class="mt-3 border-l-2 border-red-700 pl-3 text-sm text-red-700" role="alert" x-text="uploadError"></p>

                <div class="mt-6 border border-line bg-white" aria-live="polite">
                    <div class="flex items-center justify-between border-b border-line px-5 py-4">
                        <h3 class="text-[10px] font-semibold uppercase tracking-[0.16em]">Phân tích hình thể</h3>
                        <span x-show="isAnalyzing" class="text-[10px] uppercase tracking-[0.14em] text-muted" role="status">Đang phân tích…</span>
                        <span x-show="analysisReady" x-cloak class="text-[10px] uppercase tracking-[0.14em] text-black">Hoàn tất</span>
                        <span x-show="!isAnalyzing && !analysisReady" class="text-[10px] uppercase tracking-[0.14em] text-muted">Chờ ảnh</span>
                    </div>
                    <div x-show="analysisReady" x-cloak class="grid grid-cols-2 divide-x divide-line">
                        <dl class="p-5 sm:p-6">
                            <dt class="text-[10px] uppercase tracking-[0.14em] text-muted">Độ phù hợp form dáng</dt>
                            <dd class="mt-3 font-display text-4xl tabular-nums">92<span class="ml-1 text-xl">%</span></dd>
                        </dl>
                        <dl class="p-5 sm:p-6">
                            <dt class="text-[10px] uppercase tracking-[0.14em] text-muted">Khuyến nghị size</dt>
                            <dd class="mt-3 font-display text-4xl" x-text="selectedSize"></dd>
                        </dl>
                    </div>
                    <p x-show="!analysisReady" class="px-5 py-6 text-sm leading-6 text-muted">Kết quả tỷ lệ vóc dáng và size khuyến nghị sẽ xuất hiện sau khi ảnh được xử lý.</p>
                </div>
            </section>

            <section aria-labelledby="vton-result-title">
                <div class="flex items-end justify-between gap-6 border-b border-ink pb-4">
                    <div>
                        <p class="eyebrow text-muted">Bước 02</p>
                        <h2 id="vton-result-title" class="mt-2 font-sans text-sm font-semibold uppercase tracking-[0.12em]">Bản dựng thử đồ</h2>
                    </div>
                    <span class="border border-neutral-300 bg-white px-2.5 py-1 text-[9px] uppercase tracking-[0.15em] text-muted">Mô phỏng UI</span>
                </div>

                <div class="relative mt-6 min-h-[31rem] overflow-hidden border border-line bg-neutral-100 sm:min-h-[38rem]" aria-live="polite">
                    <div x-show="!resultReady" class="absolute inset-0 flex flex-col items-center justify-center px-8 text-center">
                        <svg aria-hidden="true" class="size-12 text-neutral-400" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1">
                            <path d="M14 42V19l10-7 10 7v23M18 15V8h12v7M10 42h28M19 25h10M19 31h10" />
                        </svg>
                        <p class="mt-6 font-display text-2xl text-neutral-700">Studio đang chờ hình ảnh của bạn</p>
                        <p class="mt-3 max-w-sm text-sm leading-6 text-neutral-500">Tải ảnh ở cột bên trái để khởi tạo bản dựng trang phục.</p>
                    </div>

                    <figure x-show="resultReady" x-cloak class="absolute inset-0">
                        <img src="{{ $product['image'] }}" alt="Bản dựng mô phỏng {{ $product['name'] }} của {{ $product['brand'] }}" class="h-full w-full object-cover" style="object-position: {{ $product['position'] }}" width="720" height="960">
                        <figcaption class="absolute inset-x-0 bottom-0 border-t border-white/30 bg-black/80 px-5 py-4 text-white">
                            <p class="text-[9px] uppercase tracking-[0.17em] text-white/65">Kết quả tham khảo · không phải ảnh xử lý AI thật</p>
                            <p class="mt-1 font-display text-xl">{{ $product['name'] }}</p>
                        </figcaption>
                    </figure>

                    <div x-show="isAnalyzing" class="absolute inset-0 flex items-center justify-center bg-white/85" role="status">
                        <div class="text-center">
                            <span class="mx-auto block size-8 animate-spin border border-neutral-300 border-t-black motion-reduce:animate-none"></span>
                            <p class="mt-4 text-[10px] font-semibold uppercase tracking-[0.16em]">Đang dựng trang phục</p>
                        </div>
                    </div>
                </div>

                <article class="mt-6 border border-line bg-white">
                    <div class="grid grid-cols-[6.5rem_1fr] gap-5 border-b border-line p-5 sm:grid-cols-[8rem_1fr]">
                        <a href="{{ $product['url'] }}" class="block aspect-[3/4] overflow-hidden bg-fog">
                            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }} của {{ $product['brand'] }}" class="h-full w-full object-cover" style="object-position: {{ $product['position'] }}" width="256" height="341" loading="lazy">
                        </a>
                        <div class="min-w-0">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-muted">{{ $product['brand'] }}</p>
                            <h3 class="mt-2 font-display text-2xl leading-tight"><a href="{{ $product['url'] }}" class="hover:underline hover:underline-offset-4">{{ $product['name'] }}</a></h3>
                            <dl class="mt-5 space-y-2 text-sm tabular-nums">
                                <div class="flex flex-wrap justify-between gap-2"><dt class="text-muted">Thuê / ngày</dt><dd class="font-semibold">{{ number_format($product['rentalPrice'], 0, ',', '.') }}đ</dd></div>
                                <div class="flex flex-wrap justify-between gap-2"><dt class="text-muted">Mua đứt</dt><dd>{{ number_format($product['purchasePrice'], 0, ',', '.') }}đ</dd></div>
                                <div class="flex flex-wrap justify-between gap-2 text-xs text-muted"><dt>Cọc hoàn lại</dt><dd>{{ number_format($product['deposit'], 0, ',', '.') }}đ</dd></div>
                            </dl>
                        </div>
                    </div>

                    <div class="p-5">
                        <fieldset>
                            <legend class="text-[10px] font-semibold uppercase tracking-[0.14em] text-muted">Chọn kích cỡ</legend>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach ($product['sizes'] as $size)
                                    <button type="button" class="flex min-h-11 min-w-12 items-center justify-center border px-3 text-xs font-semibold transition-colors" :class="selectedSize === @js($size) ? 'border-black bg-black text-white' : 'border-neutral-300 bg-white text-black hover:border-black'" :aria-pressed="selectedSize === @js($size)" @click="selectedSize = @js($size)">{{ $size }}</button>
                                @endforeach
                            </div>
                        </fieldset>

                        <button type="button" class="mt-5 flex min-h-12 w-full items-center justify-center bg-black px-5 text-[11px] font-semibold uppercase tracking-[0.16em] text-white transition-colors hover:bg-neutral-800" @click="addToCart()">Thêm vào giỏ</button>
                        <p class="mt-3 text-center text-[10px] leading-5 text-muted">Nút này thêm sản phẩm mua đứt với kích cỡ đã chọn.</p>
                    </div>
                </article>
            </section>
        </div>
    </section>
@endsection