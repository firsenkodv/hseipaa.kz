@php
    $setting  = \App\Models\Setting::getGroup('onas')->data ?? [];
    $title    = $setting['platform_title'] ?? 'Удобная платформа для обучения';
    $desc     = $setting['platform_desc']  ?? 'Современный личный кабинет с интуитивным интерфейсом. Управляйте своим обучением, отслеживайте прогресс и общайтесь с преподавателями в одном месте.';
    $features = $setting['platform_features'] ?? [
        ['title' => 'Учебные материалы',  'desc' => 'Доступ ко всем лекциям, презентациям и заданиям'],
        ['title' => 'Расписание занятий', 'desc' => 'Календарь с напоминаниями о предстоящих уроках'],
        ['title' => 'Прогресс',           'desc' => 'Статистика успеваемости и выполненных заданий'],
        ['title' => 'Видеолекции',        'desc' => 'Смотрите лекции в любое удобное время'],
    ];
    $svgIcons = [
        '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line>',
        '<rect x="3" y="4" width="18" height="17" rx="2"></rect><path d="M16 2v4"></path><path d="M8 2v4"></path><path d="M3 10h18"></path>',
        '<line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line>',
        '<polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2"></rect>',
    ];
@endphp

<div class="platform-section-wrap">
<section class="platform-section" aria-labelledby="platform-title">
    <div class="platform-inner">
        <header class="platform-header">
            <h2 id="platform-title">{{ $title }}</h2>
            <p>{{ $desc }}</p>
        </header>

        <div class="platform-features">
            @foreach($features as $i => $feature)
                <article class="platform-feature">
                    <div class="platform-feature-icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true">{!! $svgIcons[$i % count($svgIcons)] !!}</svg>
                    </div>
                    @if(!empty($feature['title']))
                        <h3>{{ $feature['title'] }}</h3>
                    @endif
                    @if(!empty($feature['desc']))
                        <p>{{ $feature['desc'] }}</p>
                    @endif
                </article>
            @endforeach
        </div>

        <div class="platform-mockup">
            <img src="{{ Storage::url('about/platform-mockup.png') }}" alt="Интерфейс образовательной платформы" />
        </div>
    </div>
</section>
</div>
