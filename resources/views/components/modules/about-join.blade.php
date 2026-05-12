<section class="join-section">
    <div class="join-inner">
        <div class="join-hero">
            <h2>Присоединяйтесь к нам сегодня</h2>
            <p>Станьте частью сообщества профессионалов. Получите качественное образование и откройте новые возможности для карьерного роста.</p>
            <div class="join-buttons">
                <a href="{{ route('training') }}" class="join-btn-primary">Начать обучение</a>
                <a href="{{ route('consulting') }}" class="join-btn-secondary">Получить консультацию</a>
            </div>
        </div>
        <div class="join-divider"></div>
        <div class="join-contacts">
            <div class="join-phone">
                <span>Связь с нами в один клик, звоните.</span>
                <a href="tel:+77272242121">+7 (727) 224 21 21</a>
            </div>
            <div class="join-messengers">
                <span>свяжитесь с нами в мессенджерах</span>
                <div class="join-messenger-icons">
                    <a href="#" class="join-messenger-btn" aria-label="WhatsApp">
                        <img src="{{ Storage::url('about/icons/whatsapp.svg') }}" alt="WhatsApp" width="46" height="46" />
                    </a>
                    <a href="#" class="join-messenger-btn" aria-label="Telegram">
                        <img src="{{ Storage::url('about/icons/telegram.svg') }}" alt="Telegram" width="46" height="46" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
