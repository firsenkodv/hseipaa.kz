@if($items->currentPage() === 1)
<section class="edu-hero" aria-labelledby="education-title">
    <div class="edu-hero__inner">
        <div class="edu-hero__copy">
            @if($page->title)
                <h1 id="education-title">Программы обучения</h1>
            @endif
            <p>Выберите программу обучения из нашего каталога. Профессиональная подготовка и переподготовка специалистов по актуальным направлениям.</p>
        </div>

        <form class="edu-search" method="GET" action="{{ route('training') }}#training-results">
            <button type="submit" aria-label="Найти">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="11" cy="11" r="6.5"></circle>
                    <path d="M16 16L21 21"></path>
                </svg>
            </button>
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Поиск программы обучения..." />
        </form>

        <div class="edu-hero__stats">
            <div class="edu-stat">
                <strong>50+</strong>
                <span>Программ</span>
            </div>
            <div class="edu-stat">
                <strong>5 000+</strong>
                <span>Выпускников</span>
            </div>
            <div class="edu-stat">
                <strong>12</strong>
                <span>Направлений</span>
            </div>
        </div>


    </div>
</section>

@endif
