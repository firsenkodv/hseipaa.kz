<footer class="footer">
    <div class="footer-inner">

        <div class="footer-top">
            <x-logo.logo prefix="footer-logo" />
        </div>

        <div class="footer-divider"></div>

        <nav class="footer-nav" aria-label="Навигация футера">
            <div class="footer-col">
                <a href="#" class="footer-link active">Online курсы</a>
                <a href="#" class="footer-link">Главная</a>
                <a href="#" class="footer-link">О нас</a>
                <a href="#" class="footer-link">Контакты</a>
                <a href="#" class="footer-link">Карта сайта</a>
            </div>
            <div class="footer-col">
                <a href="#" class="footer-link">Обучение</a>
                <a href="#" class="footer-link">Консалтинг</a>
                <a href="#" class="footer-link">Расписание</a>
                <a href="#" class="footer-link">Полезное</a>
            </div>
            <div class="footer-col">
                <a href="#" class="footer-link">Вопросы</a>
                <a href="#" class="footer-link">Оплата</a>
                <a href="#" class="footer-link">Сертификация</a>
                <a href="#" class="footer-link">Договор</a>
            </div>
            <div class="footer-col">
                <a href="#" class="footer-link">Законы</a>
                <a href="#" class="footer-link">Документы</a>
                <a href="#" class="footer-link">Программы курсов</a>
                <a href="#" class="footer-link">Задачники</a>
            </div>
            <div class="footer-col">
                <a href="#" class="footer-link">Статус бухгалтера</a>
                <a href="#" class="footer-link">Содержание CAP</a>
            </div>
            <div class="footer-col footer-col--contacts">
                <a href="tel:+77272242121" class="footer-phone">+7 (727) 224 21 21</a>
                <a href="mailto:sayhi@hseiipa.kz" class="footer-email">sayhi@hseiipa.kz</a>
                <x-socials.socials class="footer-social" btn-class="footer-social-btn" />
                <div class="footer-apps">
                    <a href="#" class="footer-app-link">
                        <img src="{{ Storage::url('/images/icons/footer/applestore.svg') }}" alt="App Store" class="footer-app-icon" />
                        Скачать в App Store
                    </a>
                    <a href="#" class="footer-app-link">
                        <img src="{{ Storage::url('/images/icons/footer/googlepay.svg') }}" alt="Google Play" class="footer-app-icon footer-app-icon--small" />
                        Скачать в Google Play
                    </a>
                </div>
            </div>
        </nav>

        <div class="footer-divider"></div>

        <div class="footer-bottom">
            <p>© 2006 - 2021 «Высшая Школа Экономики Институт профессиональных бухгалтеров и аудиторов»</p>
        </div>

    </div>
</footer>
