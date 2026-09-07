---
paths:
  - '{app/Http/Controllers/**,resources/views/**,routes/web.php}'
---

# Views

## Separate Admin, Shop, and Client presentation layers
Keep controllers under App\Http\Controllers\Admin, Shop, or Client and Blade views under resources/views/admin, shop, or client. Register anonymous components with admin/shop/client namespaces and use <x-admin::...> / <x-shop::...> / <x-client::...>. Protect admin routes with auth, verified, and admin middleware; protect seller routes with auth, verified, and is_shop middleware.