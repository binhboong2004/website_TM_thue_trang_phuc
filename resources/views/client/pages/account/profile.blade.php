@extends('client.layouts.account')

@php
    $profile = $user->profile;
    $selectedStylePreferences = old('style_preferences', $profile?->style_preferences ?? []);

    if (! is_array($selectedStylePreferences)) {
        $selectedStylePreferences = [];
    }

    $styleOptions = [
        'Minimalist' => 'Tối giản',
        'Luxury' => 'Sang trọng',
        'Evening' => 'Tiệc tối',
        'Vintage' => 'Cổ điển',
    ];

    $fieldClass = 'w-full appearance-none rounded-none border-0 border-b border-neutral-300 bg-transparent px-0 py-3 text-sm text-neutral-900 placeholder:text-neutral-400 transition-colors focus:border-black focus:ring-0';
@endphp

@section('title', 'Hồ Sơ Cá Nhân | LUXE ROTATE')
@section('meta_description', 'Quản lý thông tin cá nhân, số đo hình thể và sở thích thời trang cho trải nghiệm AI Stylist của LUXE ROTATE.')
@section('canonical', route('profile.edit'))
@section('robots', 'noindex, nofollow')

@section('account_content')
            <h1 class="font-display text-4xl leading-tight text-black mb-10">Hồ sơ cá nhân</h1>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" x-data="{ submitting: false }" @submit="submitting = true">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div x-data x-ref="errorSummary" x-init="$nextTick(() => $refs.errorSummary.focus())" tabindex="-1" role="alert" aria-labelledby="profile-error-title" class="border border-black p-5 mb-8 focus:outline-none">
                        <h2 id="profile-error-title" class="text-[10px] font-semibold uppercase tracking-widest text-black">Vui lòng kiểm tra lại thông tin</h2>
                        <ul class="mt-3 list-inside list-square space-y-1 text-xs leading-5 text-neutral-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <section class="border border-neutral-200 p-8 mb-8" aria-labelledby="basic-information-title">
                    <h2 id="basic-information-title" class="text-[10px] tracking-widest uppercase text-neutral-500 mb-6">01 / Thông tin cơ bản</h2>

                    <div
                        class="flex flex-col sm:flex-row sm:items-center gap-6 mb-8"
                        x-data="{
                            previewUrl: @js($user->avatar_url),
                            fileName: '',
                            handleAvatarChange(event) {
                                const selectedFile = event.target.files[0];

                                if (! selectedFile) {
                                    return;
                                }

                                if (this.previewUrl.startsWith('blob:')) {
                                    URL.revokeObjectURL(this.previewUrl);
                                }

                                this.previewUrl = URL.createObjectURL(selectedFile);
                                this.fileName = selectedFile.name;
                            }
                        }"
                    >
                        <img :src="previewUrl" src="{{ $user->avatar_url }}" alt="Ảnh đại diện của {{ $user->name }}" width="80" height="80" class="w-20 h-20 shrink-0 rounded-full object-cover border border-neutral-200 bg-neutral-50">

                        <div class="min-w-0">
                            <input
                                id="profile-avatar"
                                name="avatar"
                                type="file"
                                accept="image/jpeg,image/png,image/webp"
                                class="sr-only"
                                aria-describedby="profile-avatar-help{{ $errors->has('avatar') ? ' profile-avatar-error' : '' }}"
                                @change="handleAvatarChange($event)"
                            >
                            <label for="profile-avatar" class="inline-flex min-h-10 items-center border border-neutral-300 px-6 py-2 text-[10px] font-medium uppercase tracking-widest cursor-pointer hover:bg-neutral-50 transition-colors">
                                Thay đổi ảnh
                            </label>
                            <p id="profile-avatar-help" class="mt-2 text-[11px] leading-5 text-neutral-500">JPG, PNG hoặc WEBP. Tối đa 2MB.</p>
                            <p x-show="fileName" x-cloak x-text="fileName" class="mt-1 max-w-xs truncate text-[11px] text-neutral-700"></p>
                            @error('avatar')
                                <p id="profile-avatar-error" class="mt-2 text-xs font-medium text-black" role="alert">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="profile-name" class="text-[10px] tracking-widest uppercase text-neutral-500 mb-2 block">Họ và tên</label>
                            <input
                                id="profile-name"
                                name="name"
                                type="text"
                                value="{{ old('name', $user->name) }}"
                                required
                                autocomplete="name"
                                aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                                @if ($errors->has('name')) aria-describedby="profile-name-error" @endif
                                class="{{ $fieldClass }}"
                            >
                            @error('name')
                                <p id="profile-name-error" class="mt-2 text-xs text-black" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="profile-phone" class="text-[10px] tracking-widest uppercase text-neutral-500 mb-2 block">Số điện thoại</label>
                            <input
                                id="profile-phone"
                                name="phone"
                                type="tel"
                                value="{{ old('phone', $profile?->phone) }}"
                                autocomplete="tel"
                                inputmode="tel"
                                placeholder="0901 234 567"
                                aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}"
                                @if ($errors->has('phone')) aria-describedby="profile-phone-error" @endif
                                class="{{ $fieldClass }}"
                            >
                            @error('phone')
                                <p id="profile-phone-error" class="mt-2 text-xs text-black" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="profile-address" class="text-[10px] tracking-widest uppercase text-neutral-500 mb-2 block">Địa chỉ</label>
                            <textarea
                                id="profile-address"
                                name="address"
                                rows="2"
                                autocomplete="street-address"
                                placeholder="Địa chỉ nhận và trả trang phục"
                                aria-invalid="{{ $errors->has('address') ? 'true' : 'false' }}"
                                @if ($errors->has('address')) aria-describedby="profile-address-error" @endif
                                class="{{ $fieldClass }} resize-y"
                            >{{ old('address', $profile?->address) }}</textarea>
                            @error('address')
                                <p id="profile-address-error" class="mt-2 text-xs text-black" role="alert">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </section>

                <section class="border border-neutral-200 p-8 mb-8" aria-labelledby="body-profile-title">
                    <div class="mb-8">
                        <h2 id="body-profile-title" class="text-[10px] tracking-widest uppercase text-neutral-500">02 / Thông Số Hình Thể</h2>
                        <p class="mt-2 text-xs leading-5 text-neutral-500">Giúp AI Stylist đề xuất kích cỡ chuẩn xác.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-8">
                        @foreach ([
                            ['name' => 'height_cm', 'label' => 'Chiều cao', 'unit' => 'cm', 'value' => $profile?->height_cm, 'min' => 100, 'max' => 250],
                            ['name' => 'weight_kg', 'label' => 'Cân nặng', 'unit' => 'kg', 'value' => $profile?->weight_kg, 'min' => 30, 'max' => 300],
                            ['name' => 'bust_cm', 'label' => 'Vòng 1', 'unit' => 'cm', 'value' => $profile?->bust_cm, 'min' => 40, 'max' => 250],
                            ['name' => 'waist_cm', 'label' => 'Vòng 2', 'unit' => 'cm', 'value' => $profile?->waist_cm, 'min' => 40, 'max' => 250],
                            ['name' => 'hips_cm', 'label' => 'Vòng 3', 'unit' => 'cm', 'value' => $profile?->hips_cm, 'min' => 40, 'max' => 250],
                        ] as $measurement)
                            <div>
                                <label for="profile-{{ $measurement['name'] }}" class="text-[10px] tracking-widest uppercase text-neutral-500 mb-2 flex items-center justify-between gap-4">
                                    <span>{{ $measurement['label'] }}</span>
                                    <span class="text-neutral-400">{{ $measurement['unit'] }}</span>
                                </label>
                                <input
                                    id="profile-{{ $measurement['name'] }}"
                                    name="{{ $measurement['name'] }}"
                                    type="number"
                                    value="{{ old($measurement['name'], $measurement['value']) }}"
                                    min="{{ $measurement['min'] }}"
                                    max="{{ $measurement['max'] }}"
                                    step="1"
                                    inputmode="numeric"
                                    aria-invalid="{{ $errors->has($measurement['name']) ? 'true' : 'false' }}"
                                    @if ($errors->has($measurement['name'])) aria-describedby="profile-{{ $measurement['name'] }}-error" @endif
                                    class="{{ $fieldClass }} tabular-nums [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                                >
                                @error($measurement['name'])
                                    <p id="profile-{{ $measurement['name'] }}-error" class="mt-2 text-xs text-black" role="alert">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    <fieldset class="mt-10 border-t border-neutral-100 pt-8">
                        <legend class="text-[10px] tracking-widest uppercase text-neutral-500">Sở thích thời trang</legend>
                        <p id="style-preferences-help" class="mt-2 text-xs leading-5 text-neutral-500">Chọn những phong cách bạn thường ưu tiên. Có thể chọn nhiều lựa chọn.</p>

                        <div class="mt-5 flex flex-wrap gap-3" aria-describedby="style-preferences-help">
                            @foreach ($styleOptions as $value => $label)
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="style_preferences[]" value="{{ $value }}" class="peer sr-only" @checked(in_array($value, $selectedStylePreferences, true))>
                                    <span class="inline-flex min-h-10 items-center border border-neutral-300 bg-white px-4 py-2 text-[10px] font-medium uppercase tracking-widest text-neutral-600 transition-colors hover:border-black hover:text-black peer-checked:border-black peer-checked:bg-black peer-checked:text-white peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-black">
                                        {{ $label }}
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        @error('style_preferences')
                            <p class="mt-3 text-xs text-black" role="alert">{{ $message }}</p>
                        @enderror
                        @error('style_preferences.*')
                            <p class="mt-3 text-xs text-black" role="alert">{{ $message }}</p>
                        @enderror
                    </fieldset>
                </section>

                <div class="flex justify-end mt-8">
                    <button type="submit" class="bg-black text-white px-10 py-4 text-[10px] tracking-widest uppercase font-medium rounded-none hover:bg-neutral-800 transition-colors disabled:cursor-wait disabled:bg-neutral-500" :disabled="submitting">
                        <span x-show="! submitting">Lưu thay đổi</span>
                        <span x-show="submitting" x-cloak>Đang lưu...</span>
                    </button>
                </div>
            </form>
        @endsection
