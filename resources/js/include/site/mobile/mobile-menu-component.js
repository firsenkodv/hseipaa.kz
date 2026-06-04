import {slideToggle} from '../../methods/slideToggle';
import {slideUp} from '../../methods/slideUp';
import {openFancyboxForm} from '../../fancybox/fancybox';

export function mobileMenuComponent() {

    const appMobileMenu     = document.querySelector('.app_mobile_menu')
    const appMobileContacts = document.querySelector('.app_mobile_contacts')
    const appMobileContent  = document.querySelector('.app_mobile_content')
    const appMobileClose    = document.querySelector('.app_mobile_close')

    if (!appMobileMenu) return

    const screenMenu     = document.getElementById('mobile_screen_menu')
    const screenContacts = document.getElementById('mobile_screen_contacts')
    const panelLabel     = document.getElementById('m_panel_label')

    // ── Клонируем con_item из .connection_absol в экран контактов ──
    const connectionAbsol = document.querySelector('.connection_absol')
    const contactsItems   = document.getElementById('mobile_contacts_items')
    if (connectionAbsol && contactsItems) {
        connectionAbsol.querySelectorAll('.con_item').forEach(function (item) {
            const clone = item.cloneNode(true)
            contactsItems.appendChild(clone)

            if (clone.classList.contains('open-fancybox')) {
                clone.addEventListener('click', async function (e) {
                    e.preventDefault()
                    const formTemplate = clone.dataset.form
                    const transferData = clone.dataset.transfer
                    await openFancyboxForm(formTemplate, transferData)
                })
            }
        })
    }

    let currentScreen = null // 'menu' | 'contacts' | null

    function showScreen(name) {
        screenMenu.style.display     = name === 'menu'     ? '' : 'none'
        screenContacts.style.display = name === 'contacts' ? '' : 'none'
        if (panelLabel) panelLabel.textContent = name === 'menu' ? 'Меню' : 'Контакты'
    }

    function openPanel(screen) {
        showScreen(screen)
        currentScreen = screen
        appMobileMenu.classList.toggle('active', screen === 'menu')
        if (appMobileContacts) appMobileContacts.classList.toggle('active', screen === 'contacts')
        slideToggle(appMobileContent, 400)
    }

    function switchScreen(screen) {
        showScreen(screen)
        currentScreen = screen
        appMobileMenu.classList.toggle('active', screen === 'menu')
        if (appMobileContacts) appMobileContacts.classList.toggle('active', screen === 'contacts')
    }

    function closePanel() {
        slideUp(appMobileContent, 400)
        currentScreen = null
        appMobileMenu.classList.remove('active')
        if (appMobileContacts) appMobileContacts.classList.remove('active')
    }

    // ── Вкладка «Меню» ───────────────────────────────────
    appMobileMenu.addEventListener('click', function () {
        if (currentScreen === null) {
            openPanel('menu')
        } else if (currentScreen === 'menu') {
            closePanel()
        } else {
            switchScreen('menu')
        }
    })

    // ── Вкладка «Контакты» ───────────────────────────────
    if (appMobileContacts) {
        appMobileContacts.addEventListener('click', function () {
            if (currentScreen === null) {
                openPanel('contacts')
            } else if (currentScreen === 'contacts') {
                closePanel()
            } else {
                switchScreen('contacts')
            }
        })
    }

    // ── Кнопка закрыть (✕) ──────────────────────────────
    appMobileClose.addEventListener('click', closePanel)

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
