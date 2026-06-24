@props(['page' => null])

@php
    $title    = $page?->konsalt_docs_title ?? 'Официальные документы и результаты проекта';
    $desc     = $page?->konsalt_docs_desc  ?? 'По итогам проекта вы получаете отчет, перечень рисков, рекомендации и материалы для внутренней команды. Формат результата зависит от услуги и целей проекта.';
    $badge    = $page?->konsalt_docs_badge ?? 'Документы и результаты проекта';
    $docItems = $page?->konsalt_docs_items ?? [
        ['text' => 'Итоговый отчет и карта рисков'],
        ['text' => 'План корректирующих действий'],
        ['text' => 'Рекомендации для руководства'],
        ['text' => 'Материалы для внутренней команды'],
    ];
@endphp

<section class="consulting-docs edu-cert" aria-labelledby="consulting-docs-title">
    <div class="edu-cert__visual">
        <img
            class="edu-cert__bg"
            src="{{ Storage::url('images/education/cert-bg.jpg') }}"
            alt=""
            aria-hidden="true"
        >
        <img
            class="edu-cert__photo"
            src="{{ Storage::url('images/education/cert-photo.jpg') }}"
            alt="{{ $title }}"
        >
        <div class="edu-cert__badge">
            <img
                class="edu-cert__shield"
                src="{{ Storage::url('images/education/cert-license.svg') }}"
                alt=""
            >
            <strong>Лицензия</strong>
            <span>Министерства образования</span>
        </div>
    </div>

    <div class="edu-cert__content">
        <div class="edu-badge">
            <img src="{{ Storage::url('images/education/cert-docs.svg') }}" alt="">
            <span>{{ $badge }}</span>
        </div>
        <h2 id="consulting-docs-title">{{ $title }}</h2>
        @if($desc)
            <p>{{ $desc }}</p>
        @endif
        <ul class="edu-checks">
            @foreach($docItems as $item)
                @if(!empty($item['text']))
                    <li>
                        <img src="{{ Storage::url('images/education/cert-check.svg') }}" alt="">
                        <span>{{ $item['text'] }}</span>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</section>
