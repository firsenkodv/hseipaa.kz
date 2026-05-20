export function navDropdown() {
    const items = document.querySelectorAll('.has-dropdown');

    if (!items.length) return;

    items.forEach(item => {
        const trigger = item.querySelector('.header-nav-chevron-btn');

        if (!trigger) return;

        trigger.addEventListener('click', e => {
            e.stopPropagation();

            const isOpen = item.classList.contains('is-open');

            // Закрываем все остальные
            items.forEach(other => {
                if (other !== item) other.classList.remove('is-open');
            });

            item.classList.toggle('is-open', !isOpen);
        });
    });

    document.addEventListener('click', () => {
        items.forEach(item => item.classList.remove('is-open'));
    });
}
