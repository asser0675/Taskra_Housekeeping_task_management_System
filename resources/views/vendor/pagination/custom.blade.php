@if ($paginator->hasPages())
    <div class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button disabled class="page-link">← Previous</button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-link">
                <button class="page-link">← Previous</button>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="page-item disabled"><button class="page-link" disabled>{{ $element }}</button></span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button class="page-link active" disabled>{{ $page }}</button>
                    @else
                        <a href="{{ $url }}" class="page-link">
                            <button class="page-link">{{ $page }}</button>
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-link">
                <button class="page-link">Next →</button>
            </a>
        @else
            <button disabled class="page-link">Next →</button>
        @endif
    </div>
@endif

<style>
    .page-link {
        text-decoration: none;
        color: inherit;
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
    }

    .page-link:hover {
        color: inherit;
    }
</style>
