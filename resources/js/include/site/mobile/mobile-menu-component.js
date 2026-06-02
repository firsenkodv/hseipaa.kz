import {slideToggle} from '../../methods/slideToggle';
import {slideUp} from '../../methods/slideUp';

export function mobileMenuComponent() {

    const appMobileMenu    = document.querySelector('.app_mobile_menu')
    const appMobileContent = document.querySelector('.app_mobile_content')
    const appMobileClose   = document.querySelector('.app_mobile_close')

    if (!appMobileMenu) return

    // ── Открытие / закрытие оверлея ──────────────────────
    appMobileMenu.addEventListener('click', toggleMenu)
    appMobileClose.addEventListener('click', closeMenu)

    function toggleMenu(e) {
        const btn = e.target.closest('.app_mobile_menu')
        btn.classList.toggle('active')
        slideToggle(appMobileContent, 400)
    }

    function closeMenu() {
        appMobileMenu.classList.remove('active')
        slideToggle(appMobileContent, 400)
    }

    // ── Аккордеон mobile-nav ──────────────────────────────
    document.querySelectorAll('.mobile-nav__chevron-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const group   = btn.closest('.mobile-nav__group')
            const submenu = group.querySelector('.mobile-nav__submenu')
            const isOpen  = group.classList.contains('is-open')

            // Закрыть остальные открытые группы
            document.querySelectorAll('.mobile-nav__group.is-open').forEach(other => {
                if (other === group) return
                other.classList.remove('is-open')
                slideUp(other.querySelector('.mobile-nav__submenu'), 300)
            })

            group.classList.toggle('is-open', !isOpen)
            slideToggle(submenu, 300)
        })
    })
}
