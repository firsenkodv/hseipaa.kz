# Компонент инлайн-редактирования `<x-admin.inline-edit>`

Позволяет администратору редактировать HTML-поля прямо на фронтенде сайта, без входа в админ-панель.  
Видим только залогиненному пользователю MoonShine (`auth('moonshine')`).

---

## Файлы

| Файл | Назначение |
|------|-----------|
| `app/Http/Controllers/Admin/InlineEditController.php` | Backend: авторизация, whitelist, сохранение |
| `routes/web.php` | `POST /admin-inline-edit` |
| `resources/views/components/admin/inline-edit.blade.php` | Blade-компонент |
| `resources/css/components/admin/inline-edit.scss` | Стили |
| `resources/js/include/site/inline-edit.js` | Vanilla JS: модалка, fetch, обновление DOM |

---

## Подключение

### app.css
```css
@import 'components/admin/inline-edit.scss';
```

### script.js
```js
import { initInlineEdit } from "./include/site/inline-edit";

document.addEventListener('DOMContentLoaded', () => {
    initInlineEdit();
});
```

---

## Использование в шаблоне

```blade
<x-admin.inline-edit :model="$item" field="desc" label="Описание">
    <div class="content_page__desc desc">
        {!! $item->desc !!}
    </div>
</x-admin.inline-edit>
```

### Props

| Prop | Тип | Обязательный | Описание |
|------|-----|:---:|---------|
| `model` | Eloquent model | ✓ | Экземпляр модели (`:model="$item"`) |
| `field` | string | ✓ | Имя поля (`desc`, `html`, `desc2`, `html2`, `short_desc`) |
| `label` | string | — | Заголовок в модалке (по умолчанию — имя поля) |

---

## Поведение

1. Администратор наводит курсор на блок — в правом верхнем углу появляется кнопка-карандаш
2. Клик — открывается модальное окно с `<textarea>` в моноширинном шрифте (исходный HTML)
3. После редактирования → «Сохранить»
4. AJAX `POST /admin-inline-edit` сохраняет значение в БД
5. Через 1 секунду контент обновляется прямо в DOM без перезагрузки страницы

---

## Безопасность

- Проверка `auth('moonshine')->check()` на бэкенде — только администратор MoonShine
- Whitelist моделей в `InlineEditController::$modelMap` — нельзя передать произвольный класс
- Whitelist полей в `InlineEditController::$allowedFields` — нельзя записать в `password`, `slug` и т.д.

### Добавление новой модели

В `InlineEditController.php`:

```php
protected array $modelMap = [
    // ...
    'page' => \App\Models\Page::class,  // добавить сюда
];
```

### Добавление нового поля

```php
protected array $allowedFields = [
    'desc', 'html', 'desc2', 'html2', 'short_desc',
    'content',  // добавить сюда
];
```

---

## Адаптация для другого проекта

1. Заменить `auth('moonshine')` на нужный guard (`auth('admin')`, `auth()->user()->isAdmin()` и т.д.)
2. Заполнить `$modelMap` моделями проекта
3. Скорректировать `$allowedFields` под поля проекта
4. Подключить SCSS и JS в сборку
5. Обернуть нужные поля в шаблонах компонентом

---

## Зависимости

- Laravel 10+
- MoonShine v4 (или любой другой guard — см. «Адаптация»)
- Vanilla JS (без Alpine.js / Vue)
- SCSS (компилируется через Vite)
