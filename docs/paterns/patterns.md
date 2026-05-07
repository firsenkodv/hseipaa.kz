# Паттерны проекта

---

## 1. Laravel Page Pattern — от модели до вывода

Полный цикл создания страницы с выводом данных из БД и настроек админки. Пример — страница новостей `/poleznoe/novosti`.

### Структура директорий

```
src/Domain/{Section}/ViewModels/{Model}ViewModel.php
app/Http/Controllers/Pages/{Section}Controller.php
app/Enums/Pages/PageTemplate.php
app/Enums/ContentTemplate.php
resources/views/pages/{section}/{method}.blade.php
resources/views/pages/common/templates/{template}.blade.php
resources/views/templates/common/{template}.blade.php
resources/views/components/seo/meta-paginated.blade.php
routes/web.php
routes/breadcrumbs.php
```

---

### Именование маршрутов

URL-адреса — транслитерация (уже проиндексированы, не менять).
Имена маршрутов — только английские слова.

```php
// routes/web.php
Route::get('/poleznoe/novosti', 'news')->name('resources.news');
Route::get('/poleznoe/novosti/{slug}', 'newsShow')->name('resources.news.show');
```

| URL | Имя маршрута |
|-----|-------------|
| `/onas` | `about` |
| `/onas/team` | `about.team` |
| `/onas/partnjory` | `about.partners` |
| `/onas/dokumenty` | `about.documents` |
| `/obuchenie` | `training` |
| `/konsalting` | `consulting` |
| `/distantcionno` | `remote` |
| `/poleznoe` | `resources` |
| `/poleznoe/zakony` | `resources.laws` |
| `/poleznoe/novosti` | `resources.news` |
| `/poleznoe/novosti/{slug}` | `resources.news.show` |
| `/poleznoe/vazhnoe` | `resources.important` |
| `/poleznoe/diplomy` | `resources.diplomas` |
| `/poleznoe/seminar` | `resources.seminar` |

---

### Шаг 1 — Модель: scopePublished

`app/Models/News.php`

```php
use Illuminate\Database\Eloquent\Builder;

public function scopePublished(Builder $query): Builder
{
    return $query->where('published', 1)->orderBy('sorting');
}
```

> Вызов в коде: `News::published()->...` — Laravel сам находит `scopePublished` через соглашение `scopeXxx`.

---

### Шаг 2 — ViewModel

`src/Domain/News/ViewModels/NewsViewModel.php`

```php
namespace Domain\News\ViewModels;

use App\Models\News;
use App\Models\Setting;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Fluent;
use Support\Traits\Makeable;

class NewsViewModel
{
    use Makeable;

    // Данные страницы из админки (MoonShine Settings)
    public function getPageData(): Fluent
    {
        return new Fluent(Setting::getGroup('poleznoe_novosti')->data ?? []);
    }

    // Список записей с пагинацией
    public function getPublished(): LengthAwarePaginator
    {
        return News::published()->paginate(config('site.constants.paginate'));
    }

    // Одна запись по slug для детальной страницы
    public function getBySlug(string $slug): News
    {
        return News::published()->where('slug', $slug)->firstOrFail();
    }
}
```

**Правила:**
- Все запросы к БД — только в ViewModel, никогда в контроллере
- `Makeable` — трейт, добавляет `::make()` вместо `new`
- `Fluent` — доступ через `$page->title`; несуществующий ключ возвращает `null`, не бросает ошибку
- `getPublished()` возвращает `LengthAwarePaginator`, не `Collection` — не ставить `?` перед типом
- Количество записей на странице: `config('site.constants.paginate')`

---

### Шаг 3 — Контроллер (список)

`app/Http/Controllers/Pages/ResourcesController.php`

```php
public function news(): View
{
    $vm    = NewsViewModel::make();
    $items = $vm->getPublished();
    $page  = $vm->getPageData();

    return view('pages.resources.news', [
        'page'       => $page,
        'items'      => $items,
        'pageSuffix' => $this->pageSuffix($items),
        'template'   => PageTemplate::from($page->page_template ?? PageTemplate::Width->value),
        'section'    => 'resources.news',
        'route'      => 'resources.news.show',
    ]);
}
```

