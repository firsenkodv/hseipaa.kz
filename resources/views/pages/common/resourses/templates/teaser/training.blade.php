@if(!empty($categories) && $categories->isNotEmpty())
    <div class="useful-wrap useful-library useful-tabs" id="training-results">
        <a href="{{ route('training') }}" class="useful-tab {{ !request('category') ? 'useful-tab--active' : '' }}">Все</a>
        @foreach($categories as $category)
            @if($category->slug)
                <a href="{{ route('training', ['category' => $category->slug]) }}#training-results"
                   class="useful-tab {{ request('category') === $category->slug ? 'useful-tab--active' : '' }}">
                    {{ $category->title }}
                </a>
            @endif
        @endforeach
    </div>
@endif

@php
    $currencyCode   = \App\Models\Setting::getGroup('social')->data['currency'] ?? 'KZT';
    $currencySymbol = config('currency.currency.' . $currencyCode, '₸');
@endphp

<div class="useful-page">
    <section>
        <div class="program-cards" aria-label="Популярные программы">
            @foreach($items as $item)
                @php
                    $prices   = collect($item->price ?? [])->filter(fn($p) => !empty($p['value']));
                    $priceNew = $prices->count() >= 2 ? $prices->last() : $prices->first();
                @endphp
                <article class="program-card">
                    <div class="card-top">
                        <h3>{{ $item->title }}</h3>
                        @if($item->subtitle)
                            <p>{{ $item->subtitle }}</p>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="details-box details-list">
                            @if($item->buy_hours)
                                <p>
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l4 2"></path></svg>
                                    <span>{{ $item->buy_hours }}</span>
                                </p>
                            @endif
                            @if($item->buy_calendar)
                                <p>
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="17" rx="2"></rect><path d="M16 2v4"></path><path d="M8 2v4"></path><path d="M3 10h18"></path></svg>
                                    <span>{{ $item->buy_calendar }}</span>
                                </p>
                            @endif
                            @if($item->buy_certificate)
                                <p>
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg>
                                    <span>{{ $item->buy_certificate }}</span>
                                </p>
                            @endif
                        </div>
                        @if($item->format || $priceNew)
                            <div class="details-box meta-box">
                                @if($item->format)
                                    <div>
                                        <span>Формат</span>
                                        <strong>{{ $item->format }}</strong>
                                    </div>
                                @endif
                                @if($priceNew)
                                    <div>
                                        <span>Стоимость</span>
                                        <strong class="price">{{ price($priceNew['value']) }} {{ $currencySymbol }}</strong>
                                    </div>
                                @endif
                            </div>
                        @endif
                        <a href="{{ route('training.show', $item->slug) }}" class="card-button">Подробнее</a>
                    </div>
                </article>
            @endforeach
        </div>
        {{ $items->withQueryString()->links('pagination::default') }}
    </section>
</div>

<x-modules.program-format :page="$page" />

<x-modules.program-edu-steps :page="$page" />

<x-modules.program-format-doc :page="$page" />
