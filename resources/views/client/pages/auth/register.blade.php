@extends('client.layouts.app')

@section('title', 'Tạo Tài Khoản | LUXE ROTATE')
@section('meta_description', 'Tạo tài khoản LUXE ROTATE để lưu thiết kế yêu thích, đặt lịch thuê và theo dõi đơn hàng.')
@section('canonical', route('register'))
@section('robots', 'noindex, nofollow')
@section('og_image', asset('images/editorial/black-gown.webp'))
@section('og_image_alt', 'Trang phục thiết kế cao cấp của LUXE ROTATE')

@section('content')
    <section class="grid min-h-[calc(100svh-6.5rem)] bg-paper lg:grid-cols-2" aria-labelledby="register-title">
        <figure class="relative hidden min-h-[56rem] overflow-hidden bg-ink lg:block">
            <img
                src="{{ asset('images/editorial/black-gown.webp') }}"
                alt="Váy dạ hội đen trong bộ sưu tập thời trang tuần hoàn LUXE ROTATE"
                class="absolute inset-0 h-full w-full object-cover grayscale"
                width="1200"
                height="1600"
                loading="eager"
            >
            <div class="absolute inset-0 bg-ink/30" aria-hidden="true"></div>
            <figcaption class="absolute inset-x-0 bottom-0 border-t border-white/30 p-10 text-paper xl:p-14">
                <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-white/75">A considered collection</p>
                <p class="mt-3 max-w-lg font-display text-3xl leading-tight">Sở hữu ít hơn. Trải nghiệm nhiều hơn. Luôn mặc đúng khoảnh khắc.</p>
                <p class="mt-5 text-[10px] uppercase tracking-[0.2em] text-white/70">LUXE / ROTATE · Membership</p>
            </figcaption>
        </figure>

        <div class="flex min-w-0 items-center px-6 py-14 sm:px-10 sm:py-20 lg:px-14 xl:px-24">
            <div class="mx-auto w-full max-w-lg">
                <nav aria-label="Điều hướng phân cấp" class="mb-9 flex items-center gap-2 text-[10px] font-semibold uppercase tracking-[0.16em] text-muted">
                    <a href="{{ route('home') }}" class="py-2 transition-colors hover:text-ink">Trang chủ</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page" class="text-ink">Đăng ký</span>
                </nav>

                <header>
                    <p class="eyebrow text-muted">Join the rotation</p>
                    <h1 id="register-title" class="mt-3 font-display text-5xl leading-[0.95] text-ink sm:text-6xl">Tạo Tài Khoản</h1>
                    <p class="mt-5 max-w-md text-sm leading-7 text-muted">Lưu thiết kế yêu thích, quản lý lịch thuê và theo dõi hoàn cọc trong một hồ sơ riêng.</p>
                </header>

                <form method="POST" action="{{ route('register') }}" class="mt-9" x-data="{ showPassword: false, submitting: false }" @submit="submitting = true">
                    @csrf

                    <div class="space-y-7">
                        <div>
                            <label for="register-name" class="block text-[10px] font-semibold uppercase tracking-[0.16em] text-neutral-600">Họ và tên</label>
                            <input
                                id="register-name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="Nguyễn Minh Anh"
                                aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                                @if ($errors->has('name')) aria-describedby="register-name-error" @endif
                                class="mt-1 min-h-12 w-full rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 text-base text-ink placeholder:text-neutral-400 transition-colors duration-200 focus:border-ink focus:outline-none focus:ring-0"
                            >
                            @error('name')
                                <p id="register-name-error" class="mt-2 text-xs leading-5 text-danger" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="register-email" class="block text-[10px] font-semibold uppercase tracking-[0.16em] text-neutral-600">Email</label>
                            <input
                                id="register-email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="username"
                                inputmode="email"
                                placeholder="you@example.com"
                                aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                                @if ($errors->has('email')) aria-describedby="register-email-error" @endif
                                class="mt-1 min-h-12 w-full rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 text-base text-ink placeholder:text-neutral-400 transition-colors duration-200 focus:border-ink focus:outline-none focus:ring-0"
                            >
                            @error('email')
                                <p id="register-email-error" class="mt-2 text-xs leading-5 text-danger" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="flex items-center justify-between gap-4">
                                <label for="register-password" class="block text-[10px] font-semibold uppercase tracking-[0.16em] text-neutral-600">Mật khẩu</label>
                                <button type="button" class="py-2 text-[10px] font-semibold uppercase tracking-[0.12em] text-muted underline decoration-neutral-300 underline-offset-4 transition-colors hover:text-ink" @click="showPassword = !showPassword" :aria-pressed="showPassword">
                                    <span x-text="showPassword ? 'Ẩn' : 'Hiện'">Hiện</span>
                                </button>
                            </div>
                            <input
                                id="register-password"
                                name="password"
                                :type="showPassword ? 'text' : 'password'"
                                required
                                autocomplete="new-password"
                                placeholder="Tối thiểu 8 ký tự"
                                aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                                @if ($errors->has('password')) aria-describedby="register-password-error" @endif
                                class="min-h-12 w-full rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 text-base text-ink placeholder:text-neutral-400 transition-colors duration-200 focus:border-ink focus:outline-none focus:ring-0"
                            >
                            @error('password')
                                <p id="register-password-error" class="mt-2 text-xs leading-5 text-danger" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="register-password-confirmation" class="block text-[10px] font-semibold uppercase tracking-[0.16em] text-neutral-600">Xác nhận mật khẩu</label>
                            <input
                                id="register-password-confirmation"
                                name="password_confirmation"
                                :type="showPassword ? 'text' : 'password'"
                                required
                                autocomplete="new-password"
                                placeholder="Nhập lại mật khẩu"
                                class="mt-1 min-h-12 w-full rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 text-base text-ink placeholder:text-neutral-400 transition-colors duration-200 focus:border-ink focus:outline-none focus:ring-0"
                            >
                        </div>
                    </div>

                    <p class="mt-7 text-xs leading-5 text-muted">Khi tạo tài khoản, bạn xác nhận đã đọc điều khoản sử dụng, chính sách bảo mật và chính sách giữ cọc trung gian.</p>

                    <button
                        type="submit"
                        class="mt-7 flex min-h-14 w-full items-center justify-center rounded-none bg-ink px-6 text-[11px] font-semibold uppercase tracking-[0.2em] text-paper transition-colors duration-200 hover:bg-coal disabled:cursor-wait disabled:bg-neutral-500"
                        :disabled="submitting"
                    >
                        <span x-show="!submitting">Tạo tài khoản</span>
                        <span x-show="submitting" x-cloak>Đang khởi tạo...</span>
                    </button>
                </form>

                <div class="mt-8 border-t border-line pt-7">
                    <p class="text-sm text-muted">
                        Đã có tài khoản?
                        <a href="{{ route('login') }}" class="ml-1 font-medium text-ink underline decoration-neutral-300 underline-offset-4 transition-colors hover:decoration-ink">Đăng nhập</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
