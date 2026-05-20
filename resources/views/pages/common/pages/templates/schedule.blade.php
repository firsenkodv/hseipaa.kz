
<section class="schedule-hero-section">
    <div class="schedule-hero">
        <div class="schedule-hero__copy">
            <span class="schedule-hero__badge">Актуальное расписание</span>

            @if($page->title)
                <h1 class="schedule-hero__title" data-schedule-title>{{ ($page->menu_title)?:$page->title }}</h1>
            @endif

            @if($page->short_desc)
                <p>{{ $page->short_desc }}</p>
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


<br>
<br>

<h1 class="h1">{{ $page->title }}</h1>

@if($items->currentPage() === 1)
    @if($page->desc)
        <div class="desc">{!! $page->desc !!}</div>
    @endif
@endif
