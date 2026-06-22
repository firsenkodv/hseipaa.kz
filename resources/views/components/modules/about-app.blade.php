@props(['title' => '', 'desc' => '', 'appStoreUrl' => '#', 'appGoogleUrl' => '#'])

<section class="app-section" aria-labelledby="app-title">
    <div class="app-inner">
        <div class="app-layout">
            <div class="app-content">
                <h2 id="app-title" class="app-title">{!! nl2br(e($title)) !!}</h2>
                <p class="app-desc">{{ $desc }}</p>
                <div class="app-store-buttons">
                    <a href="{{ $appStoreUrl }}" class="app-store-btn">
                        <svg class="app-store-icon" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
                            <path d="M14.94 5.19A4.38 4.38 0 0 0 16 2a4.44 4.44 0 0 0-3 1.52 4.17 4.17 0 0 0-1 3.09 3.69 3.69 0 0 0 2.94-1.42zm2.52 7.44a4.51 4.51 0 0 1 2.16-3.81 4.66 4.66 0 0 0-3.66-2c-1.56-.16-3 .91-3.83.91-.82 0-2-.89-3.3-.87a4.92 4.92 0 0 0-4.14 2.53C2.92 12.29 4.24 17 6 19.47c.8 1.21 1.8 2.58 3.12 2.53 1.22-.05 1.72-.8 3.21-.8 1.51 0 1.93.8 3.19.77 1.35-.05 2.23-1.27 3.06-2.48a11 11 0 0 0 1.38-2.85 4.41 4.41 0 0 1-2.5-3.01z"/>
                        </svg>
                        <div class="app-store-text">
                            <span>Доступно в</span>
                            <strong>App Store</strong>
                        </div>
                    </a>
                    <a href="{{ $appGoogleUrl }}" class="app-store-btn">
                        <svg class="app-store-icon" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
                            <path d="M3.18 23.76a2 2 0 0 0 2.88 1.8l13.7-7.86-3.06-3.06zM1.5 2.11v19.78l10.05-9.89zM20.34 9.8l-2.5-1.43-3.44 3.39 3.44 3.44 2.52-1.44a2 2 0 0 0 0-3.96zM6.06.44A2 2 0 0 0 3.18.24L13.96 11 17.02 7.94z"/>
                        </svg>
                        <div class="app-store-text">
                            <span>Скачайте в</span>
                            <strong>Google Play</strong>
                        </div>
                    </a>
                </div>
                <div class="app-qr">
                    <img src="{{ Storage::url('about/icon.png') }}" alt="QR код" class="app-qr-img" width="72" height="72" />
                    <span>Отсканируйте QR код чтобы<br>скачать мобильное</span>
                </div>
            </div>
            <div class="app-phones">
                <img src="{{ Storage::url('about/screen.png') }}" alt="Мобильное приложение на смартфоне" />
            </div>
        </div>
    </div>
</section>
