{{-- resources/views/admin/pagination.blade.php --}}
@if ($paginator->hasPages())
<nav>
    <ul class="pagination" style="display:flex; gap:.4rem; flex-wrap:wrap; list-style:none;">
        {{-- Previous Page --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">‹</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">‹</a></li>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">…</span></li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
            @endif
        @endforeach

        {{-- Next Page --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">›</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">›</span></li>
        @endif
    </ul>
</nav>
@endif
