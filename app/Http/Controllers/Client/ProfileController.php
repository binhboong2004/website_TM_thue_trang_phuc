<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProfileController extends Controller
{
    /**
     * Display the authenticated user's profile form.
     */
    public function edit(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();
        $user->load('profile');

        return view('client.pages.account.profile', compact('user'));
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+\s().-]{8,30}$/'],
            'address' => ['nullable', 'string', 'max:2000'],
            'height_cm' => ['nullable', 'integer', 'between:100,250'],
            'weight_kg' => ['nullable', 'integer', 'between:30,300'],
            'bust_cm' => ['nullable', 'integer', 'between:40,250'],
            'waist_cm' => ['nullable', 'integer', 'between:40,250'],
            'hips_cm' => ['nullable', 'integer', 'between:40,250'],
            'style_preferences' => ['nullable', 'array', 'max:10'],
            'style_preferences.*' => ['string', 'max:50', 'distinct'],
        ], [
            'avatar.image' => 'Ảnh đại diện phải là một tệp hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện chỉ chấp nhận định dạng JPG, JPEG, PNG hoặc WEBP.',
            'avatar.max' => 'Ảnh đại diện không được lớn hơn 2MB.',
            'name.required' => 'Vui lòng nhập họ và tên.',
            'phone.regex' => 'Số điện thoại chưa đúng định dạng.',
            'height_cm.between' => 'Chiều cao phải nằm trong khoảng 100–250 cm.',
            'weight_kg.between' => 'Cân nặng phải nằm trong khoảng 30–300 kg.',
            'bust_cm.between' => 'Số đo vòng 1 phải nằm trong khoảng 40–250 cm.',
            'waist_cm.between' => 'Số đo vòng 2 phải nằm trong khoảng 40–250 cm.',
            'hips_cm.between' => 'Số đo vòng 3 phải nằm trong khoảng 40–250 cm.',
            'style_preferences.max' => 'Bạn chỉ có thể chọn tối đa 10 sở thích thời trang.',
            'style_preferences.*.distinct' => 'Sở thích thời trang không được trùng lặp.',
        ]);

        /** @var User $user */
        $user = $request->user();
        $previousAvatar = $user->avatar;
        $avatar = $request->file('avatar');
        $newAvatarPath = $avatar instanceof UploadedFile
            ? $avatar->store('avatars', 'public')
            : null;

        $profileAttributes = [
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'height_cm' => $validated['height_cm'] ?? null,
            'weight_kg' => $validated['weight_kg'] ?? null,
            'bust_cm' => $validated['bust_cm'] ?? null,
            'waist_cm' => $validated['waist_cm'] ?? null,
            'hips_cm' => $validated['hips_cm'] ?? null,
            'style_preferences' => $validated['style_preferences'] ?? null,
        ];

        try {
            DB::transaction(function () use ($newAvatarPath, $profileAttributes, $user, $validated): void {
                $userAttributes = ['name' => $validated['name']];

                if ($newAvatarPath !== null) {
                    $userAttributes['avatar'] = $newAvatarPath;
                }

                $user->update($userAttributes);
                $user->profile()->updateOrCreate(
                    ['user_id' => $user->getKey()],
                    $profileAttributes,
                );
            });
        } catch (Throwable $exception) {
            if ($newAvatarPath !== null) {
                Storage::disk('public')->delete($newAvatarPath);
            }

            throw $exception;
        }

        if (
            $newAvatarPath !== null
            && is_string($previousAvatar)
            && $previousAvatar !== ''
            && ! str_contains($previousAvatar, '://')
        ) {
            Storage::disk('public')->delete($previousAvatar);
        }

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Hồ sơ của bạn đã được cập nhật thành công.');
    }
}
