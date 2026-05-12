@if(!empty($categories) && $categories->isNotEmpty())
    <div class="useful-wrap useful-library useful-tabs" id="training-results">
        <a href="{{ route('training') }}" class="useful-tab {{ !request('category') ? 'useful-tab--active' : '' }}">Все</a>
        @foreach($categories as $category)
            @if($category->slug)
                <a href="{{ route('training', ['category' => $category->slug]) }}#training-results"
                   class="useful-tab {{ request('category') === $category->slug ? 'useful-tab--active' : '' }}">
                    {{ $category->title }}
                </a>
            @endif
        @endforeach
    </div>
@endif

<div class="useful-page">
    <section>
        <div class="useful-cards useful-cards--columns">
            @foreach($items as $item)
                <div class="useful-card useful-card--rose default">
                    <div class="useful-card__categories">
                        @forelse($item->categories as $category)
                            <span class="useful-card__category useful-card__kicker">{{ $category->title }}</span>
                        @empty
                            <span class="useful-card__category useful-card__kicker">Обучение</span>
                        @endforelse
                    </div>
                    <h3><a class="h3_teaser" href="{{ route($route, $item->slug) }}">{{ $item->title }}</a></h3>
                    {!! $item->short_desc !!}
                    <a class="useful-card__link teaser" href="{{ route($route, $item->slug) }}">Подробнее</a>
                </div>
            @endforeach
            {{ $items->withQueryString()->links('pagination::default') }}
        </div>
    </section>
</div>

<section class="edu-section edu-steps" aria-labelledby="steps-title">
    <div class="edu-section__heading edu-section__heading--center">
        <h2 id="steps-title">Как проходит обучение</h2>
        <p>Простой и понятный процесс от регистрации до получения сертификата</p>
    </div>

    <div class="edu-steps__grid">
        <article class="edu-step">
            <strong>01</strong>
            <div class="edu-step__icon"><img src="{{ asset('images/education/step-register.svg') }}" alt=""></div>
            <h3>Регистрация</h3>
            <p>Выберите программу и оформите заявку онлайн или по телефону</p>
        </article>
        <span class="edu-step__line" aria-hidden="true"></span>
        <article class="edu-step">
            <strong>02</strong>
            <div class="edu-step__icon"><img src="{{ asset('images/education/step-study.svg') }}" alt=""></div>
            <h3>Обучение</h3>
            <p>Изучайте материалы, смотрите лекции и выполняйте практические задания</p>
        </article>
        <span class="edu-step__line" aria-hidden="true"></span>
        <article class="edu-step">
            <strong>03</strong>
            <div class="edu-step__icon"><img src="{{ asset('images/education/step-practice.svg') }}" alt=""></div>
            <h3>Практика</h3>
            <p>Отработка навыков на реальных кейсах под руководством экспертов</p>
        </article>
        <span class="edu-step__line" aria-hidden="true"></span>
        <article class="edu-step">
            <strong>04</strong>
            <div class="edu-step__icon"><img src="{{ asset('images/education/step-certify.svg') }}" alt=""></div>
            <h3>Сертификация</h3>
            <p>Сдайте итоговый экзамен и получите документ о квалификации</p>
        </article>
    </div>
</section>
