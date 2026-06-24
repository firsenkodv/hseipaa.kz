@props(['home' => null])

@php
    $title = $home['home_consult_title'] ?? 'Форматы консалтинга';
    $desc  = $home['home_consult_desc']  ?? 'Подберем удобный формат работы под задачу, сроки и уровень вовлечения вашей команды';
    $items = $home['home_consult_items'] ?? [
        ['title' => 'Экспресс-диагностика',    'desc' => 'Быстрый аудит или консультационный спринт по одному участку: налоги, отчетность, договоры или клиентские процессы.',           'li_1' => 'Короткие сроки',          'li_2' => 'Фокус на одной проблеме',    'li_3' => 'Понятный план действий'],
        ['title' => 'Проектная работа',         'desc' => 'Полноценный проект с планом, этапами, рабочими встречами, анализом документов и итоговыми рекомендациями.',                    'li_1' => 'Команда экспертов',       'li_2' => 'Согласованный календарь',   'li_3' => 'Отчет по итогам'],
        ['title' => 'Абонентское сопровождение','desc' => 'Регулярная поддержка по вопросам учета, налогов, финансов и управленческих решений на ежемесячной основе.',                    'li_1' => 'Постоянный контакт',      'li_2' => 'Поддержка команды клиента', 'li_3' => 'Гибкий объем задач'],
    ];
@endphp

<section class="consulting-formats edu-section edu-section--soft">
    <div class="container">

        <div class="edu-section__heading edu-section__heading--center">
            <h2>{{ $title }}</h2>
            @if($desc)<p>{{ $desc }}</p>@endif
        </div>

        <div class="edu-format-grid">
            @foreach($items as $card)
                <article class="edu-format-card">
                    <div class="edu-format-card__icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            @if($loop->index === 0)
                                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                            @elseif($loop->index === 1)
                                <rect x="2" y="3" width="20" height="14" rx="2"/><polyline points="8 21 12 17 16 21"/>
                            @else
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            @endif
                        </svg>
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

    </div>
</section>
