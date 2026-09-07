@extends('client.layouts.app')

@section('title', 'LUXE ROTATE | Thuê & mua thời trang cao cấp')
@section('meta_description', 'Thuê theo lịch hoặc mua đứt váy dạ hội, vest và trang phục thiết kế cao cấp. AI Stylist, thử đồ ảo và cơ chế hoàn cọc minh bạch.')
@section('canonical', route('home'))
@section('og_image_alt', 'Bộ sưu tập thời trang thuê và mua cao cấp của LUXE ROTATE')

@section('content')
    <section class="border-b border-line" aria-labelledby="hero-title">
        <div class="grid min-h-[calc(100svh-6.5rem)] lg:grid-cols-[0.82fr_1.18fr]">
            <div class="order-2 flex items-center bg-paper px-6 py-14 sm:px-10 lg:order-1 lg:px-[max(2.5rem,calc((100vw-90rem)/2))] lg:pr-12">
                <div class="max-w-xl" data-reveal>
                    <p class="eyebrow text-muted">Thời trang tuần hoàn cao cấp</p>
                    <h1 id="hero-title" class="mt-6 font-display text-[clamp(3.5rem,7.2vw,7.5rem)] leading-[0.86] tracking-[-0.045em]">Một tủ đồ.<br><span class="italic">Vô hạn</span> dịp.</h1>
                    <p class="mt-7 max-w-lg text-[15px] leading-7 text-muted sm:text-base">Thuê thiết kế cao cấp từ những gian hàng đã kiểm duyệt. Lịch trống cập nhật theo thời gian thực, tư vấn phong cách bằng AI và tiền cọc được bảo vệ đến khi hoàn tất kiểm định.</p>
                    <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                        <a href="#bo-suu-tap" class="button-primary">Khám phá bộ sưu tập</a>
                        <button type="button" class="button-secondary" @click="$dispatch('ai-stylist-open')">Hỏi AI Stylist</button>
                    </div>
                    <dl class="mt-12 grid grid-cols-3 gap-5 border-t border-line pt-6">
                        <div><dt class="font-display text-2xl sm:text-3xl">500+</dt><dd class="mt-1 text-[9px] uppercase tracking-[0.13em] text-muted sm:text-[10px]">Thiết kế</dd></div>
                        <div><dt class="font-display text-2xl sm:text-3xl">48</dt><dd class="mt-1 text-[9px] uppercase tracking-[0.13em] text-muted sm:text-[10px]">Atelier</dd></div>
                        <div><dt class="font-display text-2xl sm:text-3xl">4.9/5</dt><dd class="mt-1 text-[9px] uppercase tracking-[0.13em] text-muted sm:text-[10px]">Đánh giá</dd></div>
                    </dl>
                </div>
            </div>
            <figure class="order-1 min-h-[58svh] overflow-hidden bg-fog lg:order-2 lg:min-h-[calc(100svh-6.5rem)]">
                <img src="{{ asset('images/editorial/hero-campaign.webp') }}" alt="Ba người mẫu Việt Nam trong váy dạ hội đen, suit trắng và tuxedo cao cấp" class="h-full w-full object-cover object-[66%_center] lg:object-center" width="1536" height="1024" fetchpriority="high" decoding="async">
                <figcaption class="sr-only">Biên tập mùa tiệc 2026 của LUXE ROTATE</figcaption>
            </figure>
        </div>
    </section>

    <section class="border-b border-line" aria-label="Cam kết dịch vụ">
        <div class="shell grid grid-cols-2 md:grid-cols-4">
            @foreach ([['01', 'Lịch trống thời gian thực'], ['02', 'Giặt hấp sau mỗi lượt thuê'], ['03', 'Cọc tạm giữ minh bạch'], ['04', 'Giao nhận tận nơi']] as [$number, $label])
                <div class="min-h-28 border-b border-r border-line px-5 py-6 sm:min-h-32 sm:px-7 md:border-b-0">
                    <span class="text-[10px] tracking-[0.18em] text-muted">{{ $number }}</span>
                    <p class="mt-5 max-w-[10rem] text-xs font-medium uppercase leading-5 tracking-[0.1em]">{{ $label }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section id="bo-suu-tap" class="shell py-20 lg:py-28" aria-labelledby="collection-title">
        <header class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between" data-reveal>
            <div><p class="eyebrow text-muted">Biên tập theo dịp</p><h2 id="collection-title" class="mt-4 font-display text-4xl leading-tight sm:text-5xl">Chọn diện mạo của bạn</h2></div>
            <a href="#san-pham" class="text-link self-start sm:self-auto">Xem tất cả</a>
        </header>
        <div class="mt-10 grid gap-px bg-line sm:grid-cols-2 lg:grid-cols-3" data-reveal>
            <a href="#san-pham" class="image-zoom group relative min-h-[32rem] overflow-hidden bg-fog">
                <img src="{{ asset('images/editorial/black-gown.webp') }}" alt="Váy dạ hội đen dáng dài" class="absolute inset-0 h-full w-full object-cover" width="960" height="1200" loading="lazy" decoding="async">
                <span class="absolute inset-x-0 bottom-0 bg-black/60 px-7 py-6 text-paper"><span class="eyebrow block text-paper/75">01 / Dạ hội</span><span class="mt-2 block font-display text-3xl">Black Tie</span></span>
            </a>
            <a href="#san-pham" class="image-zoom group relative min-h-[32rem] overflow-hidden bg-fog">
                <img src="{{ asset('images/editorial/hero-campaign.webp') }}" alt="Suit trắng cao cấp phong cách tối giản" class="absolute inset-0 h-full w-full object-cover object-[67%_center]" width="1536" height="1024" loading="lazy" decoding="async">
                <span class="absolute inset-x-0 bottom-0 bg-black/60 px-7 py-6 text-paper"><span class="eyebrow block text-paper/75">02 / Thành thị</span><span class="mt-2 block font-display text-3xl">Modern Tailoring</span></span>
            </a>
            <a href="#san-pham" class="image-zoom group relative min-h-[32rem] overflow-hidden bg-fog sm:col-span-2 lg:col-span-1">
                <img src="{{ asset('images/editorial/city-lookbook.webp') }}" alt="Hai người mẫu trong trang phục dự tiệc thanh lịch" class="absolute inset-0 h-full w-full object-cover" width="960" height="1200" loading="lazy" decoding="async">
                <span class="absolute inset-x-0 bottom-0 bg-black/60 px-7 py-6 text-paper"><span class="eyebrow block text-paper/75">03 / Tiệc cưới</span><span class="mt-2 block font-display text-3xl">Wedding Guest</span></span>
            </a>
        </div>
    </section>

    <section id="san-pham" class="border-y border-line bg-canvas py-20 lg:py-28" aria-labelledby="featured-title">
        <div class="shell">
            <header class="grid gap-6 lg:grid-cols-2 lg:items-end" data-reveal>
                <div><p class="eyebrow text-muted">Đang được đặt nhiều</p><h2 id="featured-title" class="mt-4 font-display text-4xl leading-tight sm:text-5xl">Lựa chọn của biên tập</h2></div>
                <p class="max-w-lg text-sm leading-7 text-muted lg:justify-self-end">Mỗi thiết kế được kiểm định chất liệu, tình trạng và số đo thực tế trước khi xuất hiện trên nền tảng.</p>
            </header>
            @php
                $products = [
                    [
                        'id' => 'noir-sculpted-gown',
                        'image' => asset('images/editorial/black-gown.webp'),
                        'position' => 'center',
                        'brand' => 'Maison Élan',
                        'name' => 'Noir Sculpted Gown',
                        'url' => route('products.show', 'noir-sculpted-gown'),
                        'status' => 'CÓ SẴN',
                        'rentalPrice' => 890000,
                        'deposit' => 2500000,
                        'purchasePrice' => 6800000,
                        'sizes' => ['XS', 'S', 'M'],
                    ],
                    [
                        'id' => 'ivory-fluid-suit',
                        'image' => asset('images/editorial/hero-campaign.webp'),
                        'position' => '52% center',
                        'brand' => 'Atelier Blanc',
                        'name' => 'Ivory Fluid Suit',
                        'url' => route('products.show', 'ivory-fluid-suit'),
                        'status' => 'CÓ SẴN',
                        'rentalPrice' => 760000,
                        'deposit' => 2200000,
                        'purchasePrice' => 5900000,
                        'sizes' => ['S', 'M'],
                    ],
                    [
                        'id' => 'midnight-tuxedo',
                        'image' => asset('images/editorial/hero-campaign.webp'),
                        'position' => '88% center',
                        'brand' => 'Noir Homme',
                        'name' => 'Midnight Tuxedo',
                        'url' => route('products.show', 'midnight-tuxedo'),
                        'status' => 'CÓ SẴN',
                        'rentalPrice' => 820000,
                        'deposit' => 2400000,
                        'purchasePrice' => 6400000,
                        'sizes' => ['M', 'L', 'XL'],
                    ],
                    [
                        'id' => 'graphite-column-dress',
                        'image' => asset('images/editorial/city-lookbook.webp'),
                        'position' => '72% center',
                        'brand' => 'Studio N°5',
                        'name' => 'Graphite Column Dress',
                        'url' => route('products.show', 'graphite-column-dress'),
                        'status' => 'CÓ SẴN',
                        'rentalPrice' => 690000,
                        'deposit' => 1900000,
                        'purchasePrice' => 5200000,
                        'sizes' => ['XS', 'S'],
                    ],
                ];
            @endphp
            <div class="mt-12 grid grid-cols-2 gap-x-3 gap-y-10 sm:gap-x-6 lg:grid-cols-4" data-reveal>
                @foreach ($products as $item)
                    <x-client::product-card :product="$item" />
                @endforeach
            </div>
        </div>
    </section>

    <section id="cong-nghe" class="grid bg-ink text-paper lg:grid-cols-2" aria-labelledby="technology-title">
        <div class="flex items-center px-6 py-20 sm:px-10 lg:px-[max(2.5rem,calc((100vw-90rem)/2))] lg:py-28 lg:pr-16" data-reveal>
            <div class="max-w-xl"><p class="eyebrow text-paper/55">Styling intelligence</p><h2 id="technology-title" class="mt-5 font-display text-5xl leading-[0.98] sm:text-6xl">Đừng đoán.<br><span class="italic">Hãy thử trước.</span></h2><p class="mt-7 max-w-lg text-sm leading-7 text-paper/65">Kể cho AI Stylist về dịp, phong cách và ngân sách. Nhận đề xuất phối đồ, kiểm tra size theo số đo và thử trực quan trước khi giữ lịch.</p><button type="button" class="button-light mt-9" @click="$dispatch('ai-stylist-open')">Bắt đầu tư vấn</button></div>
        </div>
        <div class="grid border-t border-paper/15 sm:grid-cols-3 lg:border-l lg:border-t-0 lg:grid-cols-1">
            @foreach ([['01', 'AI Stylist', 'Đề xuất diện mạo theo sự kiện, phong cách và ngân sách của bạn.'], ['02', 'Size Advisor', 'Đối chiếu số đo cơ thể với form thực tế của từng thiết kế.'], ['03', 'Virtual Try-on', 'Hình dung tổng thể trang phục trên ảnh của bạn trước khi đặt.']] as [$number, $title, $copy])
                <article class="border-b border-paper/15 p-8 sm:border-b-0 sm:border-r sm:last:border-r-0 lg:border-b lg:border-r-0 lg:last:border-b-0" data-reveal><div class="flex items-start gap-8"><span class="text-[10px] tracking-[0.18em] text-paper/45">{{ $number }}</span><div><h3 class="font-display text-2xl">{{ $title }}</h3><p class="mt-3 max-w-sm text-sm leading-6 text-paper/60">{{ $copy }}</p></div></div></article>
            @endforeach
        </div>
    </section>

    <section id="cach-hoat-dong" class="shell py-20 lg:py-28" aria-labelledby="process-title">
        <header class="max-w-3xl" data-reveal><p class="eyebrow text-muted">Quy trình thuê</p><h2 id="process-title" class="mt-4 font-display text-4xl leading-tight sm:text-5xl">Bốn bước, mọi khoản phí đều rõ ràng</h2></header>
        <ol class="mt-14 grid gap-px bg-line md:grid-cols-2 lg:grid-cols-4" data-reveal>
            @foreach ([['Chọn thiết kế', 'Lọc theo dịp, size, ngày mặc và ngân sách. Chỉ những món còn lịch mới được hiển thị.'], ['Giữ lịch & cọc', 'Thanh toán tiền thuê; tiền cọc được tạm giữ riêng và hiển thị rõ trong hóa đơn.'], ['Nhận & trải nghiệm', 'Trang phục đã giặt hấp được giao trước sự kiện, kèm hướng dẫn bảo quản.'], ['Trả & hoàn cọc', 'Đồ được kiểm định khi hoàn về. Cọc tự động hoàn nếu không có phát sinh.']] as $index => [$title, $copy])
                <li class="min-h-72 bg-paper p-7 lg:p-8"><span class="font-display text-4xl text-line">0{{ $index + 1 }}</span><h3 class="mt-10 font-display text-2xl">{{ $title }}</h3><p class="mt-4 text-sm leading-6 text-muted">{{ $copy }}</p></li>
            @endforeach
        </ol>
    </section>

    <section id="lookbook" class="border-y border-line bg-canvas" aria-labelledby="lookbook-title">
        <div class="shell grid lg:grid-cols-[1.1fr_0.9fr]">
            <figure class="-mx-4 min-h-[34rem] overflow-hidden sm:-mx-6 lg:mx-0 lg:min-h-[46rem]"><img src="{{ asset('images/editorial/city-lookbook.webp') }}" alt="Hai khách hàng mặc suit trắng và váy xám trong bộ ảnh lookbook thành thị" class="h-full w-full object-cover" width="960" height="1200" loading="lazy" decoding="async"></figure>
            <div class="flex items-center py-16 lg:border-l lg:border-line lg:px-16" data-reveal><div><p class="eyebrow text-muted">Community lookbook · 08/2026</p><h2 id="lookbook-title" class="mt-5 font-display text-5xl leading-none sm:text-6xl">Trang phục có một đời sống <span class="italic">sau tủ đồ.</span></h2><p class="mt-7 max-w-lg text-sm leading-7 text-muted">Xem cách cộng đồng mặc lại những thiết kế quen thuộc theo cá tính riêng. Lưu cảm hứng, gắn thẻ sản phẩm và chia sẻ diện mạo của bạn.</p><a href="#lookbook-community" class="text-link mt-7">Khám phá Lookbook</a></div></div>
        </div>
    </section>

    <section class="shell py-20 lg:py-28" aria-labelledby="partner-title">
        <div class="grid gap-12 border border-ink p-7 sm:p-10 lg:grid-cols-[1.2fr_0.8fr] lg:items-end lg:p-14" data-reveal>
            <div><p class="eyebrow text-muted">Dành cho đối tác</p><h2 id="partner-title" class="mt-5 max-w-3xl font-display text-4xl leading-tight sm:text-5xl">Thiết kế đang nằm yên có thể bắt đầu một vòng đời mới.</h2></div>
            <div class="lg:justify-self-end"><p class="max-w-md text-sm leading-7 text-muted">Quản lý từng SKU vật lý, lịch thuê, giặt hấp, kiểm định và doanh thu trong một workspace thống nhất.</p><a href="#mo-gian-hang" class="button-primary mt-7">Mở gian hàng</a></div>
        </div>
    </section>
@endsection