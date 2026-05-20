<div class="modal-form-container mini app_form_modal">
    <div class="modal_padding">

        <x-form.form-loader/>
        <x-form.form-response />

        <div class="app_form_data">
            <div class="app_modal modal_content">

                <x-form.title
                    title="Получить консультацию"
                    sub="Оставьте заявку — мы свяжемся с вами в ближайшее время"
                />

                <div style="padding: 20px 0 0;">

                    <x-form.input name="Имя" label="Имя" required />
                    <x-form.input name="Телефон" label="Телефон" type="tel" required />
                    <x-form.input name="Email" label="Email" type="email" required />

                    <div class="input-button">
                        <button class="btn btn-big app_form_button" data-url="consult-me">Отправить</button>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
