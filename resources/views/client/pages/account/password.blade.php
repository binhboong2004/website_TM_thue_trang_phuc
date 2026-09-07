@extends('client.layouts.account')

@section('title', 'Đổi Mật Khẩu | LUXE ROTATE')
@section('meta_description', 'Cập nhật mật khẩu bảo mật cho tài khoản LUXE ROTATE.')
@section('canonical', url('/account/password'))
@section('robots', 'noindex, nofollow')

@section('account_content')
    <h1 class="text-4xl font-serif mb-10">Đổi mật khẩu</h1>

    <div class="border border-neutral-200 p-8">
        <form
            method="POST"
            action="{{ Route::has('account.password.update') ? route('account.password.update') : url('/account/password') }}"
            x-data="{ submitting: false }"
            @submit="submitting = true"
        >
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="current-password" class="text-[10px] tracking-widest uppercase text-neutral-500 mb-2 block">
                    Mật khẩu hiện tại
                </label>
                <input
                    id="current-password"
                    name="current_password"
                    type="password"
                    required
                    autocomplete="current-password"
                    aria-invalid="{{ $errors->has('current_password') ? 'true' : 'false' }}"
                    @if ($errors->has('current_password')) aria-describedby="current-password-error" @endif
                    class="w-full border-0 border-b border-neutral-300 bg-transparent px-0 py-3 text-sm focus:border-black focus:ring-0 appearance-none rounded-none"
                >
                @error('current_password')
                    <p id="current-password-error" class="mt-2 text-xs text-black" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="new-password" class="text-[10px] tracking-widest uppercase text-neutral-500 mb-2 block">
                    Mật khẩu mới
                </label>
                <input
                    id="new-password"
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                    @if ($errors->has('password')) aria-describedby="new-password-help password-error" @else aria-describedby="new-password-help" @endif
                    class="w-full border-0 border-b border-neutral-300 bg-transparent px-0 py-3 text-sm focus:border-black focus:ring-0 appearance-none rounded-none"
                >
                <p id="new-password-help" class="mt-2 text-[11px] leading-5 text-neutral-500">
                    Sử dụng tối thiểu 8 ký tự và không trùng với mật khẩu hiện tại.
                </p>
                @error('password')
                    <p id="password-error" class="mt-2 text-xs text-black" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password-confirmation" class="text-[10px] tracking-widest uppercase text-neutral-500 mb-2 block">
                    Xác nhận mật khẩu mới
                </label>
                <input
                    id="password-confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    class="w-full border-0 border-b border-neutral-300 bg-transparent px-0 py-3 text-sm focus:border-black focus:ring-0 appearance-none rounded-none"
                >
            </div>

            <div class="flex justify-end mt-8">
                <button
                    type="submit"
                    class="min-h-12 rounded-none bg-black px-8 py-4 text-[10px] font-medium uppercase tracking-widest text-white transition-colors hover:bg-neutral-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black disabled:cursor-wait disabled:bg-neutral-500"
                    :disabled="submitting"
                >
                    <span x-show="! submitting">Lưu thay đổi</span>
                    <span x-show="submitting" x-cloak>Đang lưu...</span>
                </button>
            </div>
        </form>
    </div>
@endsection
