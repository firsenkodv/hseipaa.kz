@props(['home' => null])

@php
    $h2Title    = $home['programs_h2_title'] ?? 'Освоите новые навыки и ускорьте';
    $h2Span     = $home['programs_h2_span']  ?? 'карьерный рост';
    $tiles      = $home['program_tiles']     ?? [
        ['color' => 'green',  'href' => '/obuchenie/mediator',           'title' => "Обучение\nМедиаторов",  'cta_text' => 'Обучение за 5 дней',      'letter_key' => 'm'],
        ['color' => 'orange', 'href' => '/obuchenie/prof-bukhgalter-rk', 'title' => "Проф.\nбухгалтер",     'cta_text' => 'Сдача до 90% студентов',  'letter_key' => 'b'],
        ['color' => 'blue',   'href' => '/obuchenie/kursy-cap-i-cipa',   'title' => 'CAP/CIPA',              'cta_text' => 'Лучшие лекторы Алматы',  'letter_key' => 'c'],
        ['color' => 'red',    'href' => '/obuchenie/dipifr',             'title' => 'ДИПИФР',                'cta_text' => 'Теория и практика',      'letter_key' => 'd'],
    ];
    $asideHref = $home['programs_aside_href'] ?? '/raspisani/almaty';
    $asideCta  = $home['programs_aside_cta']  ?? 'Подберите удобное время';
@endphp

<section class="programs" id="programs">
    <div class="container">
        <h2>
            {{ $h2Title }}
            <span>{{ $h2Span }}</span>
        </h2>
        <div class="programs__layout">
            <div class="programs__grid" aria-label="Популярные направления">
                @foreach($tiles as $tile)
                    <article class="program-card program-card--{{ $tile['color'] ?? 'green' }}">
                        <a class="program-card__link" href="{{ $tile['href'] ?? '#' }}">
                            <h3>{!! nl2br(e($tile['title'] ?? '')) !!}</h3>
                            <span class="program-card__cta">
                                <span>{{ $tile['cta_text'] ?? '' }}</span>
                                <img class="program-card__arrow" src="{{ Storage::url('/images/arrow_right.svg') }}" alt="" aria-hidden="true" />
                            </span>
                            @if(!empty($tile['letter_key']))
                                <img class="program-card__letter program-card__letter--{{ $tile['letter_key'] }}" src="{{ Storage::url('/images/programs/tile-letter-' . $tile['letter_key'] . '.svg') }}" alt="" aria-hidden="true" />
                            @endif
                        </a>
                    </article>
                @endforeach
            </div>
            <aside class="programs__aside" aria-label="Расписание">
                <article class="program-card program-card--dark">
                    <a class="program-card__link" href="{{ $asideHref }}">
                        <h3>Расписание</h3>
                        <span class="program-card__cta">
                            <span>{{ $asideCta }}</span>
                            <img class="program-card__arrow" src="{{ Storage::url('/images/arrow_right.svg') }}" alt="" aria-hidden="true" />
                        </span>
                        <img class="program-card__letter program-card__letter--r" src="{{ Storage::url('/images/programs/tile-letter-r.svg') }}" alt="" aria-hidden="true" />
                    </a>
                </article>
            </aside>
        </div>
    </div>
</section>
