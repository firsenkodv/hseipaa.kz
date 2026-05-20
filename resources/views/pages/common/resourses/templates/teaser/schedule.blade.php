{{--<div class="useful-page">
    <section class="useful-wrap useful-library">
        <div class="useful-cards">
            @foreach($items as $item)
                <div class="useful-card useful-card--rose">
                    <span class="useful-card__kicker">{{ ($page->menu_title) ?? $page->title }}</span>
                    <h3><a class="h3_teaser" href="{{ route($route, $item->slug) }}">{{ $item->title }}</a></h3>
                    @if($item->short_desc)
                        {!! $item->short_desc !!}
                    @endif
                    <a class="useful-card__link teaser" href="{{ route($route, $item->slug) }}">Подробнее</a>
                </div>
            @endforeach
            {{ $items->withQueryString()->links('pagination::default') }}
        </div>
    </section>
</div>--}}
