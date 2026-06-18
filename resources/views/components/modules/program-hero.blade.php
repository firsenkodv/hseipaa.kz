@props(['item'])

@php
    $iconCalendar    = asset('images/program/hero-calendar.svg');
    $iconClock       = asset('images/program/hero-clock.svg');
    $iconCertificate = asset('images/program/hero-certificate.svg');
    $prices   = collect($item->price ?? [])->filter(fn($p) => !empty($p['value']));
    $priceOld = $prices->count() >= 2 ? $prices->first() : null;
    $priceNew = $prices->count() >= 2 ? $prices->last() : $prices->first();
    $currencyCode   = \App\Models\Setting::getGroup('social')->data['currency'] ?? 'KZT';
    $currencySymbol = config('currency.currency.' . $currencyCode, '₸');
@endphp

<section class="program-block program-hero" aria-labelledby="program-title">
    <div class="program-hero__copy">
        <h1 id="program-title">{{ ($item->buy_title)??$item->title }}</h1>

        @if($item->buy_desc)
            <p>{{ $item->buy_desc }}</p>
        @endif

        @if($item->buy_calendar || $item->buy_hours || $item->buy_certificate)
            <div class="program-hero__meta">
                @if($item->buy_calendar)
                    <div class="program-hero__meta-item">
                        <img src="{{ $iconCalendar }}" alt="">
                        <span>{{ $item->buy_calendar }}</span>
                    </div>
                @endif
                @if($item->buy_hours)
                    <div class="program-hero__meta-item">
                        <img src="{{ $iconClock }}" alt="">
                        <span>{{ $item->buy_hours }}</span>
                    </div>
                @endif
                @if($item->buy_certificate)
                    <div class="program-hero__meta-item">
                        <img src="{{ $iconCertificate }}" alt="">
                        <span>{{ $item->buy_certificate }}</span>
                    </div>
                @endif
            </div>
        @endif

        @if($priceOld || $priceNew)
            <div class="program-hero__price">
                @if(!empty($priceOld['value']))
                    <div class="program-hero__old">
                        <span>{{ price($priceOld['value']) }} <i>{{ $currencySymbol }}</i></span>
                        @if(!empty($priceOld['note']))
                            <small class="hero_old">{{ $priceOld['note'] }}</small>
                        @endif
                    </div>
                @endif
                @if(!empty($priceNew['value']))
                    <div class="program-hero__new">
                        <span>{{ price($priceNew['value']) }} <i>{{ $currencySymbol }}</i></span>
                        @if(!empty($priceNew['note']))
                            <small class="hero_new">{{ $priceNew['note'] }}</small>
                        @endif
                    </div>
                @endif
            </div>
        @endif

        <div class="program-hero__actions">
            <button type="button" class="program-hero__btn program-hero__btn--primary open-fancybox" data-form="consult_me">
                Начать обучение
            </button>
            @if($item->outline_title || !empty($item->outline_modules))
                <button type="button" class="program-hero__btn program-hero__btn--ghost js-scroll-to-outline">Программа обучения</button>
            @endif
        </div>
    </div>

    @if($item->img)
        <div class="program-hero__visual">
            <x-picture.responsive
                :sizes="['480x250', '486x604']"
                :src="$item->img"
                :alt="$item->course_title"
                class="program-hero__img"
            />
            <div class="program-hero__likes">
                <button
                    type="button"
                    class="program-hero__like-btn"
                    data-url="{{ route('training.like', $item->id) }}"
                    aria-label="Поставить лайк"
                >
                    <svg class="program-hero__like-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </button>
                <span class="program-hero__like-count">{{ $item->likes ?? 0 }}</span>
            </div>
        </div>
    @endif
</section>

<script>
(function () {
    document.querySelectorAll('.program-hero__like-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var url = btn.dataset.url;
            var countEl = btn.closest('.program-hero__likes').querySelector('.program-hero__like-count');
            btn.classList.add('program-hero__like-btn--active');
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            })
            .then(function (r) { return r.json(); })
            .then(function (data) { countEl.textContent = data.likes; })
            .catch(function () {});
        });
    });
})();
</script>
