@props(['page' => null])

@php
    $title = $page?->edu_steps_title ?? 'Как проходит обучение';
    $desc  = $page?->edu_steps_desc  ?? 'Простой и понятный процесс от регистрации до получения сертификата';
    $steps = $page?->edu_steps_items ?? [
        ['num' => '01', 'title' => 'Регистрация',  'desc' => 'Выберите программу и оформите заявку онлайн или по телефону'],
        ['num' => '02', 'title' => 'Обучение',     'desc' => 'Изучайте материалы, смотрите лекции и выполняйте практические задания'],
        ['num' => '03', 'title' => 'Практика',     'desc' => 'Отработка навыков на реальных кейсах под руководством экспертов'],
        ['num' => '04', 'title' => 'Сертификация', 'desc' => 'Сдайте итоговый экзамен и получите документ о квалификации'],
    ];
    $stepIcons = [
        asset('images/education/step-register.svg'),
        asset('images/education/step-study.svg'),
        asset('images/education/step-practice.svg'),
        asset('images/education/step-certify.svg'),
    ];
@endphp

<section class="edu-section edu-steps" aria-labelledby="steps-title">
    <div class="edu-section__heading edu-section__heading--center">
        <h2 id="steps-title">{{ $title }}</h2>
        @if($desc)
            <p>{{ $desc }}</p>
        @endif
    </div>

    <div class="edu-steps__grid">
        @foreach($steps as $i => $step)
            @if($i > 0)
                <span class="edu-step__line" aria-hidden="true"></span>
            @endif
            <article class="edu-step">
                <strong>{{ $step['num'] ?? str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</strong>
                <div class="edu-step__icon">
                    <img src="{{ $stepIcons[$i % count($stepIcons)] }}" alt="">
                </div>
                @if(!empty($step['title']))
                    <h3>{{ $step['title'] }}</h3>
                @endif
                @if(!empty($step['desc']))
                    <p>{{ $step['desc'] }}</p>
                @endif
            </article>
        @endforeach
    </div>
</section>
