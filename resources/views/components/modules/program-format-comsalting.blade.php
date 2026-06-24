@props(['page' => null])

@php
    $title = $page?->konsalt_format_title ?? 'Форматы консалтинга';
    $desc  = $page?->konsalt_format_desc  ?? 'Подберем удобный формат работы под задачу, сроки и уровень вовлечения вашей команды';
    $items = $page?->konsalt_format_items ?? [
        ['title' => 'Экспресс-диагностика', 'desc' => 'Быстрый аудит или консультационный спринт по одному участку: налоги, отчетность, договоры или клиентские процессы.', 'li_1' => 'Короткие сроки', 'li_2' => 'Фокус на одной проблеме', 'li_3' => 'Понятный план действий'],
        ['title' => 'Проектная работа', 'desc' => 'Полноценный проект с планом, этапами, рабочими встречами, анализом документов и итоговыми рекомендациями.', 'li_1' => 'Команда экспертов', 'li_2' => 'Согласованный календарь', 'li_3' => 'Отчет по итогам'],
        ['title' => 'Абонентское сопровождение', 'desc' => 'Регулярная поддержка по вопросам учета, налогов, финансов и управленческих решений на ежемесячной основе.', 'li_1' => 'Постоянный контакт', 'li_2' => 'Поддержка команды клиента', 'li_3' => 'Гибкий объем задач'],
    ];
    $icons = [
        Storage::url('images/education/format-online.svg'),
        Storage::url('images/education/format-offline.svg'),
        Storage::url('images/education/format-mixed.svg'),
    ];
@endphp

<section class="consulting-formats" aria-labelledby="consulting-formats-title">
    <div class="edu-section__heading edu-section__heading--center">
        <h2 id="consulting-formats-title">{{ $title }}</h2>
        @if($desc)
            <p>{{ $desc }}</p>
        @endif
    </div>

    <div class="edu-format-grid">
        @foreach($items as $i => $card)
            <article class="edu-format-card">
                <div class="edu-format-card__icon">
                    <img src="{{ $icons[$i % count($icons)] }}" alt="">
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
