<header class="site-header">

    <!-- Топ-бар: сайты / телефон + город -->
    <div class="header-topbar">
        <div class="header-inner">
            <div class="header-sites">
                <a href="{{ route('home') }}" class="header-site-link header-site-link--active">
                    <img src="{{ Storage::url('/images/ic_logo.svg') }}" alt="" class="header-site-icon" />
                    ВШЭ ИПБА
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
                <a target="_blank" href="https://on.hseipaa.kz" class="header-login-mobile">
                    <img alt="Войти" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTE0LjUzNjEgMi42MTU3MkgxOC41MzYxQzE5LjA2NjYgMi42MTU3MiAxOS41NzUzIDIuODI2NDQgMTkuOTUwMyAzLjIwMTUxQzIwLjMyNTQgMy41NzY1OCAyMC41MzYxIDQuMDg1MjkgMjAuNTM2MSA0LjYxNTcyVjE4LjYxNTdDMjAuNTM2MSAxOS4xNDYyIDIwLjMyNTQgMTkuNjU0OSAxOS45NTAzIDIwLjAyOTlDMTkuNTc1MyAyMC40MDUgMTkuMDY2NiAyMC42MTU3IDE4LjUzNjEgMjAuNjE1N0gxNC41MzYxIiBzdHJva2U9IiNFRjUzM0YiIHN0cm9rZS13aWR0aD0iMS42IiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPHBhdGggZD0iTTkuNTM2MTMgMTYuNjE1N0wxNC41MzYxIDExLjYxNTdMOS41MzYxMyA2LjYxNTcyIiBzdHJva2U9IiNFRjUzM0YiIHN0cm9rZS13aWR0aD0iMS42IiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPHBhdGggZD0iTTE0LjUzNjEgMTEuNjE1N0gyLjUzNjEzIiBzdHJva2U9IiNFRjUzM0YiIHN0cm9rZS13aWR0aD0iMS42IiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPC9zdmc+Cg==">
                </a>
            </div>
        </div>
    </div>

<x-menu.top-menu />


</header>
