@props([
    'title' => 'Удобная платформа для обучения',
    'desc' => 'Современный личный кабинет с интуитивным интерфейсом. Управляйте своим обучением, отслеживайте прогресс и общайтесь с преподавателями в одном месте.',

])
<div class="platform-section-wrap">
<section class="platform-section" aria-labelledby="platform-title">
    <div class="platform-inner">
        <header class="platform-header">
            <h2 id="platform-title">{{ $title }}</h2>
            <p>{{ $desc }}</p>
        </header>

        <div class="platform-features">
            <article class="platform-feature">
                <div class="platform-feature-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                </div>
                <h3>Учебные материалы</h3>
                <p>Доступ ко всем лекциям, презентациям и заданиям</p>
            </article>

            <article class="platform-feature">
                <div class="platform-feature-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="4" width="18" height="17" rx="2"></rect><path d="M16 2v4"></path><path d="M8 2v4"></path><path d="M3 10h18"></path></svg>
                </div>
                <h3>Расписание занятий</h3>
                <p>Календарь с напоминаниями о предстоящих уроках</p>
            </article>

            <article class="platform-feature">
                <div class="platform-feature-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                </div>
                <h3>Прогресс</h3>
                <p>Статистика успеваемости и выполненных заданий</p>
            </article>

            <article class="platform-feature">
                <div class="platform-feature-icon">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2"></rect></svg>
                </div>
                <h3>Видеолекции</h3>
                <p>Смотрите лекции в любое удобное время</p>
            </article>
        </div>

        <div class="platform-mockup">
            <img src="{{ Storage::url('about/platform-mockup.png') }}" alt="Интерфейс образовательной платформы" />
        </div>
    </div>
</section>
</div>
