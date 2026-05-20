<footer class="footer">
    <div class="footer-inner">

        <div class="footer-top">
            <x-logo.logo prefix="footer-logo" />
        </div>

        <div class="footer-divider"></div>

        <nav class="footer-nav" aria-label="Навигация футера">
            @foreach(['footer_col_1', 'footer_col_2', 'footer_col_3', 'footer_col_4', 'footer_col_5'] as $k=>$colKey)
                @if(!empty($social[$colKey]))
                    <div class="footer-col footer-col-{{++$k}}">
                        @foreach($social[$colKey] as $item)
                            @if(!empty($item['label']))
                                <a href="{{ $item['url'] ?? '#' }}" class="footer-link">{{ $item['label'] }}</a>
                            @endif
                        @endforeach
                    </div>
                @endif
            @endforeach
            <div class="footer-col footer-col--contacts">
                @if(!empty($social['phone']))
                <a href="tel:{{ $social['phone'] }}" class="footer-phone">{{ format_phone($social['phone']) }}</a>
                @endif
                @if(!empty($social['email']))
                <a href="mailto:{{ $social['email'] }}" class="footer-email">{{ $social['email'] }}</a>
                @endif
                <x-socials.socials class="footer-social" btn-class="footer-social-btn" />
                <div class="footer-apps">
                    @if(!empty($social['app_store']))
                    <a href="{{ $social['app_store'] }}" class="footer-app-link" target="_blank" rel="noopener">
                        <img src="{{ Storage::url('/images/icons/footer/applestore.svg') }}" alt="App Store" class="footer-app-icon" />
                        Скачать в App Store
                    </a>
                    @endif
                    @if(!empty($social['google_play']))
                    <a href="{{ $social['google_play'] }}" class="footer-app-link" target="_blank" rel="noopener">
                        <img src="{{ Storage::url('/images/icons/footer/googlepay.svg') }}" alt="Google Play" class="footer-app-icon footer-app-icon--small" />
                        Скачать в Google Play
                    </a>
                    @endif
                </div>
            </div>
        </nav>

        <div class="footer-divider"></div>

        <div class="footer-bottom">
            <p>© 2006 - {{ date("Y") }} «Высшая Школа Экономики Институт профессиональных бухгалтеров и аудиторов»</p>
        </div>

    </div>
</footer>
