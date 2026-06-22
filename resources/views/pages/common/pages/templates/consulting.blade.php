@if($items->currentPage() === 1)
<section class="edu-hero" aria-labelledby="consulting-title">
    <div class="edu-hero__inner">
        <div class="edu-hero__copy">
            @if($page->title)
                <h1 id="consulting-title">{{ $page->title }}</h1>
            @endif
            @if($page->short_desc)
                <p>{!! $page->short_desc !!}</p>
            @endif
        </div>

        <form class="edu-search" method="GET" action="{{ route('consulting') }}#consulting-results">
            <button type="submit" aria-label="Найти">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="11" cy="11" r="6.5"></circle>
                    <path d="M16 16L21 21"></path>
                </svg>
            </button>
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Поиск консалтинга..." />
        </form>

        <div class="edu-hero__stats">
            @foreach($page->hero_stats ?? [] as $stat)
                <div class="edu-stat">
                    <strong>{{ $stat['value'] ?? '' }}</strong>
                    <span>{{ $stat['label'] ?? '' }}</span>
                </div>
            @endforeach
        </div>

    </div>
</section>
@endif