> `$items` сохраняется в переменную и передаётся — иначе `getPublished()` вызовется дважды и будет два запроса к БД.

> `section` и `route` передаются из контроллера — вьюха ничего не знает о конкретной модели и маршруте. Это делает все вьюхи списков идентичными.

> Для моделей без детальной страницы: `'route' => null`.

---

### Шаг 3б — Контроллер (детальная страница)

```php
public function newsShow(string $slug): View
{
    $vm   = NewsViewModel::make();
    $item = $vm->getBySlug($slug);
    $page = $vm->getPageData();

    return view('pages.resources.news-show', [
        'page' => $page,
        'item' => $item,
    ]);
}
```

---

### Шаг 4 — SEO-компонент с пагинацией

`resources/views/components/seo/meta-paginated.blade.php`

```blade
@props(['page', 'items'])
@php
    $currentPage     = $items->currentPage();
    $suffix          = $currentPage > 1 ? ' — Страница ' . $currentPage : '';
    $baseTitle       = $page->metatitle ?: $page->title ?: '';
    $baseDescription = $page->description ?: '';
    $baseKeywords    = $page->keywords ?: '';
@endphp
<x-seo.meta
    title="{{ $baseTitle ? $baseTitle . $suffix : '' }}"
    description="{{ $baseDescription ? $baseDescription . $suffix : '' }}"
    keywords="{{ $baseKeywords ? $baseKeywords . $suffix : '' }}"
/>
```

**Правила:**
- Суффикс `— Страница N` добавляется только если есть базовое значение
- Если поле пустое — передаётся `''`, тогда `x-seo.meta` подставляет дефолт из конфига
- `metatitle` имеет приоритет над `title` для SEO

---

### Шаг 4б — Enum шаблонов вывода (PageTemplate)

`app/Enums/Pages/PageTemplate.php`

```php
enum PageTemplate: string
{
    case Width  = 'width';
    case Column = 'column';

    public function label(): string
    {
        return match($this) {
            self::Width  => 'Во всю ширину',
            self::Column => 'Колонками',
        };
    }

    public function view(string $section): string
    {
        $specific = "pages.{$section}.templates.{$this->value}";
        $common   = "pages.common.templates.{$this->value}";

        if (view()->exists($specific)) return $specific;
        if (view()->exists($common))   return $common;

        return "pages.common.templates." . self::Width->value;
    }

    public static function toOptions(): array
    {
        return array_column(
            array_map(fn(self $case) => ['value' => $case->value, 'label' => $case->label()], self::cases()),
            'label',
            'value'
        );
    }
}
```

**Как работает `view(string $section)`:**

Аргумент `$section` — это адрес для поиска секционного переопределения. Метод ищет шаблон в трёх местах по приоритету:

1. Специфичный для секции: `pages/{section}/templates/{value}.blade.php`
2. Общий: `pages/common/templates/{value}.blade.php`
3. Дефолт: `pages/common/templates/width.blade.php`

Секционный шаблон создаётся только если нужен особый вид именно для этого раздела. В остальных случаях автоматически используется общий.

**Структура файлов:**
```
pages/
    common/
        templates/
            width.blade.php    ← общий для всех моделей (с поддержкой $route)
            column.blade.php   ← общий для всех моделей
```

> Добавить новый шаблон = создать файл в `common/templates/` + добавить `case` в Enum. Вьюха не меняется никогда.

---

### Шаг 4в — Общий шаблон списка (width)

`resources/views/pages/common/templates/width.blade.php`

```blade
<ul>

    @foreach($items as $item)
        <li>
            @isset($route)
                <a href="{{ route($route, $item->slug) }}">{{ $item->title }}</a>
            @else
                {{ $item->title }}
            @endisset
        </li>
    @endforeach

</ul>
```

**Правила:**
- `$route` — опциональная переменная, передаётся из контроллера через вьюху
- Если `$route` не передан (модель без детальной страницы) — выводится просто текст
- Благодаря этому один файл шаблона покрывает все модели

