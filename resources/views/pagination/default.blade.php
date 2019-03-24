@php
    $link_limit = 7;
@endphp

@if ($paginator->lastPage() > 1)
<div class="pagination">
    <a href="{{ $paginator->url(1) }}" class="{{ ($paginator->currentPage() == 1) ? 'disabled' : '' }}"><img src="{{ asset('vendor/hcode/images/arrow-pre-small.png') }}" alt=""/></a>
    
    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
        @php
            $half_total_links = floor($link_limit / 2);
            $from = $paginator->currentPage() - $half_total_links;
            $to = $paginator->currentPage() + $half_total_links;
            if ($paginator->currentPage() < $half_total_links) {
               $to += $half_total_links - $paginator->currentPage();
            }
            if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
            }
        @endphp
        @if ($from < $i && $i < $to)
            <a href="{{ $paginator->url($i) }}" class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">{{ $i }}</a>
        @endif
        
    @endfor
    
    <a href="{{ $paginator->url($paginator->currentPage()+1) }}" class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}"><img src="{{ asset('vendor/hcode/images/arrow-next-small.png') }}" alt="" /></a>
</div>
@endif