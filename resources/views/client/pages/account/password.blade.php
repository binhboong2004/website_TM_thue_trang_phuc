@extends('client.layouts.account')

@section('title', 'Đổi Mật Khẩu | LUXE ROTATE')
@section('meta_description', 'Cập nhật mật khẩu bảo mật cho tài khoản LUXE ROTATE.')
@section('canonical', route('account.password'))
@section('robots', 'noindex, nofollow')

@section('account_content')
    <h1 class="font-serif text-3xl mb-8">Đổi mật khẩu</h1>

    <div class="max-w-2xl border border-neutral-200 p-8 md:p-10">
        <form method="POST" action="{{ route('account.password.update') }}">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="mb-2 block text-[10px] uppercase tracking-widest text-neutral-500">
                    Mật khẩu hiện tại
                </label>
                <input
                    id="current_password"
                    name="current_password"
                    type="password"
                    required
                    autocomplete="current-password"
                    aria-invalid="{{ $errors->has('current_password') ? 'true' : 'false' }}"
                    @error('current_password') aria-describedby="current_password_error" @enderror
                    class="mb-6 w-full rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 py-3 text-sm transition-colors focus:border-black focus:ring-0"
                >
                @error('current_password')
                    <p id="current_password_error" class="mt-1 text-[10px] text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-2 block text-[10px] uppercase tracking-widest text-neutral-500">
                    Mật khẩu mới
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    minlength="8"
                    autocomplete="new-password"
                    aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                    @error('password') aria-describedby="password_error" @enderror
                    class="mb-6 w-full rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 py-3 text-sm transition-colors focus:border-black focus:ring-0"
                >
                @error('password')
                    <p id="password_error" class="mt-1 text-[10px] text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-2 block text-[10px] uppercase tracking-widest text-neutral-500">
                    Xác nhận mật khẩu mới
                </label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    minlength="8"
                    autocomplete="new-password"
                    aria-invalid="{{ $errors->has('password_confirmation') ? 'true' : 'false' }}"
                    @error('password_confirmation') aria-describedby="password_confirmation_error" @enderror
                    class="mb-6 w-full rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 py-3 text-sm transition-colors focus:border-black focus:ring-0"
                >
                @error('password_confirmation')
                    <p id="password_confirmation_error" class="mt-1 text-[10px] text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4 flex justify-end">
                <button
                    type="submit"
                    class="rounded-none bg-black px-8 py-3 text-[10px] font-medium uppercase tracking-widest text-white transition-colors hover:bg-neutral-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black"
                >
                    Cập nhật mật khẩu
                </button>
            </div>
        </form>
    </div>
@endsection
