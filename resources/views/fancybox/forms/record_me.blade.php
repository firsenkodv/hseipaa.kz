<div class="modal-form-container app_form_modal">
    <div class="modal_padding">

        <x-form.form-loader />
        <x-form.form-response />

        <div class="app_form_data">
            <div class="app_modal modal_content">

                <x-form.title
                    title="Запись на курс"
                    sub="Оставьте заявку — мы свяжемся с вами и уточним детали"
                />

                {{-- Тип лица --}}
                <div class="radio2">
                    <div class="radio2-inputs">
                        <label>
                            <input type="radio" name="_person_type" value="physical" checked>
                            <span class="name">
                                <i>Физическое лицо</i>
                                <i>Физ. лицо</i>
                            </span>
                        </label>
                        <label>
                            <input type="radio" name="_person_type" value="legal">
                            <span class="name">
                                <i>Юридическое лицо</i>
                                <i>Юр. лицо</i>
                            </span>
                        </label>
                    </div>
                </div>
                <input type="hidden" class="app_input_name" name="Тип" value="Физическое лицо">

                {{-- Компания (только для юр. лица) --}}
                <div class="record-form__company display_none">
                    <x-form.input name="Компания" label="Компания" />
                </div>

                {{-- Основные поля: 2 колонки --}}
                <div class="record-form__grid">
                    <x-form.input name="ФИО"     label="ФИО"     required />
                    <x-form.input name="Телефон" label="Телефон" type="tel" required />
                    <x-form.input name="Email"   label="E-mail"  type="email" required />

                    <div class="mz-select" data-mz-select>
                        <label class="mz-select__label" for="record-city">Город</label>
                        <select id="record-city" class="app_input_name" name="Город">
                            <option value="" disabled selected>Выберите город</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->title }}">{{ $city->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Курс (полная ширина) --}}
                <div class="mz-select" data-mz-select>
                    <label class="mz-select__label" for="record-training">Курс обучения</label>
                    <select id="record-training" class="app_input_name" name="Курс">
                        <option value="" disabled selected>Выберите курс обучения</option>
                        @foreach($trainings as $training)
                            <option value="{{ $training->title }}">{{ $training->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="input-button">
                    <button class="btn btn-big app_form_button" data-url="record-me">
                        Записаться
                    </button>
                </div>

            </div>
        </div>

    </div>
</div>
