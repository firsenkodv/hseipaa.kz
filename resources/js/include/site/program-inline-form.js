import { axiosLaravel } from '../axios/axiosLaravel.js';

export function programInlineForm() {
    document.querySelectorAll('[data-inline-signup]').forEach((form) => {
        const feedback = form.querySelector('[data-inline-feedback]');
        const button   = form.querySelector('[data-program-button]');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (button) button.disabled = true;
            if (feedback) {
                feedback.textContent = '';
                feedback.className = 'program-inline-form__feedback';
            }

            const data = {
                'Имя':     (form.querySelector('[name="name"]')?.value  ?? '').trim(),
                'Телефон': (form.querySelector('[name="phone"]')?.value ?? '').trim(),
                'Email':   (form.querySelector('[name="email"]')?.value ?? '').trim(),
                'Страница': window.location.href,
            };

            const result = await axiosLaravel(data, '/program-enroll');

            if (button) button.disabled = false;

            if (result?.response === 'ok') {
                form.querySelectorAll('input').forEach((input) => {
                    input.disabled = true;
                });
                if (button) {
                    button.disabled = true;
                }
                if (feedback) {
                    feedback.textContent = 'Заявка принята! Мы свяжемся с вами.';
                    feedback.classList.add('is-success');
                }
            } else if (result?.errors) {
                const firstError = Object.values(result.errors)[0]?.[0];
                if (feedback) {
                    feedback.textContent = firstError ?? 'Ошибка. Проверьте данные.';
                    feedback.classList.add('is-error');
                }
            } else {
                if (feedback) {
                    feedback.textContent = 'Произошла ошибка. Попробуйте позже.';
                    feedback.classList.add('is-error');
                }
            }
        });
    });
}
