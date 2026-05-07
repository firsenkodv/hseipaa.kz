<ul>

    @foreach($items as $item)
        <li>
            @isset($route)
                <a href="{{ route($route, $item->slug) }}">{{ $item->title }}</a>
            @else
                {{ $item->title }}
            @endisset
        </li>
    @endforeach

</ul>
