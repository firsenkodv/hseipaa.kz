@php
    $trainings = \App\Models\Training::published()->take(8)->get();

    $currencyCode   = \App\Models\Setting::getGroup('social')->data['currency'] ?? 'KZT';
    $currencySymbol = config('currency.currency.' . $currencyCode, '₸');
@endphp

@if($trainings->isNotEmpty())
<section class="schedule" id="schedule">
    <div class="container">

        <div class="schedule__head">
            <h2>Занимайтесь из дома, на работе<br>— с компьютера или смартфона.</h2>
            <a href="{{ route('training') }}">Все программы</a>
        </div>

        <div class="swiper schedule-swiper" aria-label="Ближайшие курсы">
            <div class="swiper-wrapper">

                @foreach($trainings as $item)
                    @php
                        $prices   = collect($item->price ?? [])->filter(fn($p) => !empty($p['value']));
                        $priceNew = $prices->count() >= 2 ? $prices->last() : $prices->first();
                    @endphp
                    <div class="swiper-slide">
                        <article class="course-card">
                            <div class="course-card__body">
                                <h3>{{ $item->title }}</h3>
                                @if($item->subtitle)
                                    <p>{{ $item->subtitle }}</p>
                                @endif
                                <dl class="course-card__meta">
                                    <div><dt>Дата:</dt><dd>постоянно</dd></div>
                                    <div><dt>Место:</dt><dd>Алматы</dd></div>
                                    @if($item->buy_certificate)
                                        <div><dt>Сертификат:</dt><dd>Есть</dd></div>
                                    @endif
                                </dl>
                            </div>
                            <div class="course-card__price">
                                @if($priceNew)
                                    {{ price($priceNew['value']) }} {{ $currencySymbol }}
                                @else
                                    —
                                @endif
                            </div>
                            <a class="course-card__link" href="{{ route('training.show', $item->slug) }}" aria-label="{{ $item->title }}"></a>
                        </article>
                    </div>
                @endforeach

            </div>

            <div class="swiper-pagination schedule-swiper__dots"></div>
        </div>

    </div>
</section>
@endif
