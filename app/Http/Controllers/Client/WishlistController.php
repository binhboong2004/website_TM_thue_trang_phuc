<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display the authenticated user's saved products.
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();
        $wishlists = $user->favoriteProducts()
            ->latest('wishlists.created_at')
            ->get();

        return view('client.pages.account.wishlist', compact('wishlists'));
    }

    /**
     * Add or remove a product from the authenticated user's wishlist.
     */
    public function toggle(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'string', 'exists:products,id'],
        ], [
            'product_id.required' => 'Vui lòng chọn sản phẩm cần lưu.',
            'product_id.exists' => 'Sản phẩm không tồn tại.',
        ]);

        /** @var User $user */
        $user = $request->user();
        $productId = $validated['product_id'];
        $isFavorited = $user->favoriteProducts()->whereKey($productId)->exists();

        if ($isFavorited) {
            $user->favoriteProducts()->detach($productId);

            return response()->json([
                'status' => 'removed',
                'message' => 'Đã bỏ lưu sản phẩm',
            ]);
        }

        $user->favoriteProducts()->attach($productId);

        return response()->json([
            'status' => 'added',
            'message' => 'Đã lưu vào danh sách yêu thích',
        ]);
    }
}
