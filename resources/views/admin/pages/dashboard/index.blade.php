@extends('admin.layouts.app')

@section('title', 'Tổng quan')

@section('page_header')
    <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-muted">Dashboard</p>
    <div class="mt-3 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-sans text-3xl font-semibold tracking-tight sm:text-4xl">Tổng quan vận hành</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-muted">Theo dõi nhanh luồng thuê, mua, tiền cọc và trạng thái kho trên toàn hệ thống.</p>
        </div>
        <p class="text-xs tabular-nums text-muted">Cập nhật {{ now()->format('H:i · d/m/Y') }}</p>
    </div>
@endsection

@section('content')
    <section aria-labelledby="metrics-title">
        <h2 id="metrics-title" class="sr-only">Chỉ số vận hành chính</h2>
        <div class="grid gap-px border border-line bg-line sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($metrics as $metric)
                <article class="min-h-44 bg-paper p-6">
                    <p class="text-xs font-medium leading-5 text-muted">{{ $metric['label'] }}</p>
                    <p class="mt-7 text-3xl font-semibold tracking-tight tabular-nums">{{ $metric['value'] }}</p>
                    <p class="mt-3 text-xs text-muted">{{ $metric['change'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <div class="mt-8 grid gap-8 xl:grid-cols-[1.35fr_0.65fr]">
        <section class="border border-line bg-paper" aria-labelledby="operations-title">
            <header class="border-b border-line px-6 py-5">
                <h2 id="operations-title" class="font-sans text-base font-semibold">Hoạt động cần xử lý</h2>
                <p class="mt-1 text-xs text-muted">Các tác vụ ưu tiên sẽ xuất hiện tại đây khi module đơn hàng được kết nối.</p>
            </header>
            <div class="flex min-h-64 items-center justify-center px-6 py-12 text-center">
                <div class="max-w-sm">
                    <svg aria-hidden="true" class="mx-auto size-8 text-muted" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 12.5 9.5 17 19 7.5" /><circle cx="12" cy="12" r="10" /></svg>
                    <p class="mt-4 text-sm font-medium">Không có tác vụ tồn đọng</p>
                    <p class="mt-2 text-xs leading-5 text-muted">Hệ thống sẽ tổng hợp đơn thuê cần giao, lượt trả cần kiểm định và giao dịch cọc cần đối soát.</p>
                </div>
            </div>
        </section>

        <aside class="border border-line bg-ink p-6 text-paper" aria-labelledby="security-title">
            <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-paper/60">Security</p>
            <h2 id="security-title" class="mt-4 font-sans text-xl font-semibold">Khu vực được bảo vệ</h2>
            <p class="mt-3 text-sm leading-6 text-paper/65">Dashboard yêu cầu đăng nhập, email đã xác minh và tài khoản có quyền quản trị.</p>
            <dl class="mt-8 space-y-4 border-t border-paper/20 pt-5 text-xs">
                <div class="flex justify-between gap-4"><dt class="text-paper/60">Authentication</dt><dd>Enabled</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-paper/60">Email verification</dt><dd>Required</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-paper/60">Admin authorization</dt><dd>Required</dd></div>
            </dl>
        </aside>
    </div>
@endsection