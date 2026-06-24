@props(['page' => null])

@php
    $title    = $page?->edu_cert_title ?? 'Официальные документы и сертификаты';
    $desc     = $page?->edu_cert_desc  ?? 'По окончании обучения вы получите документы установленного образца, подтверждающие вашу квалификацию. Все программы лицензированы и соответствуют государственным стандартам.';
    $badge    = $page?->edu_cert_badge ?? 'Документы об образовании';
    $certItems = $page?->edu_cert_items ?? [
        ['text' => 'Документы государственного образца'],
        ['text' => 'Внесение в реестр квалификаций'],
        ['text' => 'Признание работодателями'],
        ['text' => 'Международное признание'],
    ];
@endphp

<section class="education-wrap edu-cert" aria-labelledby="certificates-title">
    <div class="edu-cert__visual">
        <img class="edu-cert__bg" src="{{ Storage::url('images/education/cert-bg.jpg') }}" alt="" aria-hidden="true" />
        <img class="edu-cert__photo" src="{{ Storage::url('images/education/cert-photo.jpg') }}" alt="{{ $title }}" />
        <div class="edu-cert__badge">
            <img class="edu-cert__shield" src="{{ Storage::url('images/education/cert-license.svg') }}" alt="" />
            <strong>Лицензия</strong>
            <span>Министерства образования</span>
        </div>
    </div>

    <div class="edu-cert__content">
        <div class="edu-badge">
            <img src="{{ Storage::url('images/education/cert-docs.svg') }}" alt="" />
            <span>{{ $badge }}</span>
        </div>
        <h2 id="certificates-title">{{ $title }}</h2>
        @if($desc)
            <p>{{ $desc }}</p>
        @endif
        <ul class="edu-checks">
            @foreach($certItems as $item)
                @if(!empty($item['text']))
                    <li>
                        <img src="{{ Storage::url('images/education/cert-check.svg') }}" alt="" />
                        {{ $item['text'] }}
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</section>
