<div class="modal-form-container mini app_form_modal">
    <div class="modal_padding">

        <x-form.form-loader/>
        <x-form.form-response />

        <div class="app_form_data">
            <div class="app_modal modal_content">

                <x-form.title
                    title="Записаться на курс"
                    sub="Оставьте заявку — мы свяжемся с вами в ближайшее время"
                />

                @if(!empty($course))
                <div class="schedule-enroll-meta">
                    <div class="schedule-enroll-meta__item">
                        <span>Курс</span>
                        <strong>{{ $course }}</strong>
                    </div>
                    @if(!empty($price))
                    <div class="schedule-enroll-meta__item">
                        <span>Стоимость</span>
                        <strong>{{ $price }}</strong>
                    </div>
                    @endif
                    @if(!empty($date))
                    <div class="schedule-enroll-meta__item">
                        <span>Дата</span>
                        <strong>{{ $date }}</strong>
                    </div>
                    @endif
                </div>
                @endif

                {{-- Скрытые поля для передачи данных о курсе в письме --}}
                @if(!empty($course))
                    <input type="hidden" name="Курс" value="{{ $course }}" class="app_input_name">
                @endif
                @if(!empty($price))
                    <input type="hidden" name="Стоимость" value="{{ $price }}" class="app_input_name">
                @endif
                @if(!empty($date))
                    <input type="hidden" name="Дата" value="{{ $date }}" class="app_input_name">
                @endif

                <div style="padding: 20px 0 0;">

                    <x-form.input name="Имя" label="Имя" required />
                    <x-form.input name="Телефон" label="Телефон" type="tel" required />
                    <x-form.input name="Email" label="Email" type="email" required />

                    <div class="input-button">
                        <button class="btn btn-big app_form_button" data-url="schedule-enroll">Отправить</button>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
