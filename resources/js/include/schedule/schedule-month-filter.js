import { openFancyboxForm } from '../fancybox/fancybox'

/**
 * schedule-month-filter.js
 *
 * Фильтрация таблицы расписания по месяцам через AJAX-запрос к серверу.
 *
 * Логика работы:
 *  1. При загрузке страницы определяем текущий месяц (например, "may").
 *  2. Ищем соответствующую кнопку в блоке .schedule-month-filter.
 *     Если кнопка найдена — делаем запрос на сервер за данными этого месяца.
 *     Если кнопки нет (для текущего месяца курсов не запланировано) — загружаем все записи ("all").
 *  3. При клике на любую кнопку месяца — делаем новый запрос и перерисовываем строки таблицы.
 *  4. Пока данные загружаются — показываем анимированный лоадер внутри таблицы.
 *
 * HTML-зависимости:
 *  - .schedule-table-section[data-month-filter-url]  — секция с URL для запросов
 *  - .schedule-month-filter                          — контейнер кнопок-месяцев
 *  - .schedule-month-filter__btn[data-schedule-month]— кнопка месяца (значение: "january" ... "all")
 *  - #schedule-table-body                            — контейнер строк таблицы (заменяется при каждом запросе)
 *  - #schedule-courses-empty                         — блок "ничего не найдено" (показывается/скрывается)
 *
 * Серверный эндпоинт:
 *  GET /raspisani/{slug}/months?month=january
 *  Возвращает JSON-массив объектов:
 *  [
 *    {
 *      course_title:    "Название курса",
 *      date_formatted:  "7 июня 2026",   // null если не задана
 *      date_type_label: "Ежемесячно",    // null если не задан
 *      note:  "вечерняя группа",
 *      time:  "18:00",
 *      price: "35 000 ₸",
 *      hours: "72"
 *    },
 *    ...
 *  ]
 */

/** Соответствие индекса Date.getMonth() → значению enum Month */
const MONTHS = [
    'january', 'february', 'march',    'april',
    'may',     'june',     'july',     'august',
    'september','october', 'november', 'december',
]

/**
 * Перерисовывает строки таблицы по полученным данным.
 *
 * @param {HTMLElement} bodyEl  — контейнер #schedule-table-body
 * @param {HTMLElement|null} emptyEl — блок "ничего не найдено"
 * @param {Array} items         — массив объектов курсов от сервера
 */
function renderRows(bodyEl, emptyEl, items) {
    if (!items.length) {
        bodyEl.innerHTML = ''
        if (emptyEl) emptyEl.style.display = 'block'
        return
    }

    if (emptyEl) emptyEl.style.display = 'none'

    bodyEl.innerHTML = items.map(item => `
        <article class="schedule-row"
                 data-course="${item.course_title}"
                 data-price="${item.price}"
                 data-date="${item.date_formatted || item.date_type_label || ''}">
            <div class="schedule-row__date">
                ${item.date_formatted  ? `<strong>${item.date_formatted}</strong>`  : ''}
                ${item.date_type_label ? `<span>${item.date_type_label}</span>`      : ''}
            </div>
            <div class="schedule-row__course"><strong>${item.course_title}</strong></div>
            <div class="schedule-row__note">${item.note}</div>
            <div class="schedule-row__time">${item.time}</div>
            <div class="schedule-row__price">${item.price}</div>
            <div class="schedule-row__hours"><span>Академические часы</span>${item.hours}</div>
        </article>
    `).join('')
}

/**
 * Показывает анимированный трёхточечный лоадер внутри таблицы
 * пока ожидается ответ сервера.
 *
 * @param {HTMLElement} bodyEl — контейнер #schedule-table-body
 */
function setLoader(bodyEl) {
    bodyEl.innerHTML = `
        <div class="schedule-table-loader">
            <span></span><span></span><span></span>
        </div>
    `
}

/**
 * Переключает активную кнопку фильтра.
 * Снимает класс is-active со всех кнопок, ставит на нужную.
 *
 * @param {HTMLElement} filterEl — контейнер .schedule-month-filter
 * @param {string} month         — значение месяца ("january" ... "all")
 */
function setActive(filterEl, month) {
    filterEl.querySelectorAll('[data-schedule-month]').forEach(b => b.classList.remove('is-active'))
    const btn = filterEl.querySelector(`[data-schedule-month="${month}"]`)
    if (btn) btn.classList.add('is-active')
}

/**
 * Основная функция загрузки данных по выбранному месяцу.
 * Последовательность:
 *  1. Помечает кнопку активной
 *  2. Показывает лоадер
 *  3. Делает GET-запрос к серверу с параметром ?month=...
 *  4. Отрисовывает строки или сообщение об ошибке
 *
 * @param {string} filterUrl     — базовый URL эндпоинта (из data-month-filter-url)
 * @param {string} month         — выбранный месяц или "all"
 * @param {HTMLElement} filterEl — контейнер кнопок
 * @param {HTMLElement} bodyEl   — контейнер строк таблицы
 * @param {HTMLElement|null} emptyEl — блок "ничего не найдено"
 */
async function fetchMonth(filterUrl, month, filterEl, bodyEl, emptyEl) {
    setActive(filterEl, month)
    setLoader(bodyEl)
    if (emptyEl) emptyEl.style.display = 'none'

    try {
        const resp  = await fetch(`${filterUrl}?month=${month}`)
        const items = await resp.json()
        renderRows(bodyEl, emptyEl, items)
    } catch {
        bodyEl.innerHTML = '<p class="schedule-courses-empty">Ошибка загрузки данных</p>'
    }
}

/**
 * Инициализация фильтра расписания по месяцам.
 * Вызывается один раз после DOMContentLoaded (из script.js).
 *
 * При загрузке страницы автоматически активирует текущий месяц.
 * Если для текущего месяца кнопки нет — показывает все записи.
 */
export function scheduleMonthFilter() {
    const filterEl = document.querySelector('.schedule-month-filter')
    if (!filterEl) return

    const section = document.querySelector('.schedule-table-section')
    const bodyEl  = document.getElementById('schedule-table-body')
    const emptyEl = document.getElementById('schedule-courses-empty')
    if (!section || !bodyEl) return

    const filterUrl = section.dataset.monthFilterUrl

    // Определяем текущий месяц и ищем для него кнопку фильтра
    const currentMonth    = MONTHS[new Date().getMonth()]
    const hasCurrentMonth = filterEl.querySelector(`[data-schedule-month="${currentMonth}"]`)
    const initialMonth    = hasCurrentMonth ? currentMonth : 'all'

    // Загружаем данные сразу при открытии страницы
    fetchMonth(filterUrl, initialMonth, filterEl, bodyEl, emptyEl)

    // Навешиваем один обработчик на весь контейнер кнопок (делегирование)
    filterEl.addEventListener('click', e => {
        const btn = e.target.closest('[data-schedule-month]')
        if (!btn) return
        fetchMonth(filterUrl, btn.dataset.scheduleMonth, filterEl, bodyEl, emptyEl)
    })

    // Делегированный клик по названию курса — открывает модальное окно записи
    bodyEl.addEventListener('click', e => {
        const courseEl = e.target.closest('.schedule-row__course')
        if (!courseEl) return
        const row = courseEl.closest('.schedule-row')
        const transferData = JSON.stringify({
            course: row.dataset.course  || '',
            price:  row.dataset.price   || '',
            date:   row.dataset.date    || '',
        })
        openFancyboxForm('schedule_enroll', transferData)
    })
}
