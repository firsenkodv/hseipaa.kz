@php
    $ccData = \App\Models\Setting::getGroup('calculator')->data ?? [];

    $ccBanks = collect($ccData['banks'] ?? [])
        ->mapWithKeys(fn($b, $i) => [
            'bank' . ($i + 1) => [
                'title'   => $b['title']   ?? '',
                'procent' => (int)($b['procent'] ?? 1),
                'koff'    => [
                    '3'  => (float)($b['koff_3']  ?? 0),
                    '6'  => (float)($b['koff_6']  ?? 0),
                    '12' => (float)($b['koff_12'] ?? 0),
                    '18' => (float)($b['koff_18'] ?? 0),
                    '24' => (float)($b['koff_24'] ?? 0),
                ],
            ],
        ])
        ->all();

    $ccCourses = collect($ccData['courses'] ?? [])
        ->map(fn($c) => [
            'title' => $c['title'] ?? '',
            'price' => (int)($c['price'] ?? 0),
        ])
        ->filter(fn($c) => $c['title'] && $c['price'] > 0)
        ->values()
        ->all();

    $ccTerms = collect($ccData['terms'] ?? [])
        ->pluck('label', 'months')
        ->all();

    $firstPrice = $ccCourses[0]['price'] ?? 0;
    $firstMonths = array_key_first($ccTerms) ?? 12;
@endphp

<div class="cc">
    <div class="cc__card">

        {{-- Шапка --}}
        <div class="cc__header">
            <h2 class="cc__title">Кредитный калькулятор</h2>
            <p class="cc__subtitle">Выберите параметры и рассчитайте ежемесячный платёж</p>
        </div>

        {{-- Форма --}}
        <div class="cc__body" id="ccForm">
            <div class="cc__grid">

                {{-- Банк --}}
                <div class="cc__field">
                    <label class="cc__label" for="cc-bank">Банк</label>
                    <div class="mz-select" data-mz-select>
                        <select id="cc-bank">
                            @foreach($ccBanks as $bankKey => $bank)
                                <option value="{{ $bankKey }}">{{ $bank['title'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Стоимость --}}
                <div class="cc__field">
                    <label class="cc__label">Стоимость обучения</label>
                    <div class="cc__cost">
                        <strong id="cc-cost">{{ number_format($firstPrice, 0, '.', ' ') }} ₸</strong>
                    </div>
                </div>

                {{-- Курс --}}
                <div class="cc__field cc__field--full">
                    <label class="cc__label" for="cc-course">Курс</label>
                    <div class="mz-select" data-mz-select>
                        <select id="cc-course">
                            @foreach($ccCourses as $course)
                                <option value="{{ $course['price'] }}">{{ $course['title'] }} — {{ number_format($course['price'], 0, '.', ' ') }} ₸</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Срок --}}
                <div class="cc__field cc__field--full">
                    <label class="cc__label">Срок кредита</label>
                    <div class="cc__terms">
                        @foreach($ccTerms as $months => $label)
                            <button type="button"
                                    class="cc__term-btn {{ $months == $firstMonths ? 'is-active' : '' }}"
                                    data-months="{{ $months }}">{{ $label }}</button>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        {{-- Кнопка --}}
        <div class="cc__footer" id="ccFooter">
            <button type="button" class="cc__btn" id="cc-calculate">Рассчитать</button>
        </div>

        {{-- Результаты --}}
        <div class="cc__results" id="ccResults" style="display:none">
            <div class="cc__results-head">
                <span class="cc__results-title">Результаты расчёта</span>
                <button type="button" class="cc__recalc" id="cc-recalc">← Пересчитать</button>
            </div>
            <div class="cc__result-list">
                <div class="cc__result-item">
                    <div class="cc__result-name">Ставка</div>
                    <div class="cc__result-val" id="cc-rate">—</div>
                </div>
                <div class="cc__result-item">
                    <div class="cc__result-name">Срок</div>
                    <div class="cc__result-val" id="cc-term">—</div>
                </div>
                <div class="cc__result-item cc__result-item--green">
                    <div class="cc__result-name">Ежемесячный платёж</div>
                    <div class="cc__result-val" id="cc-monthly">—</div>
                </div>
                <div class="cc__result-item cc__result-item--orange">
                    <div class="cc__result-name">Переплата</div>
                    <div class="cc__result-val" id="cc-overpay">—</div>
                </div>
                <div class="cc__result-item">
                    <div class="cc__result-name">Общая выплата</div>
                    <div class="cc__result-val" id="cc-total">—</div>
                </div>
            </div>

            {{-- Форма отправки результатов --}}
            <div class="cc__send-form">
                <div class="form_title" id="ccSendTitle">
                    <div class="form_title__h1">Результат</div>
                    <p class="form_title__sub cc__send-title">Отправить расчёт — мы свяжемся и ответим на вопросы</p>
                </div>
                <div class="relative" id="ccSendModal">
                    <x-form.form-loader />
                    <x-form.form-response />
                    <div class="app_form_data app_modal" id="ccSendData">

                        {{-- Скрытые поля с результатами расчёта --}}
                        <input type="hidden" class="app_input_name" name="Банк"               id="cc-hidden-bank">
                        <input type="hidden" class="app_input_name" name="Курс"               id="cc-hidden-course">
                        <input type="hidden" class="app_input_name" name="Сумма"              id="cc-hidden-cost">
                        <input type="hidden" class="app_input_name" name="Срок"               id="cc-hidden-term">
                        <input type="hidden" class="app_input_name" name="Ежемесячный платёж" id="cc-hidden-monthly">
                        <input type="hidden" class="app_input_name" name="Переплата"          id="cc-hidden-overpay">
                        <input type="hidden" class="app_input_name" name="Итого"              id="cc-hidden-total">

                        <div class="cc__send-fields">
                            <x-form.input name="ФИО"     label="Ваше имя"  required />
                            <x-form.input name="Телефон" label="Телефон"   type="tel" required />
                            <x-form.input name="Email"   label="Email"     type="email" required />
                        </div>

                        <button type="button" class="cc__btn" id="cc-send-btn">
                            Отправить заявку
                        </button>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
