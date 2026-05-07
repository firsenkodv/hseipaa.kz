<header class="site-header">

    <!-- Топ-бар: сайты / телефон + город -->
    <div class="header-topbar">
        <div class="header-inner">
            <div class="header-sites">
                <a href="#" class="header-site-link header-site-link--active">
                    <img src="{{ Storage::url('/images/ic_logo.svg') }}" alt="" class="header-site-icon" />
                    hseipaa.kz
                </a>
                <a href="#" class="header-site-link">
                    <img src="{{ Storage::url('/images/ic_logo.svg') }}" alt="" class="header-site-icon" />
                    on.hseipaa.kz online
                </a>
                <a href="#" class="header-site-link">
                    <img src="{{ Storage::url('/images/ic_logo.svg') }}" alt="" class="header-site-icon" />
                    Портал бухгалтеров
                </a>
            </div>
            <div class="header-topbar-right">
                <a href="tel:+77272242121" class="header-topbar-phone">+ 7 (727) 224 21 21</a>
                <button class="header-city">
                    Алматы
                    <svg viewBox="0 0 16 16" width="12" height="12" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <polyline points="4 6 8 10 12 6"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Средняя зона: логотип / соцсети + язык -->
    <div class="header-middle">
        <div class="header-inner">
            <x-logo.logo prefix="header-logo" />
            <div class="header-middle-right">
                <x-socials.socials class="header-socials" btn-class="header-social-btn" />
                <div class="header-lang">
                    <a href="#" class="header-lang-btn">Қаз</a>
                    <a href="#" class="header-lang-btn header-lang-btn--active">Рус</a>
                    <a href="#" class="header-lang-btn">Eng</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Навигация -->
    <div class="header-nav-bar">
        <div class="header-inner">
            <nav class="header-nav" aria-label="Основная навигация">
                <a href="#" class="header-nav-link">Главная</a>
                <a href="#" class="header-nav-link header-nav-link--dropdown">О нас
                    <svg viewBox="0 0 16 16" width="12" height="12" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><polyline points="4 6 8 10 12 6"/></svg>
                </a>
                <a href="#" class="header-nav-link header-nav-link--dropdown header-nav-link--active">Обучение
                    <svg viewBox="0 0 16 16" width="12" height="12" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><polyline points="4 6 8 10 12 6"/></svg>
                </a>
                <a href="#" class="header-nav-link header-nav-link--dropdown">Консалтинг
                    <svg viewBox="0 0 16 16" width="12" height="12" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><polyline points="4 6 8 10 12 6"/></svg>
                </a>
                <a href="#" class="header-nav-link header-nav-link--dropdown">Online
                    <svg viewBox="0 0 16 16" width="12" height="12" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><polyline points="4 6 8 10 12 6"/></svg>
                </a>
                <a href="#" class="header-nav-link header-nav-link--dropdown">Расписание
                    <svg viewBox="0 0 16 16" width="12" height="12" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><polyline points="4 6 8 10 12 6"/></svg>
                </a>
                <a href="#" class="header-nav-link header-nav-link--dropdown">Полезное
                    <svg viewBox="0 0 16 16" width="12" height="12" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><polyline points="4 6 8 10 12 6"/></svg>
                </a>
                <a href="#" class="header-nav-link">Контакты</a>
            </nav>
            <a href="#" class="header-login">Войти
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
            </a>
            <button class="header-burger" aria-label="Открыть меню" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>

    <!-- Мобильное меню -->
    <div class="header-mobile-menu" aria-hidden="true">
        <nav class="header-mobile-nav">
            <a href="#" class="header-mobile-link">Главная</a>
            <a href="#" class="header-mobile-link">О нас</a>
            <a href="#" class="header-mobile-link header-mobile-link--active">Обучение</a>
            <a href="#" class="header-mobile-link">Консалтинг</a>
            <a href="#" class="header-mobile-link">Online</a>
            <a href="#" class="header-mobile-link">Расписание</a>
            <a href="#" class="header-mobile-link">Полезное</a>
            <a href="#" class="header-mobile-link">Контакты</a>
        </nav>
        <div class="header-mobile-bottom">
            <a href="tel:+77272242121" class="header-mobile-phone">+7 (727) 224 21 21</a>
            <div class="header-mobile-row">
                <x-socials.socials class="header-socials" btn-class="header-social-btn" />
                <div class="header-lang">
                    <a href="#" class="header-lang-btn">Қаз</a>
                    <a href="#" class="header-lang-btn header-lang-btn--active">Рус</a>
                    <a href="#" class="header-lang-btn">Eng</a>
                </div>
            </div>
            <a href="#" class="header-login">Войти</a>
        </div>
    </div>

</header>
