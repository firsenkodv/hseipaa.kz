
import SlimSelect from 'slim-select'
import 'slim-select/styles' // optional css import method
import 'slim-select/scss' // optional scss import method
import { openFancyboxForm } from '../fancybox/fancybox'

export function slimSelect() {
    const el = document.querySelector('.selectElement')
    if (!el) return

    const filterUrl = el.dataset.filterUrl

    new SlimSelect({
        select: el,
        settings: {
            searchPlaceholder: 'Поиск...',
            allowDeselect: true,
            deselectLabel: '&times;',
            placeholderText: 'Выберите курс...',
        },
        events: {
            afterChange: (newVal) => {
                const id = newVal[0]?.value
                if (!id) {
                    const resultsEl = document.getElementById('schedule-results')
                    if (resultsEl) { resultsEl.innerHTML = ''; resultsEl.style.display = 'none' }
                    return
                }
                if (!filterUrl) return
                fetchCourseSchedule(filterUrl, id, newVal[0]?.text || '')
            },
        },
    })
}

async function fetchCourseSchedule(url, courseId, courseTitle = '') {
    const resultsEl = document.getElementById('schedule-results')
    if (!resultsEl) return

    resultsEl.style.display = 'flex'
    resultsEl.innerHTML = `
        <div class="schedule-results__loader">
            <span></span><span></span><span></span>
        </div>
    `

    try {
        const [resp] = await Promise.all([
            fetch(`${url}?course_id=${courseId}`),
            new Promise(resolve => setTimeout(resolve, 1000)),
        ])
        const data = await resp.json()
        renderScheduleResults(resultsEl, data, courseTitle)
    } catch {
        resultsEl.innerHTML = '<p class="schedule-results__error">Ошибка загрузки данных</p>'
    }
}

function renderScheduleResults(container, items, courseTitle = '') {
    if (!items.length) {
        container.innerHTML = '<p class="schedule-results__empty">По выбранному курсу ничего не найдено</p>'
        return
    }

    container.innerHTML = items.map(item => {
        const priceStr = item.price ? `${item.price}${item.currency ? ' ' + item.currency : ' ₸'}` : ''
        const dateStr  = item.date || item.date_type || (item.months?.join(', ') || '')
        return `
        <div class="schedule-result-item"
             data-course="${courseTitle}"
             data-price="${priceStr}"
             data-date="${dateStr}">
            <button class="schedule-result-item__close" aria-label="Скрыть">&times;</button>
            <a href="${item.url}" class="schedule-result-item__city" target="_blank" rel="noopener noreferrer">${item.city}</a>
            <ul class="schedule-result-item__list">
                ${item.date      ? `<li><span>Дата начала</span><b>${item.date}</b></li>` : ''}
                ${item.date_type ? `<li><span>Периодичность</span><b>${item.date_type}</b></li>` : ''}
                ${item.months?.length ? `<li><span>Месяцы</span><b>${item.months.join(', ')}</b></li>` : ''}
                ${item.time      ? `<li><span>Время проведения</span><b>${item.time}</b></li>` : ''}
                ${item.hours     ? `<li><span>Академических часов</span><b>${item.hours}</b></li>` : ''}
                ${item.price     ? `<li><span>Стоимость</span><b>${priceStr}</b></li>` : ''}
                ${item.note      ? `<li><span>Примечание</span><b>${item.note}</b></li>` : ''}
            </ul>
            <div class="schedule-result-item__footer">
                <button class="schedule-result-item__enroll" type="button">Записаться</button>
            </div>
        </div>
    `}).join('')

    container.querySelectorAll('.schedule-result-item__close').forEach(btn => {
        btn.addEventListener('click', () => btn.closest('.schedule-result-item').style.display = 'none')
    })

    container.querySelectorAll('.schedule-result-item__enroll').forEach(btn => {
        btn.addEventListener('click', () => {
            const card = btn.closest('.schedule-result-item')
            openFancyboxForm('schedule_enroll', JSON.stringify({
                course: card.dataset.course || '',
                price:  card.dataset.price  || '',
                date:   card.dataset.date   || '',
            }))
        })
    })
}
