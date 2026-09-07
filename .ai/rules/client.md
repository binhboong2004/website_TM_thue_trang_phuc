---
paths:
  - '{app/Http/Controllers/Client/**,resources/views/client/**,routes/web.php}'
---

# Client

## Separate AI stylist widget from virtual fitting
Keep AI Stylist as the global <x-client::ai-stylist-widget /> injected by the client layout. The dedicated studio lives at client.virtual-fitting (/virtual-fitting) via VirtualFittingController; /ai-stylist is only a permanent legacy redirect. Do not rebuild a combined split-screen chat/VTON page.
