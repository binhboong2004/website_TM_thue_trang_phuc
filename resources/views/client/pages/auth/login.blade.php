@extends('client.layouts.app')

@section('title', 'Đăng Nhập | LUXE ROTATE')
@section('meta_description', 'Đăng nhập tài khoản LUXE ROTATE để quản lý đơn thuê, mua sắm và theo dõi hoàn cọc.')
@section('canonical', route('login'))
@section('robots', 'noindex, nofollow')
@section('og_image', asset('images/editorial/hero-campaign.webp'))
@section('og_image_alt', 'Editorial thời trang cao cấp LUXE ROTATE')

@section('content')
    <section class="grid min-h-[calc(100svh-6.5rem)] bg-paper lg:grid-cols-2" aria-labelledby="login-title">
        <figure class="relative hidden min-h-[48rem] overflow-hidden bg-ink lg:block">
            <img
                src="{{ asset('images/editorial/hero-campaign.webp') }}"
                alt="Người mẫu trong chiến dịch thời trang editorial của LUXE ROTATE"
                class="absolute inset-0 h-full w-full object-cover grayscale"
                width="1200"
                height="1600"
                loading="eager"
            >
            <div class="absolute inset-0 bg-ink/25" aria-hidden="true"></div>
            <figcaption class="absolute inset-x-0 bottom-0 flex items-end justify-between gap-8 border-t border-white/30 p-10 text-paper xl:p-14">
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-white/75">The circular wardrobe · 2026</p>
                    <p class="mt-3 max-w-md font-display text-3xl leading-tight">Một tủ đồ được chọn lọc cho những khoảnh khắc đáng nhớ.</p>
                </div>
                <span class="shrink-0 text-[10px] uppercase tracking-[0.2em] text-white/70">LUXE / ROTATE</span>
            </figcaption>
        </figure>

        <div class="flex min-w-0 items-center px-6 py-14 sm:px-10 sm:py-20 lg:px-14 xl:px-24">
            <div class="mx-auto w-full max-w-lg">
                <nav aria-label="Điều hướng phân cấp" class="mb-10 flex items-center gap-2 text-[10px] font-semibold uppercase tracking-[0.16em] text-muted">
                    <a href="{{ route('home') }}" class="py-2 transition-colors hover:text-ink">Trang chủ</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page" class="text-ink">Đăng nhập</span>
                </nav>

                <header>
                    <p class="eyebrow text-muted">Welcome back</p>
                    <h1 id="login-title" class="mt-3 font-display text-5xl leading-none text-ink sm:text-6xl">Đăng Nhập</h1>
                    <p class="mt-5 max-w-md text-sm leading-7 text-muted">Tiếp tục quản lý lịch thuê, đơn mua và trạng thái tiền cọc của bạn.</p>
                </header>

                <form method="POST" action="{{ route('login') }}" class="mt-10" x-data="{ showPassword: false, submitting: false }" @submit="submitting = true">
                    @csrf

                    <div class="space-y-8">
                        <div>
                            <label for="login-email" class="block text-[10px] font-semibold uppercase tracking-[0.16em] text-neutral-600">Email</label>
                            <input
                                id="login-email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                inputmode="email"
                                placeholder="you@example.com"
                                aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                                @if ($errors->has('email')) aria-describedby="login-email-error" @endif
                                class="mt-2 min-h-12 w-full rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 text-base text-ink placeholder:text-neutral-400 transition-colors duration-200 focus:border-ink focus:outline-none focus:ring-0"
                            >
                            @error('email')
                                <p id="login-email-error" class="mt-2 text-xs leading-5 text-danger" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="flex items-center justify-between gap-4">
                                <label for="login-password" class="block text-[10px] font-semibold uppercase tracking-[0.16em] text-neutral-600">Mật khẩu</label>
                                <button type="button" class="py-2 text-[10px] font-semibold uppercase tracking-[0.12em] text-muted underline decoration-neutral-300 underline-offset-4 transition-colors hover:text-ink" @click="showPassword = !showPassword" :aria-pressed="showPassword">
                                    <span x-text="showPassword ? 'Ẩn' : 'Hiện'">Hiện</span>
                                </button>
                            </div>
                            <input
                                id="login-password"
                                name="password"
                                :type="showPassword ? 'text' : 'password'"
                                required
                                autocomplete="current-password"
                                placeholder="Nhập mật khẩu"
                                aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                                @if ($errors->has('password')) aria-describedby="login-password-error" @endif
                                class="min-h-12 w-full rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 text-base text-ink placeholder:text-neutral-400 transition-colors duration-200 focus:border-ink focus:outline-none focus:ring-0"
                            >
                            @error('password')
                                <p id="login-password-error" class="mt-2 text-xs leading-5 text-danger" role="alert">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <label class="mt-7 inline-flex min-h-11 cursor-pointer items-center gap-3 text-xs text-neutral-600">
                        <input
                            name="remember"
                            type="checkbox"
                            value="1"
                            @checked(old('remember'))
                            class="size-4 rounded-none border-neutral-400 text-ink focus:ring-ink focus:ring-offset-2"
                        >
                        Duy trì đăng nhập trên thiết bị này
                    </label>

                    <button
                        type="submit"
                        class="mt-8 flex min-h-14 w-full items-center justify-center rounded-none bg-ink px-6 text-[11px] font-semibold uppercase tracking-[0.2em] text-paper transition-colors duration-200 hover:bg-coal disabled:cursor-wait disabled:bg-neutral-500"
                        :disabled="submitting"
                    >
                        <span x-show="!submitting">Đăng nhập</span>
                        <span x-show="submitting" x-cloak>Đang xác thực...</span>
                    </button>
                </form>

                <div class="mt-8 border-t border-line pt-7">
                    <p class="text-sm text-muted">
                        Chưa có tài khoản?
                        <a href="{{ route('register') }}" class="ml-1 font-medium text-ink underline decoration-neutral-300 underline-offset-4 transition-colors hover:decoration-ink">Tạo tài khoản</a>
                    </p>
                    <p class="mt-3 text-xs leading-5 text-muted">Bằng việc đăng nhập, bạn đồng ý với điều khoản sử dụng và chính sách bảo mật của LUXE ROTATE.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
