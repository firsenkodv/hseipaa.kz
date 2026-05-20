// Bidirectional clearing
document.addEventListener('change', function (e) {
    var el = e.target;
    if (!el.name) return;

    if (el.type === 'date' && /\[date\]$/.test(el.name) && el.value) {
        var prefix = el.name.replace('[date]', '');

        var monthsEl = document.querySelector('[name^="' + prefix + '[months]"]');
        if (monthsEl && monthsEl.tomselect) monthsEl.tomselect.clear();

        var dateTypeEl = document.querySelector('[name="' + prefix + '[date_type]"]');
        if (dateTypeEl && dateTypeEl.tomselect) dateTypeEl.tomselect.clear();
        return;
    }

    if (/\[months\]/.test(el.name)) {
        var hasMonths = Array.from(el.options || []).some(function (o) { return o.selected; });
        if (!hasMonths) return;
        var prefix = el.name.replace(/\[months\].*/, '');
        var dateEl = document.querySelector('input[type="date"][name="' + prefix + '[date]"]');
        if (dateEl) dateEl.value = '';
        return;
    }

    if (/\[date_type\]$/.test(el.name) && el.value) {
        var prefix = el.name.replace('[date_type]', '');
        var dateEl = document.querySelector('input[type="date"][name="' + prefix + '[date]"]');
        if (dateEl) dateEl.value = '';
    }
});

// Client-side validation before save
document.addEventListener('click', function (e) {
    var btn = e.target.closest('button[type="submit"]');
    if (!btn) return;

    var form = btn.closest('form');
    if (!form) return;

    var dateInputs = form.querySelectorAll('input[type="date"][name*="[courses]"][name$="[date]"], input[type="date"][name*="courses"][name$="[date]"]');

    var errors = [];
    dateInputs.forEach(function (dateEl) {
        var prefix = dateEl.name.replace('[date]', '');
        var monthsEl = form.querySelector('[name^="' + prefix + '[months]"]');
        var hasDate = dateEl.value !== '';
        var hasMonths = monthsEl
            ? Array.from(monthsEl.options || []).some(function (o) { return o.selected; })
            : false;

        if (!hasDate && !hasMonths) {
            var index = (prefix.match(/\[(\d+)\]$/) || [])[1];
            errors.push('Строка ' + (parseInt(index, 10) + 1) + ': заполните «Месяцы» или «Дата начала».');
        }
    });

    if (errors.length > 0) {
        e.preventDefault();
        e.stopImmediatePropagation();
        alert(errors.join('\n'));
    }
});
