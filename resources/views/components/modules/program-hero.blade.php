@props(['item'])

@php
    $iconCalendar    = asset('images/program/hero-calendar.svg');
    $iconClock       = asset('images/program/hero-clock.svg');
    $iconCertificate = asset('images/program/hero-certificate.svg');
    $prices   = collect($item->price ?? [])->filter(fn($p) => !empty($p['value']));
    $priceOld = $prices->count() >= 2 ? $prices->first() : null;
    $priceNew = $prices->count() >= 2 ? $prices->last() : $prices->first();
@endphp

<section class="program-block program-hero" aria-labelledby="program-title">
    <div class="program-hero__copy">
        <h1 id="program-title">{{ $item->course_title }}</h1>

        @if($item->course_desc)
            <p>{{ $item->course_desc }}</p>
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
                        <span>{{ price($priceOld['value']) }} ₸</span>
                        @if(!empty($priceOld['note']))
                            <small>{{ $priceOld['note'] }}</small>
                        @endif
                    </div>
                @endif
                @if(!empty($priceNew['value']))
                    <div class="program-hero__new">
                        <span>{{ price($priceNew['value']) }} ₸</span>
                        @if(!empty($priceNew['note']))
                            <small>{{ $priceNew['note'] }}</small>
                        @endif
                    </div>
                @endif
            </div>
        @endif

        <div class="program-hero__actions">
            <button type="button" class="program-hero__btn program-hero__btn--primary">
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
        </div>
    @endif
</section>