---

### Шаг 4г — Шаблон детальной страницы

`resources/views/templates/common/default.blade.php`

```blade
@if($item->img)
    <div class="item-img">
        <img src="{{ Storage::url($item->img) }}" alt="{{ $item->title }}">
    </div>
@endif

@if($item->short_desc)
    <div class="short-desc">{!! $item->short_desc !!}</div>
@endif

@if($item->desc)
    <div class="desc">{!! $item->desc !!}</div>
@endif
```

Используется через `ContentTemplate` enum (не `PageTemplate`). Разрешение шаблона: `$item->template->view('news')` — ищет `templates.news.default`, при отсутствии — `templates.common.default`.

---

### Шаг 5 — Вьюха списка

`resources/views/pages/resources/news.blade.php`

```blade
@extends('layouts.layout')
<x-seo.meta-paginated :page="$page" :items="$items" />
@section('content')

    <div class="content_page">
        <div class="block">

            <div class="block_content__breadcrumbs">{{ Breadcrumbs::render(Route::currentRouteName()) }}</div>

            @if($page->title)
                <h1 class="h1">{{ $page->title }}</h1>
            @endif

            @include($template->view($section), ['items' => $items, 'route' => $route])

            {{ $items->withQueryString()->links('pagination::default') }}

            @if($items->currentPage() === 1)
                @if($page->desc)
                    <div class="desc">{!! $page->desc !!}</div>
                @endif
            @endif

        </div>
    </div>

@endsection
```

**Правила:**
- Хлебные крошки: `Route::currentRouteName()` — имя маршрута определяется автоматически, строка не хардкодится
- H1 и описание страницы — только на первой странице (`currentPage() === 1`)
- SEO-мета — на всех страницах, с суффиксом начиная со второй
- `withQueryString()` — сохраняет GET-параметры при переключении страниц
- Пагинацию роботы индексируют — `noindex` не ставить
- `$section` и `$route` приходят из контроллера — вьюха универсальна для всех моделей

---

### Шаг 5б — Вьюха детальной страницы

`resources/views/pages/resources/news-show.blade.php`

```blade
@extends('layouts.layout')
<x-seo.meta
    title="{{ $item->metatitle ?: $item->title }}"
    description="{{ $item->description }}"
    keywords="{{ $item->keywords }}"
/>
@section('content')

    <div class="content_page">
        <div class="block">

            <div class="block_content__breadcrumbs">{{ Breadcrumbs::render(Route::currentRouteName(), $item) }}</div>

            @if($item->title)
                <h1 class="h1">{{ $item->title }}</h1>
            @endif

            @include($item->template->view('news'), ['item' => $item])

        </div>
    </div>

@endsection
```

**Правила:**
- SEO использует поля самой записи (`$item->metatitle`, `$item->description`, `$item->keywords`)
- `metatitle` имеет приоритет над `title`
- Хлебные крошки получают `$item` вторым аргументом — для вывода названия записи в цепочке
- Шаблон тела: `$item->template->view('news')` — определяется из поля `template` модели

---

### Шаг 6 — Хлебные крошки

`routes/breadcrumbs.php`

```php
use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная', route('home'));
});

Breadcrumbs::for('resources.news', function ($trail) {
    $trail->parent('home');
    $trail->push('Новости', route('resources.news'));
});

Breadcrumbs::for('resources.news.show', function ($trail, $item) {
    $trail->parent('resources.news');
    $trail->push($item->title, route('resources.news.show', $item->slug));
});
```

**Правила:**
- Имя для `Breadcrumbs::for(...)` совпадает с именем маршрута в `web.php`
- В вьюхе: `Breadcrumbs::render(Route::currentRouteName())` — имя берётся из текущего маршрута автоматически
- Для детальной страницы `$item` передаётся вторым аргументом: `Breadcrumbs::render(Route::currentRouteName(), $item)`
- Цепочка строится через `$trail->parent(...)` — каждый уровень ссылается на родителя
