@php
    $firstPage = 1;
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
@endphp

<nav class="mt-3">
    <ul class="pagination justify-content-center">
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->url($firstPage) }}" @disabled($currentPage <= $firstPage)>
                <i class="fa fa-angle-double-left"></i>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->url(max($currentPage - 1, $firstPage)) }}"
                @disabled($currentPage <= $firstPage)>
                <i class="fa fa-angle-left"></i>
            </a>
        </li>
        <li class="page-item page-item-center">
            <a class="page-link" href="{{ $paginator->url($currentPage) }}">
                {{ $currentPage . '/' . $lastPage }}
            </a>
        </li>
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->url(min($currentPage + 1, $lastPage)) }}"
                @disabled($currentPage >= $lastPage)>
                <i class="fa fa-angle-right"></i>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->url($lastPage) }}" @disabled($currentPage >= $lastPage)>
                <i class="fa fa-angle-double-right"></i>
            </a>
        </li>
    </ul>
</nav>
