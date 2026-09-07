@if ($paginator->hasPages())
    <nav class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between" role="navigation" aria-label="Phân trang danh mục">
        <p class="text-xs text-muted tabular-nums">
            Hiển thị {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} trong {{ $paginator->total() }} sản phẩm
        </p>

        <div class="flex items-center gap-1">
            @if ($paginator->onFirstPage())
                <span class="flex size-11 items-center justify-center text-muted/40" aria-disabled="true" aria-label="Trang trước">
                    <svg aria-hidden="true" class="size-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2"><path d="m10 3-5 5 5 5" /></svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex size-11 items-center justify-center border border-transparent hover:border-line" aria-label="Đi đến trang trước">
                    <svg aria-hidden="true" class="size-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2"><path d="m10 3-5 5 5 5" /></svg>
                </a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="flex size-11 items-center justify-center text-xs text-muted">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page === $paginator->currentPage())
                            <span class="flex size-11 items-center justify-center bg-ink text-xs font-semibold text-paper" aria-current="page" aria-label="Trang {{ $page }}">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="flex size-11 items-center justify-center border border-transparent text-xs hover:border-line" aria-label="Đi đến trang {{ $page }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex size-11 items-center justify-center border border-transparent hover:border-line" aria-label="Đi đến trang sau">
                    <svg aria-hidden="true" class="size-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2"><path d="m6 3 5 5-5 5" /></svg>
                </a>
            @else
                <span class="flex size-11 items-center justify-center text-muted/40" aria-disabled="true" aria-label="Trang sau">
                    <svg aria-hidden="true" class="size-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2"><path d="m6 3 5 5-5 5" /></svg>
                </span>
            @endif
        </div>
    </nav>
@endif