<footer class="border-t border-line bg-paper">
    <div class="shell py-16 lg:py-20">
        <div class="grid gap-12 border-b border-line pb-14 md:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_1fr]">
            <div>
                <p class="font-display text-xl tracking-[0.24em]">LUXE/ROTATE</p>
                <p class="mt-5 max-w-sm text-sm leading-7 text-muted">Tủ đồ cao cấp được vận hành theo vòng đời: chọn, mặc, trả và tiếp tục lưu chuyển.</p>
            </div>
            <nav aria-label="Khám phá">
                <h2 class="eyebrow">Khám phá</h2>
                <ul class="mt-5 space-y-3 text-sm text-muted">
                    <li><a class="hover:text-ink" href="#bo-suu-tap">Bộ sưu tập</a></li><li><button type="button" class="hover:text-ink" @click="$dispatch('ai-stylist-open')">AI Stylist</button></li><li><a class="hover:text-ink" href="#lookbook">Lookbook</a></li>
                </ul>
            </nav>
            <nav aria-label="Hỗ trợ">
                <h2 class="eyebrow">Hỗ trợ</h2>
                <ul class="mt-5 space-y-3 text-sm text-muted">
                    <li><a class="hover:text-ink" href="#cach-hoat-dong">Cách hoạt động</a></li><li><a class="hover:text-ink" href="#tien-coc">Chính sách tiền cọc</a></li><li><a class="hover:text-ink" href="#giao-nhan">Giao nhận & đổi trả</a></li>
                </ul>
            </nav>
            <div>
                <h2 class="eyebrow">Liên hệ</h2>
                <address class="mt-5 space-y-3 text-sm not-italic text-muted"><p>TP. Hồ Chí Minh, Việt Nam</p><p><a class="hover:text-ink" href="tel:19001234">1900 1234</a></p><p><a class="hover:text-ink" href="mailto:hello@luxerotate.vn">hello@luxerotate.vn</a></p></address>
            </div>
        </div>
        <div class="flex flex-col gap-4 pt-7 text-[10px] uppercase tracking-[0.14em] text-muted sm:flex-row sm:items-center sm:justify-between">
            <p>© {{ date('Y') }} LUXE ROTATE. Thời trang tuần hoàn.</p><p>Tiền cọc được tạm giữ và hoàn sau kiểm định.</p>
        </div>
    </div>
</footer>
