@props(['page' => null])

@php
    $title = $page?->edu_format_title ?? 'Форматы обучения';
    $desc  = $page?->edu_format_desc  ?? 'Выберите удобный формат обучения под ваши потребности и график';
    $items = $page?->edu_format_items ?? [
        ['title' => 'Онлайн обучение',   'desc' => 'Учитесь в удобное время из любой точки мира. Доступ к материалам 24/7, онлайн-лекции и вебинары.',                                  'li_1' => 'Гибкий график',              'li_2' => 'Доступ к записям',        'li_3' => 'Экономия времени'],
        ['title' => 'Очное обучение',    'desc' => 'Занятия в аудиториях с преподавателями. Живое общение, практические занятия и нетворкинг.',                                           'li_1' => 'Личное общение',             'li_2' => 'Практические занятия',    'li_3' => 'Нетворкинг'],
        ['title' => 'Смешанный формат',  'desc' => 'Комбинация онлайн и офлайн занятий. Теория онлайн, практика очно для максимальной эффективности.',                                    'li_1' => 'Лучшее из двух форматов',   'li_2' => 'Гибкость + практика',     'li_3' => 'Оптимальная цена'],
    ];
    $icons = [
        Storage::url('images/education/format-online.svg'),
        Storage::url('images/education/format-offline.svg'),
        Storage::url('images/education/format-mixed.svg'),
    ];
@endphp

<section class="education-wrap-sila education-wrap edu-section edu-section--soft" aria-labelledby="formats-title">
    <div class="edu-section__heading edu-section__heading--center">
        <h2 id="formats-title">{{ $title }}</h2>
        @if($desc)
            <p>{{ $desc }}</p>
        @endif
    </div>

    <div class="edu-format-grid">
        @foreach($items as $i => $card)
            <article class="edu-format-card">
                <div class="edu-format-card__icon">
                    <img src="{{ $icons[$i % count($icons)] }}" alt="" />
                </div>
                @if(!empty($card['title']))
                    <h3>{{ $card['title'] }}</h3>
                @endif
                @if(!empty($card['desc']))
                    <p>{{ $card['desc'] }}</p>
                @endif
                @php $listItems = array_filter([$card['li_1'] ?? '', $card['li_2'] ?? '', $card['li_3'] ?? '']); @endphp
                @if(!empty($listItems))
                    <ul class="edu-format-card__list">
                        @foreach($listItems as $li)
                            <li>{{ $li }}</li>
                        @endforeach
                    </ul>
                @endif
            </article>
        @endforeach
    </div>
</section>
