import { Fancybox } from "@fancyapps/ui/dist/fancybox/";
import "@fancyapps/ui/dist/fancybox/fancybox.css";
import {asyncExecution} from "../form_async/async_execution";
import {scrollCabinetMessages} from "./cabinet_message";


/*Fancybox.bind('[data-fancybox]', {

    zoomEffect: false,
    hideScrollbar: false, // Оставляем скроллбар видимым
    dragToClose: false,
    clickOutside: false,
    preventViewportChange: true, // Добавьте эту опцию, чтобы предотвратить смену положения просмотра
    userSelectableContent: true, // Разрешаем выделять текст внутри модального окна
    touch: false,

});*/

Fancybox.bind('[data-fancybox="gallery"]', {
    animated: true,
    dragToClose: true,
});

Fancybox.bind('[data-fancybox="advantages-video"]', {
    animated: false,
    dragToClose: false,
    closeButton: true,
    backdropClick: 'close',
});

/** получаем csrf **/
const metaElements = document.querySelectorAll('meta[name="csrf-token"]');
const csrf = metaElements.length > 0 ? metaElements[0].content : "";
/** получаем csrf **/


const fancyWindows = Array.from(document.querySelectorAll('.open-fancybox'))

/** открыть open-fancybox **/
for (let fancyWindow of fancyWindows) {
    fancyWindow.addEventListener('click', openFancyBox)
}


async function openFancyBox(e) {
    e.preventDefault()
    const parentEl     = e.target.closest('.open-fancybox');
    const formTemplate = parentEl.dataset.form;
    const transferData = parentEl.dataset.transfer;
    await openFancyboxForm(formTemplate, transferData)
}

/**
 * Универсальная функция открытия модального окна через fancybox.
 * Используется как обработчиком .open-fancybox, так и динамическими компонентами.
 *
 * @param {string} formTemplate — название blade-шаблона (например 'consult_me')
 * @param {string|null} transferData — JSON-строка с дополнительными данными для шаблона
 */
export async function openFancyboxForm(formTemplate, transferData = null) {
    try {
        const template = { template: formTemplate, author: '@AxeldMaster', data: transferData };

        const response = await fetch('/fancybox-ajax', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrf,
            },
            body: JSON.stringify(template),
        });

        if (!response.ok) {
            console.error(`Error: ${response.status}`);
        }

        const data = await response.text();

        Fancybox.show([{ html: data }], {
            dragToClose: false,
            closeButton: true,
            backdropClick: 'close',
            touch: false,
        });

        asyncExecution();
        scrollCabinetMessages();

    } catch (err) {
        console.error('Ошибка AJAX:', err.message);
        alert('Ошибка при получении данных');
    }
}
