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
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Text;

class CreditPage extends Page
{
    public function getTitle(): string
    {
        return 'Кредитный калькулятор';
    }

    private function getSetting(): Setting
    {
        return Setting::getGroup('calculator');
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
                    Tabs::make([

                        Tab::make('Калькулятор', [
                            Divider::make('Банки и коэффициенты'),
                            Json::make('Банки', 'banks')
                                ->fields([
                                    Text::make('Название банка', 'title'),
                                    Number::make('Ставка (%)', 'procent')->default(1)->min(0)->step(0.01),
                                    Text::make('Коэфф. 3 мес.', 'koff_3'),
                                    Text::make('Коэфф. 6 мес.', 'koff_6'),
                                    Text::make('Коэфф. 12 мес.', 'koff_12'),
                                    Text::make('Коэфф. 18 мес.', 'koff_18'),
                                    Text::make('Коэфф. 24 мес.', 'koff_24'),
                                ])
                                ->creatable()
                                ->removable(),

                            Divider::make('Курсы'),
                            Json::make('Курсы', 'courses')
                                ->fields([
                                    Text::make('Название курса', 'title'),
                                    Number::make('Цена (₸)', 'price')->min(0)->step(1),
                                ])
                                ->creatable()
                                ->removable(),

                            Divider::make('Сроки кредита'),
                            Json::make('Сроки', 'terms')
                                ->fields([
                                    Text::make('Месяцев', 'months')->hint('Числовое значение: 3, 6, 12...'),
                                    Text::make('Подпись', 'label')->hint('Например: 3 месяца'),
                                ])
                                ->creatable()
                                ->removable(),
                        ])->icon('calculator'),

                    ]),
                ]),
            ])
            ->submit('Сохранить', ['class' => 'btn-primary']);
    }

    protected function components(): iterable
    {
        yield $this->form();
    }
}
