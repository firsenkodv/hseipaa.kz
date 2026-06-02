<nav class="mobile-nav">

    @foreach($navItems as $item)

        {{-- ───────────────────────────────────────────────
             Обучение: мегаменю → категории + программы
        ─────────────────────────────────────────────────── --}}
        @if(!empty($item['hasDropdown']))
            @php $open = request()->routeIs($item['pattern']); @endphp
            <div class="mobile-nav__group{{ $open ? ' is-open' : '' }}">
                <div class="mobile-nav__trigger">
                    <a href="{{ route($item['route']) }}"
                       class="mobile-nav__link{{ $open ? ' mobile-nav__link--active' : '' }}">
                        {{ $item['label'] }}
                    </a>
                    <button class="mobile-nav__chevron-btn" type="button" aria-label="Раскрыть подменю">
                        <svg width="16" height="16" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
                <div class="mobile-nav__submenu" style="{{ $open ? 'display:block' : 'display:none' }}">
                    @foreach($trainingCategories as $category)
                        <a href="{{ route('training') }}?category={{ $category->slug }}"
                           class="mobile-nav__cat-title">
                            {{ $category->title }}
                        </a>
                        @foreach($category->trainings as $training)
                            @php $subActive = request()->routeIs('training.show') && request()->route('slug') === $training->slug; @endphp
                            <a href="{{ route('training.show', $training->slug) }}"
                               class="mobile-nav__sublink{{ $subActive ? ' mobile-nav__sublink--active' : '' }}">
                                {{ $training->title }}
                            </a>
                        @endforeach
                    @endforeach
                </div>
            </div>

        {{-- ───────────────────────────────────────────────
             Консалтинг: мегаменю → категории + услуги
        ─────────────────────────────────────────────────── --}}
        @elseif(!empty($item['hasConsultingDropdown']))
            @php $open = request()->routeIs($item['pattern']); @endphp
            <div class="mobile-nav__group{{ $open ? ' is-open' : '' }}">
                <div class="mobile-nav__trigger">
                    <a href="{{ route($item['route']) }}"
                       class="mobile-nav__link{{ $open ? ' mobile-nav__link--active' : '' }}">
                        {{ $item['label'] }}
                    </a>
                    <button class="mobile-nav__chevron-btn" type="button" aria-label="Раскрыть подменю">
                        <svg width="16" height="16" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
                <div class="mobile-nav__submenu" style="{{ $open ? 'display:block' : 'display:none' }}">
                    @foreach($consultingCategories as $category)
                        <a href="{{ route('consulting') }}?category={{ $category->slug }}"
                           class="mobile-nav__cat-title">
                            {{ $category->title }}
                        </a>
                        @foreach($category->consultings as $consulting)
                            @php $subActive = request()->routeIs('consulting.show') && request()->route('slug') === $consulting->slug; @endphp
                            <a href="{{ route('consulting.show', $consulting->slug) }}"
                               class="mobile-nav__sublink{{ $subActive ? ' mobile-nav__sublink--active' : '' }}">
                                {{ $consulting->title }}
                            </a>
                        @endforeach
                    @endforeach
                </div>
            </div>

        {{-- ───────────────────────────────────────────────
             Расписание: простой список
        ─────────────────────────────────────────────────── --}}
        @elseif(!empty($item['hasScheduleDropdown']))
            @php $open = request()->routeIs($item['pattern']); @endphp
            <div class="mobile-nav__group{{ $open ? ' is-open' : '' }}">
                <div class="mobile-nav__trigger">
                    <a href="{{ route($item['route']) }}"
                       class="mobile-nav__link{{ $open ? ' mobile-nav__link--active' : '' }}">
                        {{ $item['label'] }}
                    </a>
                    <button class="mobile-nav__chevron-btn" type="button" aria-label="Раскрыть подменю">
                        <svg width="16" height="16" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
                <div class="mobile-nav__submenu" style="{{ $open ? 'display:block' : 'display:none' }}">
                    @foreach($schedules as $schedule)
                        @php $subActive = request()->routeIs('schedule.show') && request()->route('slug') === $schedule->slug; @endphp
                        <a href="{{ route('schedule.show', $schedule->slug) }}"
                           class="mobile-nav__sublink{{ $subActive ? ' mobile-nav__sublink--active' : '' }}">
                            {{ $schedule->menu_title ?: $schedule->title }}
                        </a>
                    @endforeach
                </div>
            </div>

        {{-- ───────────────────────────────────────────────
             Online: простой список
        ─────────────────────────────────────────────────── --}}
        @elseif(!empty($item['hasOnlineDropdown']))
            @php $open = request()->routeIs($item['pattern']); @endphp
            <div class="mobile-nav__group{{ $open ? ' is-open' : '' }}">
                <div class="mobile-nav__trigger">
                    <a href="{{ route($item['route']) }}"
                       class="mobile-nav__link{{ $open ? ' mobile-nav__link--active' : '' }}">
                        {{ $item['label'] }}
                    </a>
                    <button class="mobile-nav__chevron-btn" type="button" aria-label="Раскрыть подменю">
                        <svg width="16" height="16" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
                <div class="mobile-nav__submenu" style="{{ $open ? 'display:block' : 'display:none' }}">
                    @foreach($onlines as $online)
                        @php $subActive = request()->routeIs('remote.show') && request()->route('slug') === $online->slug; @endphp
                        <a href="{{ route('remote.show', $online->slug) }}"
                           class="mobile-nav__sublink{{ $subActive ? ' mobile-nav__sublink--active' : '' }}">
                            {{ $online->menu_title ?: $online->title }}
                        </a>
                    @endforeach
                </div>
            </div>

        {{-- ───────────────────────────────────────────────
             О нас / Полезное: статичные подпункты
        ─────────────────────────────────────────────────── --}}
        @elseif(!empty($item['dropdown']))
            @php $open = request()->routeIs($item['pattern']); @endphp
            <div class="mobile-nav__group{{ $open ? ' is-open' : '' }}">
                <div class="mobile-nav__trigger">
                    <a href="{{ route($item['route']) }}"
                       class="mobile-nav__link{{ $open ? ' mobile-nav__link--active' : '' }}">
                        {{ $item['label'] }}
                    </a>
                    <button class="mobile-nav__chevron-btn" type="button" aria-label="Раскрыть подменю">
                        <svg width="16" height="16" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
                <div class="mobile-nav__submenu" style="{{ $open ? 'display:block' : 'display:none' }}">
                    @foreach($item['dropdown'] as $sub)
                        @php $subActive = request()->routeIs($sub['pattern']); @endphp
                        <a href="{{ route($sub['route']) }}"
                           class="mobile-nav__sublink{{ $subActive ? ' mobile-nav__sublink--active' : '' }}">
                            {{ $sub['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>

        {{-- ───────────────────────────────────────────────
             Обычная ссылка (Главная, Контакты)
        ─────────────────────────────────────────────────── --}}
        @else
            <a href="{{ route($item['route']) }}"
               class="mobile-nav__item{{ request()->routeIs($item['pattern']) ? ' mobile-nav__item--active' : '' }}">
                {{ $item['label'] }}
            </a>
        @endif

    @endforeach

</nav>
