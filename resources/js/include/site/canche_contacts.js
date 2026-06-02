import { slideDown } from '../methods/slideDown.js';
import { slideUp } from '../methods/slideUp.js';

export function canche_contacts() {
    document.body.addEventListener('click', function (event) {
        const formBtn = event.target.closest('.con_item__1');
        if (formBtn) {
            closeMenu();
            return;
        }

        const el = event.target.closest('._canche__js');
        if (!el) return;

        const type   = el.dataset.type;
        const object = el.dataset.object;
        const token  = document.querySelector('meta[name="csrf-token"]')?.content;

        fetch('/canche.contacts', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
            },
            body: JSON.stringify({ type, object }),
        });
    });
}

function fadeIn(el) {
    el.style.display = 'block';
    el.style.opacity = '0';
    requestAnimationFrame(() => {
        el.style.transition = 'opacity 0.4s';
        el.style.opacity    = '1';
    });
}

function fadeOut(el) {
    el.style.transition = 'opacity 0.4s';
    el.style.opacity    = '0';
    setTimeout(() => {
        el.style.display = 'none';
        el.style.removeProperty('opacity');
        el.style.removeProperty('transition');
    }, 400);
}

function closeMenu() {
    const fixed   = document.querySelector('.connection_fixed');
    const absol   = document.querySelector('.connection_absol');
    const sendBtn = document.querySelector('.connect_send');

    sendBtn?.classList.remove('close');
    if (fixed) fadeOut(fixed);
    if (absol) slideUp(absol, 600);
}

export function toggle_contacts() {
    document.body.addEventListener('click', function (event) {
        // Клик по оверлею (не по панели внутри него) — закрыть
        if (event.target.closest('.connection_fixed') && !event.target.closest('.connection_absol')) {
            closeMenu();
            return;
        }

        const sendBtn = event.target.closest('.connect_send');
        if (!sendBtn) return;

        const fixed = document.querySelector('.connection_fixed');
        const absol = document.querySelector('.connection_absol');

        sendBtn.classList.toggle('close');

        if (sendBtn.classList.contains('close')) {
            if (fixed) fadeIn(fixed);
            if (absol) slideDown(absol, 600);
        } else {
            if (fixed) fadeOut(fixed);
            if (absol) slideUp(absol, 600);
        }
    });
}

export function cancheContacts() {
    canche_contacts();
    toggle_contacts();
    scroll_top();
}

export function scroll_top() {
    const btn   = document.getElementById('scrollTopBtn');
    const absol = document.querySelector('.connection_absol');
    if (!btn) return;

    window.addEventListener('scroll', function () {
        const isVisible = window.scrollY > 300;
        btn.classList.toggle('show', isVisible);
        absol?.classList.toggle('scroll-btn-offset', isVisible);
    });

    btn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}
