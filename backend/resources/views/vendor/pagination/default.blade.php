@if ($paginator->hasPages())

    <div class="pager primary">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <div class="pager-item"><p>&laquo;</p></div>
        @else
            <div class="pager-item"><p><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></p></div>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <div class="pager-item"><p>{{ $element }}</p></div>
            @endif
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <div class="pager-item active"><p>{{ $page }}</p></div>
                    @else
                        <div class="pager-item"><p><a href="{{ $url }}">{{ $page }}</a></p></div>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <div class="pager-item"><p><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></p></div>
        @else
            <div class="pager-item"><p>&raquo;</p></div>
        @endif
    </div>
@endif