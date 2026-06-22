<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Pages;

use App\Models\Setting;
use Illuminate\Http\Request;
use MoonShine\Crud\JsonResponse;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Support\Attributes\AsyncMethod;
use MoonShine\Support\Enums\ToastType;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class ToastPage extends Page
{
    public function getTitle(): string
    {
        return 'Toast';
    }

    private function getSetting(): Setting
    {
        return Setting::getGroup('toast');
    }

    #[AsyncMethod]
    public function store(Request $request): JsonResponse
    {
        $setting = $this->getSetting();
        $setting->data = $request->except(['_token', '_method']);
        $setting->save();

        return JsonResponse::make()->toast('Сохранено', ToastType::SUCCESS);
    }

    private function form(): FormBuilder
    {
        return FormBuilder::make()
            ->asyncMethod('store')
            ->fill($this->getSetting()->data ?? [])
            ->fields([
                Box::make([
                    Divider::make('Toast-уведомление'),

                    Switcher::make('Показывать уведомление', 'toast_enabled')
                        ->default(true),

                    Textarea::make('Текст', 'toast_text')
                        ->hint('Текст уведомления, допустимы HTML-теги')
                        ->unescape(),

                    Text::make('Ссылка', 'toast_link')
                        ->hint('URL для кнопки «Подробнее»')
                        ->nullable(),

                    Number::make('Скрывать на (дней)', 'toast_dismiss_days')
                        ->hint('0 — показывать всегда, 1–100 — не показывать указанное количество дней после закрытия')
                        ->min(0)
                        ->max(100)
                        ->default(3),
                ]),
            ])
            ->submit('Сохранить', ['class' => 'btn-primary']);
    }

    protected function components(): iterable
    {
        yield $this->form();
    }
}
