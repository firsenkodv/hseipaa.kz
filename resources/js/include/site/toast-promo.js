const STORAGE_KEY = 'toast_promo_dismissed_until';

export function toastPromo() {
    const toast    = document.getElementById('toastPromo');
    const closeBtn = document.getElementById('toastPromoClose');

    if (!toast || !closeBtn) return;

    const dismissDays = parseInt(toast.dataset.dismissDays ?? '3', 10);

    // Если dismissDays > 0 — проверяем не истёк ли срок скрытия
    if (dismissDays > 0) {
        const dismissedUntil = localStorage.getItem(STORAGE_KEY);
        if (dismissedUntil && Date.now() < Number(dismissedUntil)) return;
    }

    setTimeout(() => {
        toast.classList.add('is-visible');
    }, 4000);

    closeBtn.addEventListener('click', () => {
        toast.classList.remove('is-visible');
        toast.classList.add('is-hiding');

        if (dismissDays > 0) {
            const until = Date.now() + dismissDays * 24 * 60 * 60 * 1000;
            localStorage.setItem(STORAGE_KEY, String(until));
        }
    });
}
