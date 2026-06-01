<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Pages;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MoonShine\Crud\JsonResponse;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Support\Attributes\AsyncMethod;
use MoonShine\Support\Enums\ToastType;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;

class PromoModalPage extends Page
{
    public function getTitle(): string
    {
        return 'Форма записи (автооткрытие)';
    }

    private function getSetting(): Setting
    {
        return Setting::getGroup('promo_modal');
    }

    #[AsyncMethod]
    public function store(Request $request): JsonResponse
    {
        $setting = $this->getSetting();

        // Exclude image field from request data — UploadedFile cannot be serialized to JSON
        $data = $request->except(['_token', '_method', 'promo_modal_image']);

        if ($request->hasFile('promo_modal_image')) {
            $old = $setting->data['promo_modal_image'] ?? null;
            if ($old) {
                Storage::disk('public')->delete($old);
            }
            $data['promo_modal_image'] = $request->file('promo_modal_image')
                ->store('pages/promo', 'public');
        } else {
            // Non-empty string = existing path sent back by MoonShine hidden input
            // Empty/null = image was removed by user
            $data['promo_modal_image'] = $request->input('promo_modal_image') ?: null;
        }

        $setting->data = $data;
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
                    Divider::make('Автооткрытие формы заявки'),

                    Switcher::make('Активно', 'promo_modal_enabled'),

                    Number::make('Задержка (сек.)', 'promo_modal_delay')
                        ->hint('Через сколько секунд открыть форму после загрузки страницы')
                        ->min(0)
                        ->max(60)
                        ->default(4),

                    Number::make('Скрывать на (дней)', 'promo_modal_dismiss_days')
                        ->hint('0 — показывать всегда, 1–100 — не показывать указанное количество дней после закрытия')
                        ->min(0)
                        ->max(100)
                        ->default(3),

                    Image::make('Изображение', 'promo_modal_image')
                        ->disk('public')
                        ->dir('pages/promo')
                        ->allowedExtensions(['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'])
                        ->removable(),
                ]),
            ])
            ->submit('Сохранить', ['class' => 'btn-primary']);
    }

    protected function components(): iterable
    {
        yield $this->form();
    }
}
