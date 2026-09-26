@extends('client.layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-12 grid grid-cols-1 md:grid-cols-12 gap-12 md:gap-16">
        <aside class="md:col-span-3" aria-label="Điều hướng tài khoản">
            <h2 class="mb-8 text-[10px] font-semibold uppercase tracking-widest text-neutral-900">
                Tài khoản của tôi
            </h2>

            <nav>
                <ul>
                    <li>
                        <a
                            href="{{ route('profile.edit') }}"
                            class="block border-l-2 py-3 pl-4 text-xs font-medium uppercase tracking-wider transition-all {{ request()->routeIs('profile.*') ? 'border-black text-black' : 'border-transparent text-neutral-500 hover:border-neutral-200 hover:text-black' }}"
                            @if (request()->routeIs('profile.*')) aria-current="page" @endif
                        >
                            Hồ sơ cá nhân
                        </a>
                    </li>
                    <li>
                        <a
                            href="{{ Route::has('account.orders.index') ? route('account.orders.index') : route('account.rentals.show', 'LR-2026-0001') }}"
                            class="block border-l-2 py-3 pl-4 text-xs font-medium uppercase tracking-wider transition-all {{ request()->routeIs('account.orders.*', 'account.rentals.*') ? 'border-black text-black' : 'border-transparent text-neutral-500 hover:border-neutral-200 hover:text-black' }}"
                            @if (request()->routeIs('account.orders.*', 'account.rentals.*')) aria-current="page" @endif
                        >
                            Đơn thuê & Cọc
                        </a>
                    </li>
                    <li>
                        <a
                            href="{{ route('account.wishlist') }}"
                            class="block border-l-2 py-3 pl-4 text-xs font-medium uppercase tracking-wider transition-all {{ request()->routeIs('account.wishlist') ? 'border-black text-black' : 'border-transparent text-neutral-500 hover:border-neutral-200 hover:text-black' }}"
                            @if (request()->routeIs('account.wishlist')) aria-current="page" @endif
                        >
                            Sản phẩm yêu thích
                        </a>
                    </li>
                    <li>
                        <a
                            href="{{ route('account.password') }}"
                            class="block border-l-2 py-3 pl-4 text-xs font-medium uppercase tracking-wider transition-all {{ request()->routeIs('account.password', 'account.password.*') ? 'border-black text-black' : 'border-transparent text-neutral-500 hover:border-neutral-200 hover:text-black' }}"
                            @if (request()->routeIs('account.password', 'account.password.*')) aria-current="page" @endif
                        >
                            Đổi mật khẩu
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="md:col-span-9 min-w-0">
            @yield('account_content')
        </main>
    </div>
@endsection
