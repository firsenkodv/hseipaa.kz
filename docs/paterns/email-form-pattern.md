# Паттерн отправки e-mail через форму

---

## 2. Email Form Pattern — от формы до письма

Полный цикл отправки e-mail через форму на сайте. Два варианта: простая inline-форма на странице и форма в модальном окне Fancybox. Backend-инфраструктура — одинакова для обоих вариантов.

### Структура файлов

```
app/Http/Requests/{FormName}Request.php          ← валидация полей
app/Jobs/Form/{FormName}Job.php                  ← очередь, сбор получателей
app/Mail/Form/{FormName}Mail.php                 ← Mailable, тема письма
resources/views/html/email/{form_name}.blade.php ← шаблон письма
resources/views/html/email/layouts/layout_default_mail.blade.php ← базовый layout письма

── Простая форма ──
resources/views/axios/forms/{form_name}.blade.php  ← шаблон формы (загружается по AJAX)
app/Http/Controllers/Axios/AxiosController.php     ← метод обработки

── Модальная форма ──
resources/views/fancybox/forms/{form_name}.blade.php ← шаблон формы в модальном окне
app/Http/Controllers/FancyBox/FancyBoxController.php ← регистрация шаблона
app/Http/Controllers/Axios/AxiosController.php       ← метод обработки

── Общий трейт ──
src/Support/Traits/EmailAddressCollector.php         ← сбор e-mail получателей
```

---

## Вариант A — Простая форма (inline)

Пример: форма «Оставьте заявку» на главной странице (`call_me_blue`).

---

### Шаг 1 — Маршрут

`routes/web.php`

```php
Route::controller(AxiosController::class)->group(function () {
    Route::post('/upload-form-async', 'async');       // загрузка шаблона формы
    Route::post('/call-me-blue', 'callMeBlue');       // отправка формы
});
```

---

### Шаг 2 — Загрузка шаблона формы по AJAX

`app/Http/Controllers/Axios/AxiosController.php`

```php
public function async(Request $request)
{
    if ($request->template === 'call_me_blue') {
        return view('axios.forms.call_me_blue');
    }

    return view('axios.forms.error.error_form');
}
```

> Шаблон формы загружается через `POST /upload-form-async` с телом `{template: 'call_me_blue'}`.
> Контейнер формы: `<div class="axios__uploading_form" data-form="call_me_blue">`.

---

### Шаг 3 — Шаблон формы

`resources/views/axios/forms/call_me_blue.blade.php`

```blade
<div class="form_form-blue-component block">
    <section class="form_blue__padding">
        <div class="relative app_form_modal">
            <x-form.form-loader/>
            <x-form.form-response />
            <div class="app_form_data">
                <div class="background_575EEF app_modal">
                    <h4>Оставьте заявку</h4>
                    <div class="form_blue">
                        <div class="form_blue__flex">
                            <x-form.input name="Телефон" label="Телефон" type="tel" required />
                            <x-form.input name="ФИО" label="ФИО" required />
                            <x-form.input name="Email" label="Email" type="email" required />
                            <div class="input-group input-button">
                                <button class="btn btn-big app_form_button" data-url="call-me-blue">Отправить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
```

**Правила:**
- `app_form_modal` — корневой контейнер, относительно него позиционируется лоадер
- `app_form_data` — область данных формы; скрывается после успешной отправки
- `app_modal` — удаляется через `modal.remove()` при успехе
- `app_input_name` — класс JS-хук на каждом `<input>`; `name` — ключ в объекте данных
- `app_form_button[data-url]` — кнопка отправки; `data-url` = часть пути (`call-me-blue` → `/call-me-blue`)
- `<x-form.input>` — анонимный компонент: `name`, `label`, `type`, `required`

---

### Шаг 4 — FormRequest

`app/Http/Requests/CallMeBlueRequest.php`