(function () {
    const banks = @json($ccBanks);
    const terms = @json($ccTerms);

    const fmt = (n) => new Intl.NumberFormat('ru-RU').format(Math.round(n)) + ' ₸';

    const bankSel   = document.getElementById('cc-bank');
    const courseSel = document.getElementById('cc-course');
    const costEl    = document.getElementById('cc-cost');
    const calcBtn   = document.getElementById('cc-calculate');
    const recalcBtn = document.getElementById('cc-recalc');
    const formEl    = document.getElementById('ccForm');
    const footerEl  = document.getElementById('ccFooter');
    const resultsEl = document.getElementById('ccResults');
    const termBtns  = document.querySelectorAll('.cc__term-btn');

    let activeMonths = {{ $firstMonths }};

    termBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            termBtns.forEach(b => b.classList.remove('is-active'));
            btn.classList.add('is-active');
            activeMonths = parseInt(btn.dataset.months, 10);
        });
    });

    courseSel.addEventListener('change', () => {
        costEl.textContent = new Intl.NumberFormat('ru-RU').format(parseInt(courseSel.value, 10)) + ' ₸';
    });

    calcBtn.addEventListener('click', () => {
        const bank    = banks[bankSel.value];
        const price   = parseInt(courseSel.value, 10);
        const koff    = bank.koff[String(activeMonths)];
        const monthly = price * koff;
        const total   = monthly * activeMonths;
        const overpay = total - price;

        const termLabel = terms[String(activeMonths)];

        document.getElementById('cc-rate').textContent    = bank.procent + '%';
        document.getElementById('cc-term').textContent    = termLabel;
        document.getElementById('cc-monthly').textContent = fmt(monthly);
        document.getElementById('cc-overpay').textContent = fmt(overpay);
        document.getElementById('cc-total').textContent   = fmt(total);

        document.getElementById('cc-hidden-bank').value    = bank.title || bankSel.options[bankSel.selectedIndex].text;
        document.getElementById('cc-hidden-course').value  = courseSel.options[courseSel.selectedIndex].text;
        document.getElementById('cc-hidden-cost').value    = fmt(price);
        document.getElementById('cc-hidden-term').value    = termLabel;
        document.getElementById('cc-hidden-monthly').value = fmt(monthly);
        document.getElementById('cc-hidden-overpay').value = fmt(overpay);
        document.getElementById('cc-hidden-total').value   = fmt(total);

        formEl.style.display    = 'none';
        footerEl.style.display  = 'none';
        resultsEl.style.display = 'block';
    });

    recalcBtn.addEventListener('click', () => {
        formEl.style.display    = 'block';
        footerEl.style.display  = 'block';
        resultsEl.style.display = 'none';
    });

    // Отправка формы с результатами расчёта
    const csrf      = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
    const sendModal = document.getElementById('ccSendModal');
    const sendBtn   = document.getElementById('cc-send-btn');
    const ccLoader  = sendModal.querySelector('.app_loader');
    const ccResp    = sendModal.querySelector('.app_form_response');
    const ccData    = document.getElementById('ccSendData');

    sendBtn.addEventListener('click', async () => {
        const inputs = Array.from(sendModal.querySelectorAll('.app_form_data .app_input_name'));
        const data   = {};
        inputs.forEach(input => { data[input.name] = input.value; });

        ccLoader.classList.add('active');

        try {
            const res  = await fetch('/credit-calc', {
                method:  'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept':       'application/json',
                    'X-CSRF-Token': csrf,
                },
                body: JSON.stringify(data),
            });

            const json = await res.json();
            ccLoader.classList.remove('active');

            if (json.errors) {
                const groups = Array.from(sendModal.querySelectorAll('.app_input_group'));
                groups.forEach(group => {
                    const input  = group.querySelector('.app_input_name');
                    const errDiv = group.querySelector('.app_input_error');
                    if (input && json.errors[input.name]) {
                        input.classList.add('_error');
                        errDiv.textContent = json.errors[input.name][0];
                    } else if (input) {
                        input.classList.remove('_error');
                        errDiv.textContent = '';
                    }
                });
            } else {
                ccResp.classList.add('active');
                ccData.remove();
                document.getElementById('ccSendTitle').remove();
            }
        } catch (e) {
            ccLoader.classList.remove('active');
        }
    });
})();
</script>
