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
            <x-contacts.city-selector />
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

<x-menu.top-menu />


</header>
