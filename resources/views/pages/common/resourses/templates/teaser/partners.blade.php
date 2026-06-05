<div class="partners-section">
    <div class="partners-grid">
        @foreach($items as $item)
            <div class="partner-card">

                @if($item->img)
                    <a href="{{ route($route, $item->slug) }}" class="partner-card__logo">
                        <x-picture.responsive
                            :sizes="['300x200', '600x400']"
                            :src="$item->img"
                            :alt="$item->title"
                        />
                    </a>
                @endif

                <div class="partner-card__body">
                    <h3 class="partner-card__title">
                        <a href="{{ route($route, $item->slug) }}">{{ $item->title }}</a>
                    </h3>

                    @if($item->short_desc)
                        <div class="partner-card__desc">{!! $item->short_desc !!}</div>
                    @endif

                    <a href="{{ route($route, $item->slug) }}" class="partner-card__link teaser">
                        Подробнее
                    </a>
                </div>

            </div>
        @endforeach
    </div>

    {{ $items->withQueryString()->links('pagination::default') }}
</div>
