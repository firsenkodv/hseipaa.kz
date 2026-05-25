export function headerScroll() {
    const header = document.querySelector('.site-header');
    if (!header) return;

    const update = () => {
        header.classList.toggle('scrolled', window.scrollY > 5);
    };

    window.addEventListener('scroll', update, { passive: true });
    update();
}
