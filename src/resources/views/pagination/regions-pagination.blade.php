<nav aria-label="Page navigation example">
    <ul class="pagination">
        @foreach($paginator['links'] as $link)
            <li class="page-item @if($link['active']) active @endif"><a class="page-link"
                                                                        href="{{ $link['url'] }}"> {{ $link['label'] }}</a>
            </li>
        @endforeach
    </ul>
</nav>
