<div class="grid gap-6 lg:grid-cols-2">
    <label class="block text-sm font-medium">Tên sản phẩm
        <input type="text" name="name" value="{{ old('name', $product['name'] ?? '') }}" class="mt-2 min-h-12 w-full border border-line bg-paper px-4 text-base focus:border-ink focus:outline-none focus:ring-1 focus:ring-ink" autocomplete="off">
    </label>
    <label class="block text-sm font-medium">Thương hiệu
        <input type="text" name="brand" value="{{ old('brand', $product['brand'] ?? '') }}" class="mt-2 min-h-12 w-full border border-line bg-paper px-4 text-base focus:border-ink focus:outline-none focus:ring-1 focus:ring-ink" autocomplete="organization">
    </label>
    <label class="block text-sm font-medium">Giá thuê mỗi ngày
        <input type="number" min="0" step="1000" name="rental_price" value="{{ old('rental_price', $product['rental_price'] ?? '') }}" class="mt-2 min-h-12 w-full border border-line bg-paper px-4 text-base tabular-nums focus:border-ink focus:outline-none focus:ring-1 focus:ring-ink" inputmode="numeric">
    </label>
    <label class="block text-sm font-medium">Tiền cọc hoàn lại
        <input type="number" min="0" step="1000" name="deposit" value="{{ old('deposit', $product['deposit'] ?? '') }}" class="mt-2 min-h-12 w-full border border-line bg-paper px-4 text-base tabular-nums focus:border-ink focus:outline-none focus:ring-1 focus:ring-ink" inputmode="numeric">
    </label>
    <label class="block text-sm font-medium lg:col-span-2">Giá mua đứt
        <input type="number" min="0" step="1000" name="purchase_price" value="{{ old('purchase_price', $product['purchase_price'] ?? '') }}" class="mt-2 min-h-12 w-full border border-line bg-paper px-4 text-base tabular-nums focus:border-ink focus:outline-none focus:ring-1 focus:ring-ink" inputmode="numeric">
    </label>
</div>