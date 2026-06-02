import { openFancyboxForm } from '../fancybox/fancybox';

const STORAGE_KEY = 'promo_modal_dismissed_until';

export function promoModal() {
    const el = document.getElementById('promoModal');
    if (!el) return;

    const dismissDays = parseInt(el.dataset.dismissDays ?? '3', 10);
    const delay       = parseInt(el.dataset.delay ?? '4', 10) * 1000;

    if (dismissDays === 0) {
        localStorage.removeItem(STORAGE_KEY);
    } else {
        const dismissedUntil = localStorage.getItem(STORAGE_KEY);
        if (dismissedUntil && Date.now() < Number(dismissedUntil)) return;
    }

    setTimeout(async () => {
        if (dismissDays > 0) {
            const until = Date.now() + dismissDays * 24 * 60 * 60 * 1000;
            localStorage.setItem(STORAGE_KEY, String(until));
        }
        await openFancyboxForm('record_me');
    }, delay);
}
