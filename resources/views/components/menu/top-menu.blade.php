<!-- Навигация -->
<div class="top_menu">
    <div class="header-nav-bar">
        <div class="header-inner">
            <nav class="header-nav" aria-label="Основная навигация">
                @foreach($navItems as $item)

                    {{-- Обучение: мега-дропдаун с категориями и программами (4 колонки) --}}
                    @if(!empty($item['hasDropdown']))
                        <div class="header-nav-item has-dropdown">
                            <div class="header-nav-link-wrap {{ request()->routeIs($item['pattern']) ? 'header-nav-link--active' : '' }}">
                                <a href="{{ route($item['route']) }}" class="header-nav-link">
                                    {{ $item['label'] }}
                                </a>
                                <button class="header-nav-chevron-btn">
                                    <svg class="nav-dropdown-chevron" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="nav-dropdown nav-dropdown--training">
                                <div class="nav-dropdown-grid">
                                    {{-- Колонка = одна категория обучения со списком программ --}}
                                    @foreach($trainingCategories as $category)
                                        <div class="nav-dropdown-col">
                                            {{-- Заголовок категории — ссылка на список с фильтром --}}
                                            <a href="{{ route('training') }}?category={{ $category->slug }}"
                                               class="nav-dropdown-cat-title">
                                                {{ $category->title }}
                                            </a>
                                            <div class="nav-dropdown-items">
                                                {{-- Программы обучения внутри категории --}}
                                                @foreach($category->trainings as $training)
                                                    <a href="{{ route('training.show', $training->slug) }}"
                                                       class="nav-dropdown-item {{ request()->routeIs('training.show') && request()->route('slug') === $training->slug ? 'nav-dropdown-item--active' : '' }}">
                                                        {{ $training->title }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    {{-- Консалтинг: мега-дропдаун с категориями и услугами (2 колонки, ~50% ширины) --}}
                    @elseif(!empty($item['hasConsultingDropdown']))
                        <div class="header-nav-item has-dropdown">
                            <div class="header-nav-link-wrap {{ request()->routeIs($item['pattern']) ? 'header-nav-link--active' : '' }}">
                                <a href="{{ route($item['route']) }}" class="header-nav-link">
                                    {{ $item['label'] }}
                                </a>
                                <button class="header-nav-chevron-btn">
                                    <svg class="nav-dropdown-chevron" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="nav-dropdown nav-dropdown--consulting">
                                <div class="nav-dropdown-grid nav-dropdown-grid--2col">
                                    {{-- Колонка = одна категория консалтинга со списком услуг --}}
                                    @foreach($consultingCategories as $category)
                                        <div class="nav-dropdown-col">
                                            {{-- Заголовок категории — ссылка на список с фильтром --}}
                                            <a href="{{ route('consulting') }}?category={{ $category->slug }}"
                                               class="nav-dropdown-cat-title">
                                                {{ $category->title }}
                                            </a>
                                            <div class="nav-dropdown-items">
                                                {{-- Услуги консалтинга внутри категории --}}
                                                @foreach($category->consultings as $consulting)
                                                    <a href="{{ route('consulting.show', $consulting->slug) }}"
                                                       class="nav-dropdown-item {{ request()->routeIs('consulting.show') && request()->route('slug') === $consulting->slug ? 'nav-dropdown-item--active' : '' }}">
                                                        {{ $consulting->title }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    {{-- Расписание: простой дропдаун со списком страниц расписания --}}
                    @elseif(!empty($item['hasScheduleDropdown']))
                        <div class="header-nav-item has-dropdown has-dropdown--simple">
                            <div class="header-nav-link-wrap {{ request()->routeIs($item['pattern']) ? 'header-nav-link--active' : '' }}">
                                <a href="{{ route($item['route']) }}" class="header-nav-link">
                                    {{ $item['label'] }}
                                </a>
                                <button class="header-nav-chevron-btn">
                                    <svg class="nav-dropdown-chevron" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="nav-dropdown nav-dropdown--simple">
                                {{-- Страницы расписания (menu_title приоритетнее title) --}}
                                @foreach($schedules as $schedule)
                                    <a href="{{ route('schedule.show', $schedule->slug) }}"
                                       class="nav-dropdown-link {{ request()->routeIs('schedule.show') && request()->route('slug') === $schedule->slug ? 'nav-dropdown-link--active' : '' }}">
                                        {{ $schedule->menu_title ?: $schedule->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                    {{-- Online: простой дропдаун со списком онлайн-курсов --}}
                    @elseif(!empty($item['hasOnlineDropdown']))
                        <div class="header-nav-item has-dropdown has-dropdown--simple">
                            <div class="header-nav-link-wrap {{ request()->routeIs($item['pattern']) ? 'header-nav-link--active' : '' }}">
                                <a href="{{ route($item['route']) }}" class="header-nav-link">
                                    {{ $item['label'] }}
                                </a>
                                <button class="header-nav-chevron-btn">
                                    <svg class="nav-dropdown-chevron" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="nav-dropdown nav-dropdown--simple">
                                {{-- Онлайн-курсы (menu_title приоритетнее title) --}}
                                @foreach($onlines as $online)
                                    <a href="{{ route('remote.show', $online->slug) }}"
                                       class="nav-dropdown-link {{ request()->routeIs('remote.show') && request()->route('slug') === $online->slug ? 'nav-dropdown-link--active' : '' }}">
                                        {{ $online->menu_title ?: $online->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                    {{-- О нас / Полезное: простой дропдаун со статичными подпунктами из $navItems --}}
                    @elseif(!empty($item['dropdown']))
                        <div class="header-nav-item has-dropdown has-dropdown--simple">
                            <div class="header-nav-link-wrap {{ request()->routeIs($item['pattern']) ? 'header-nav-link--active' : '' }}">
                                <a href="{{ route($item['route']) }}" class="header-nav-link">
                                    {{ $item['label'] }}
                                </a>
                                <button class="header-nav-chevron-btn">
                                    <svg class="nav-dropdown-chevron" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="nav-dropdown nav-dropdown--simple">
                                {{-- Подпункты заданы статично в TopMenu.php --}}
                                @foreach($item['dropdown'] as $sub)
                                    <a href="{{ route($sub['route']) }}"
                                       class="nav-dropdown-link {{ request()->routeIs($sub['pattern']) ? 'nav-dropdown-link--active' : '' }}">
                                        {{ $sub['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                    {{-- Обычная ссылка без дропдауна (Главная, Контакты) --}}
                    @else
                        <a href="{{ $item['route'] ? route($item['route']) : '#' }}"
                           class="header-nav-link {{ request()->routeIs($item['pattern']) ? 'header-nav-link--active' : '' }}">
                            {{ $item['label'] }}
                        </a>
                    @endif

                @endforeach
            </nav>

            {{-- Кнопка входа в личный кабинет --}}
            <x-cabinet.enter />
        </div>
    </div>
</div>
