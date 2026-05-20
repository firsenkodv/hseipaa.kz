<header class="site-header">

    <!-- Топ-бар: сайты / телефон + город -->
    <div class="header-topbar">
        <div class="header-inner">
            <div class="header-sites">
                <a href="{{ route('home') }}" class="header-site-link header-site-link--active">
                    <img src="{{ Storage::url('/images/ic_logo.svg') }}" alt="" class="header-site-icon" />
                    hseipaa.kz
                </a>
                <a href="https://on.hseipaa.kz" class="header-site-link">
                    <img src="{{ Storage::url('/images/ic_logo.svg') }}" alt="" class="header-site-icon" />
                    online обучение
                </a>
                <a href="https://in.hseipaa.kz" class="header-site-link">
                    <img src="{{ Storage::url('/images/enpa.svg') }}" width="96" height="28"  alt="" class="header-site-icon header-site-icon-enpa" />
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
                    <x-language.header-language-component />
                </div>
            </div>
        </div>
    </div>

<x-menu.top-menu />


</header>