```php
class CallMeBlueRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'ФИО'     => ['required', 'string', 'min:2', 'max:100'],
            'Телефон' => ['required', 'string', 'min:6', 'max:30'],
            'Email'   => ['required', 'email', 'min:4', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'ФИО.required'     => 'Необходимо ввести ФИО.',
            'Телефон.required' => 'Необходимо ввести номер телефона.',
            'Email.required'   => 'Электронная почта обязательна.',
            'Email.email'      => 'Введите корректный email.',
            // ...
        ];
    }
}
```

> При ошибке валидации Laravel возвращает **422** с JSON `{errors: {...}}`.
> JS (`fieldErrors.js`) находит `.app_input_group` по `name` и пишет текст в `.app_input_error`.
> Ошибка позиционируется абсолютно — форма не растягивается.

---

### Шаг 5 — Метод контроллера

`app/Http/Controllers/Axios/AxiosController.php`

```php
public function callMeBlue(CallMeBlueRequest $request)
{
    $data = [
        'ФИО'     => $request->input('ФИО'),
        'Телефон' => $request->input('Телефон'),
        'Email'   => $request->input('Email'),
    ];

    CallMeBlueJob::dispatch($data);

    return response()->json(['response' => 'ok']);
}
```

> Ключи `$data` — русские слова; они используются в письме как заголовки столбцов.

---

### Шаг 6 — Job

`app/Jobs/Form/CallMeBlueJob.php`

```php
class CallMeBlueJob implements ShouldQueue
{
    use Queueable;
    use EmailAddressCollector;

    public function __construct(public array $data) {}

    public function handle(): void
    {
        $recipients = $this->emails();
        if (empty($recipients)) return;

        Mail::to($recipients)->send(new CallMeBlueMail($this->data));
    }
}
```

> `EmailAddressCollector::emails()` собирает получателей из двух источников:
> 1. `MAIL_ADMIN` из `.env` (или `mail.from.address` как fallback)
> 2. Список e-mail из AdminPanel: `Setting::getGroup('social')->data['emails']`

---

### Шаг 7 — Mailable

`app/Mail/Form/CallMeBlueMail.php`

```php
class CallMeBlueMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $data) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Заявка с сайта — оставьте заявку');
    }

    public function content(): Content
    {
        return new Content(view: 'html.email.call_me_blue');
    }
}
```

---

### Шаг 8 — Шаблон письма

`resources/views/html/email/call_me_blue.blade.php`

```blade
@extends('html.email.layouts.layout_default_mail')

@section('title', 'Новая заявка с сайта')
@section('description', 'Пользователь оставил заявку на обратный звонок.')

@section('content')
    @foreach($data as $label => $value)
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
            <tr>
                <td style="width:110px; padding:8px 12px 8px 0; vertical-align:top;">
                    <span style="font-size:12px; color:#888888; font-weight:600; text-transform:uppercase;">{{ $label }}</span>
                </td>
                <td style="padding:8px 0; vertical-align:top; border-bottom:1px solid #eaecf0;">
                    <span style="font-size:15px; color:#282828; font-weight:500;">{{ $value }}</span>
                </td>
            </tr>
        </table>
    @endforeach
@endsection
```

> Данные из `$data` итерируются — ключ становится лейблом, значение — содержимым.
> Базовый layout подключает логотип, цветной разделитель, заголовок и тело письма.

---

## Вариант B — Форма в модальном окне Fancybox

Пример: форма «Получить консультацию» (`consult_me`), открывается из кнопки на странице `/onas`.

---

### Шаг 1 — Кнопка-триггер

```blade
<a href="#" class="btn open-fancybox" data-form="consult_me">Получить консультацию</a>
```

**Правила:**
- Класс `open-fancybox` — JS-хук, вешает обработчик клика
- `data-form="consult_me"` — имя шаблона, запрашиваемого у сервера

---

### Шаг 2 — Регистрация шаблона в FancyBoxController

