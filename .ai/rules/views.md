---
paths:
  - '{app/Http/Controllers/**,resources/views/**,routes/web.php}'
---

# Views

## Separate Admin and Client presentation layers
Keep controllers under App\Http\Controllers\Admin or Client and Blade views under resources/views/admin or client. Register anonymous components with admin/client namespaces and use <x-admin::...> / <x-client::...>. Protect every admin route with auth, verified, and admin middleware.
