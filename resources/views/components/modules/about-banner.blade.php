@props([
    'title'        => '',
    'subtitle'     => '',
    'btn1'         => 'Начать обучение',
    'btn2'         => 'Получить консультацию',
    'quote'        => '',
    'authorName'   => '',
    'authorRole'   => '',
    'bannerDesktop' => 'about/banner.jpg',
    'bannerMobile'  => 'about/banner2.png',
])

@php
    $desktopUrl = Storage::url($bannerDesktop);
    $mobileUrl  = Storage::url($bannerMobile);
    $gradient   = 'linear-gradient(to top, rgba(0,0,0,0.82) 0%, rgba(0,0,0,0.3) 50%, transparent 100%)';
@endphp

<section class="about-banner banner-section">
    <div class="banner-inner js-banner-bg"
         data-desktop="{{ $desktopUrl }}"
         data-mobile="{{ $mobileUrl }}"
         style="background-image: {{ $gradient }}, url('{{ $desktopUrl }}')">
        <div class="banner-inside">
            <div class="banner-left">
                <h1 class="banner-title">{{ $title }}</h1>
                <p class="banner-subtitle">{{ $subtitle }}</p>
                <div class="banner-buttons">
                    <a href="{{ route('training') }}" class="banner-btn-primary">{{ $btn1 }}</a>
                    <a href="#" class="banner-btn-secondary open-fancybox" data-form="consult_me">{{ $btn2 }}</a>
                </div>
            </div>
            <div class="banner-right">
                <div class="banner-quote">
                    <span class="banner-quote-mark banner-quote-mark--open">&ldquo;</span>
                    <p class="banner-quote-text">{{ $quote }}</p>
                    <span class="banner-quote-mark banner-quote-mark--close">&rdquo;</span>
                </div>
                <div class="banner-author">
                    <div class="banner-author-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                        </svg>
                    </div>
                    <div class="banner-author-info">
                        <span class="banner-author-name">{{ $authorName }}</span>
                        <span class="banner-author-role">{{ $authorRole }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
(function () {
    var el = document.querySelector('.js-banner-bg');
    if (!el) return;
    var gradient = 'linear-gradient(to top, rgba(0,0,0,0.82) 0%, rgba(0,0,0,0.3) 50%, transparent 100%)';
    function update() {
        var img = window.innerWidth <= 565 ? el.dataset.mobile : el.dataset.desktop;
        el.style.backgroundImage = gradient + ", url('" + img + "')";
    }
    update();
    window.addEventListener('resize', update);
})();
</script>