`app/Http/Controllers/FancyBox/FancyBoxController.php`

```php
public function fancybox(Request $request)
{
    if ($request->template === 'consult_me') {
        return view('fancybox.forms.consult_me');
    }

    return view('fancybox.forms.error.error_form');
}
```

> При клике JS делает `POST /fancybox-ajax` с `{template: 'consult_me'}` и получает HTML формы.
> Затем Fancybox открывает модальное окно с этим HTML через `Fancybox.show([{html: data}])`.

---

### Шаг 3 — Шаблон формы в модальном окне

`resources/views/fancybox/forms/consult_me.blade.php`

```blade
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
```

**Правила:**
- `modal-form-container` — ширина модального окна; `mini` = 600px, без модификатора = 900px
- `modal_padding` — обёртка **без** паддинга; паддинг перенесён на `modal_content`
- `<x-form.form-loader/>` и `<x-form.form-response/>` — вне `modal_content`, прямо в `modal_padding`, иначе лоадер будет смещён паддингом
- `touch: false` в опциях Fancybox — разрешает выделение текста мышью в модальном окне

---

### Шаги 4–8 — Backend (идентично Варианту A)

| Файл | Аналог из Варианта A |
|------|----------------------|
| `app/Http/Requests/ConsultMeRequest.php` | `CallMeBlueRequest.php` |
| `app/Http/Controllers/Axios/AxiosController::consultMe()` | `callMeBlue()` |
| `app/Jobs/Form/ConsultMeJob.php` | `CallMeBlueJob.php` |
| `app/Mail/Form/ConsultMeMail.php` | `CallMeBlueMail.php` |
| `resources/views/html/email/consult_me.blade.php` | `call_me_blue.blade.php` |

Маршрут:
```php
Route::post('/consult-me', 'consultMe');
```

---

## Трейт EmailAddressCollector

`src/Support/Traits/EmailAddressCollector.php`

```php
namespace Support\Traits;

use App\Models\Setting;

trait EmailAddressCollector
{
    public function emails(): array
    {
        $emails = [];

        $mailAdmin = env('MAIL_ADMIN', config('mail.from.address'));
        if ($mailAdmin) {
            $emails[] = $mailAdmin;
        }

        $extra = Setting::getGroup('social')->data['emails'] ?? [];
        foreach ($extra as $row) {
            if (!empty($row['email'])) {
                $emails[] = trim($row['email']);
            }
        }

        return array_values(array_unique(array_filter($emails)));
    }
}
```

**Правила:**
- Трейт подключается в Job через `use EmailAddressCollector`
- Адрес из `.env` (`MAIL_ADMIN`) — всегда первый
- Дополнительные адреса добавляются из вкладки «E-mail адреса» в MoonShine → Настройки → Соцсети
- `array_unique` + `array_filter` — дедупликация и удаление пустых значений
- Если список пуст — `handle()` завершается без отправки

---

## Итоговая схема потока данных

```
Клик по кнопке
  └─ [Простая форма]  data-form → POST /upload-form-async → axios.forms.{name}.blade.php
  └─ [Модальная форма] data-form → POST /fancybox-ajax   → fancybox.forms.{name}.blade.php
                                                              └─ Fancybox.show([{html}])

Ввод данных → asyncExecution() собирает .app_input_name поля
  └─ POST /{route} (data-url на кнопке)
       └─ FormRequest → 422 + errors → fieldErrors.js → .app_input_error
       └─ OK → Job::dispatch($data)
                 └─ EmailAddressCollector::emails()
                      ├─ MAIL_ADMIN (.env)
                      └─ Setting::getGroup('social')->data['emails'] (AdminPanel)
                 └─ Mail::to($recipients)->send(new {Name}Mail($data))
                      └─ html.email.{name}.blade.php
                           └─ @extends(html.email.layouts.layout_default_mail)
       └─ response json ok → loader off → form-response.active (Спасибо)
```
