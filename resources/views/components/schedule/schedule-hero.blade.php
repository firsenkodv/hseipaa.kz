<section class="schedule-hero-section">
    <div class="schedule-hero">
        <div class="schedule-hero__copy">
            <span class="schedule-hero__badge">Актуальное расписание</span>

            @if($item->title)
                <h1 class="schedule-hero__title" data-schedule-title>{{ $item->title }}</h1>
            @endif

            @if($item->short_desc)
                <p>{{ $item->short_desc }}</p>
            @endif
        </div>

        <div class="schedule-hero__stats">
            <article>
                <strong>16</strong>
                <span>актуальных потоков</span>
            </article>
            <article>
                <strong>12</strong>
                <span>месяцев навигации</span>
            </article>
            <article>
                <strong>1</strong>
                <span>город в этой выборке</span>
            </article>
        </div>
    </div>

    <x-schedule.schedule-filter />
</section>
