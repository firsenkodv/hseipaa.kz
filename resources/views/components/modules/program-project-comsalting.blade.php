@props(['page' => null])

@php
    $title = $page?->konsalt_steps_title ?? 'Как проходит проект';
    $desc  = $page?->konsalt_steps_desc  ?? 'Понятный процесс от постановки задачи до итогового отчета и сопровождения внедрения';
    $steps = $page?->konsalt_steps_items ?? [
        ['num' => '01', 'title' => 'Бриф',         'desc' => 'Фиксируем задачу, цели, сроки, формат взаимодействия и состав рабочей группы'],
        ['num' => '02', 'title' => 'Диагностика',  'desc' => 'Собираем документы, проводим интервью, анализируем процессы, отчетность и риски'],
        ['num' => '03', 'title' => 'Решение',       'desc' => 'Формируем выводы, согласовываем приоритеты и готовим рекомендации под вашу команду'],
        ['num' => '04', 'title' => 'Сопровождение','desc' => 'Передаем отчет, обсуждаем внедрение и при необходимости остаемся на абонентской поддержке'],
    ];
    $stepIcons = [
        asset('images/education/step-register.svg'),
        asset('images/education/step-study.svg'),
        asset('images/education/step-practice.svg'),
        asset('images/education/step-certify.svg'),
    ];
@endphp

<section class="consulting-project edu-steps" aria-labelledby="consulting-project-title">
    <div class="edu-section__heading edu-section__heading--center">
        <h2 id="consulting-project-title">{{ $title }}</h2>
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
