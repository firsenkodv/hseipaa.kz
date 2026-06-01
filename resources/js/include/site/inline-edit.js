export function initInlineEdit() {
    if (!document.querySelector('[data-inline-edit]')) return;

    document.addEventListener('click', (e) => {
        // Открыть модалку
        const openBtn = e.target.closest('[data-open]');
        if (openBtn && openBtn.closest('[data-inline-edit]')) {
            const modal = document.getElementById(openBtn.dataset.open);
            if (modal) openModal(modal);
            return;
        }

        // Закрыть модалку
        const closeEl = e.target.closest('[data-close]');
        if (closeEl) {
            const modal = closeEl.closest('[data-inline-edit-modal]');
            if (modal) closeModal(modal);
            return;
        }

        // Сохранить
        const saveBtn = e.target.closest('[data-save]');
        if (saveBtn) {
            handleSave(saveBtn);
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const opened = document.querySelector('[data-inline-edit-modal].is-open');
            if (opened) closeModal(opened);
        }
    });
}

function openModal(modal) {
    modal.classList.add('is-open');
    document.body.style.overflow = 'hidden';
    // Фокус на textarea
    const ta = modal.querySelector('textarea');
    if (ta) setTimeout(() => ta.focus(), 50);
}

function closeModal(modal) {
    modal.classList.remove('is-open');
    document.body.style.overflow = '';
}

async function handleSave(btn) {
    const taId  = btn.dataset.ta;
    const ta    = document.getElementById(taId);
    if (!ta) return;

    const payload = {
        model: btn.dataset.model,
        id:    parseInt(btn.dataset.id, 10),
        field: btn.dataset.field,
        value: ta.value,
    };

    const originalText = btn.textContent;
    btn.disabled    = true;
    btn.textContent = 'Сохранение…';

    try {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

        const res  = await fetch('/admin-inline-edit', {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept':       'application/json',
            },
            body: JSON.stringify(payload),
        });

        const data = await res.json();

        if (res.ok && data.success) {
            btn.textContent = '✓ Сохранено';
            btn.style.background = '#1a8a50';

            setTimeout(() => {
                // Обновляем контент прямо в DOM без перезагрузки
                const modal   = document.getElementById(taId.replace(/-ta$/, ''));
                const uid     = taId.replace(/-ta$/, '');
                const content = document.querySelector(`[data-inline-edit-content="${uid}"]`);
                if (content) {
                    const target = content.firstElementChild ?? content;
                    target.innerHTML = ta.value;
                }
                if (modal) closeModal(modal);
                btn.disabled    = false;
                btn.textContent = 'Сохранить';
                btn.style.background = '';
            }, 1000);
        } else {
            alert(data.error ?? 'Ошибка при сохранении');
            btn.disabled    = false;
            btn.textContent = originalText;
            btn.style.background = '';
        }
    } catch {
        alert('Ошибка соединения');
        btn.disabled    = false;
        btn.textContent = originalText;
        btn.style.background = '';
    }
}
