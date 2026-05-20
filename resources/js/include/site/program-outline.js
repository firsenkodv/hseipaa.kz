import { slideDown } from '../methods/slideDown';
import { slideUp } from '../methods/slideUp';

export function programOutlineScroll() {
    const btn    = document.querySelector('.js-scroll-to-outline');
    const target = document.getElementById('program-outline');
    if (!btn || !target) return;

    btn.addEventListener('click', () => {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
}

export function programOutlineAccordion() {
    const modules = document.querySelectorAll('.program-module');
    if (!modules.length) return;

    modules.forEach(module => {
        const list = module.querySelector('.program-module__list');
        if (list && !module.classList.contains('is-active')) {
            list.style.display = 'none';
        }
    });

    modules.forEach(module => {
        const btn  = module.querySelector('.program-module__header');
        const list = module.querySelector('.program-module__list');
        const icon = btn ? btn.querySelector('img') : null;

        if (!btn) return;

        const iconPlus  = btn.dataset.iconPlus;
        const iconClose = btn.dataset.iconClose;

        btn.addEventListener('click', () => {
            if (module.classList.contains('is-active')) {
                module.classList.remove('is-active');
                if (list) slideUp(list, 300);
                if (icon && iconPlus) icon.src = iconPlus;
            } else {
                module.classList.add('is-active');
                if (list) slideDown(list, 300);
                if (icon && iconClose) icon.src = iconClose;
            }
        });
    });
}
