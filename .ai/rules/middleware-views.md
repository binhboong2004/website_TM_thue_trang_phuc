---
paths:
  - '{app/Http/Controllers/**,app/Http/Middleware/**,resources/views/**,routes/web.php}'
---

# Middleware Views

## Separate Shop seller workspace
Seller controllers live under App\Http\Controllers\Shop and seller Blade views under resources/views/shop. Register the shop anonymous component namespace and use <x-shop::...>. Protect seller routes with auth, verified, and is_shop middleware. Keep the public client catalog at /shop; use /shop/dashboard as the seller entry point.
