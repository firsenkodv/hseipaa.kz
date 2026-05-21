<!-- Навигация -->
<div class="top_menu">
    <div class="header-nav-bar">
        <div class="header-inner">
            <nav class="header-nav" aria-label="Основная навигация">
                @foreach($navItems as $item)
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

                            <div class="nav-dropdown">
                                <div class="nav-dropdown-grid">
                                    @foreach($trainingCategories as $category)
                                        <div class="nav-dropdown-col">
                                            <a href="{{ route('training') }}?category={{ $category->slug }}"
                                               class="nav-dropdown-cat-title">
                                                {{ $category->title }}
                                            </a>
                                            <div class="nav-dropdown-items">
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
                                @foreach($schedules as $schedule)
                                    <a href="{{ route('schedule.show', $schedule->slug) }}"
                                       class="nav-dropdown-link {{ request()->routeIs('schedule.show') && request()->route('slug') === $schedule->slug ? 'nav-dropdown-link--active' : '' }}">
                                        {{ $schedule->menu_title ?: $schedule->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
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
                                @foreach($onlines as $online)
                                    <a href="{{ route('remote.show', $online->slug) }}"
                                       class="nav-dropdown-link {{ request()->routeIs('remote.show') && request()->route('slug') === $online->slug ? 'nav-dropdown-link--active' : '' }}">
                                        {{ $online->menu_title ?: $online->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
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
                                @foreach($item['dropdown'] as $sub)
                                    <a href="{{ route($sub['route']) }}"
                                       class="nav-dropdown-link {{ request()->routeIs($sub['pattern']) ? 'nav-dropdown-link--active' : '' }}">
                                        {{ $sub['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $item['route'] ? route($item['route']) : '#' }}"
                           class="header-nav-link {{ request()->routeIs($item['pattern']) ? 'header-nav-link--active' : '' }}">
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>

            <x-cabinet.enter />
        </div>
    </div>
</div>
