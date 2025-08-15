<nav aria-label="Page navigation example">
    <ul class="pagination">
        @if ($paginator->onFirstPage())
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">{{ __('Previous') }}</a></li>
        @endif

        @foreach ($elements as $element)
            @if (is_array($element))
                @if (count($element) < 2)
                @else
                    @foreach ($element as $key => $el)
                        @if ($key == $paginator->currentPage())
                            <li class="page-item active"><a class="page-link" href="javascript::void()">{{ $key }}</a></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $el }}">{{ $key }}</a></li>
                        @endif
                    @endforeach
                @endif
            @else
                <li class="page-item"><a class="page-link" href="javascript:;">...</a></li>
            @endif

        @endforeach

        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">{{ __('Next') }}</a></li>
        @endif
    </ul>
  </nav>
