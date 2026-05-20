<section class="join-section">
    <div class="join-inner">
        <div class="join-hero">
            <h2>Присоединяйтесь к нам сегодня</h2>
            <p>Станьте частью сообщества профессионалов. Получите качественное образование и откройте новые возможности для карьерного роста.</p>
            <div class="join-buttons">
                <a href="{{ route('training') }}" class="join-btn-primary">Начать обучение</a>
                <a href="#" class="join-btn-secondary open-fancybox" data-form="consult_me">Получить консультацию</a>
            </div>
        </div>
        <div class="join-divider"></div>
        <div class="join-contacts">
            <div class="join-phone">
                <span>Связь с нами в один клик, звоните.</span>
                @if(!empty($social['phone']))
                <a href="tel:{{ $social['phone'] }}">{{ format_phone($social['phone']) }}</a>
                @endif
            </div>
            <div class="join-messengers">
                <span>свяжитесь с нами в мессенджерах</span>
                <div class="join-messenger-icons">
                    @if(!empty($social['whatsapp']))
                    <a href="{{ $social['whatsapp'] }}" class="join-messenger-btn" aria-label="WhatsApp" target="_blank" rel="noopener">
                        <img src="{{ Storage::url('about/icons/whatsapp.svg') }}" alt="WhatsApp" width="46" height="46" />
                    </a>
                    @endif
                    @if(!empty($social['telegram']))
                    <a href="{{ $social['telegram'] }}" class="join-messenger-btn" aria-label="Telegram" target="_blank" rel="noopener">
                        <img src="{{ Storage::url('about/icons/telegram.svg') }}" alt="Telegram" width="46" height="46" />
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
