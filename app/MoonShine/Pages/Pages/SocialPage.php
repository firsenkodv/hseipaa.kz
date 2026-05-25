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
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;

class SocialPage extends Page
{
    public function getTitle(): string
    {
        return 'Соцсети и константы';
    }

    private function getSetting(): Setting
    {
        return Setting::getGroup('social');
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
                        Tab::make('Соцсети', [
                            Divider::make('Ссылки на социальные сети'),
                            Text::make('Telegram', 'telegram')
                                ->hint('Полная ссылка, например: https://t.me/username')
                                ->nullable()
                                ->unescape(),
                            Text::make('WhatsApp', 'whatsapp')
                                ->hint('Полная ссылка, например: https://wa.me/77001234567')
                                ->nullable()
                                ->unescape(),
                            Text::make('Instagram', 'instagram')
                                ->hint('Полная ссылка, например: https://instagram.com/username')
                                ->nullable()
                                ->unescape(),
                            Text::make('Facebook', 'facebook')
                                ->hint('Полная ссылка, например: https://facebook.com/username')
                                ->nullable()
                                ->unescape(),
                            Text::make('YouTube (канал)', 'youtube_channel')
                                ->hint('Полная ссылка на канал, например: https://youtube.com/@channel')
                                ->nullable()
                                ->unescape(),
                        ])->icon('share'),

                        Tab::make('Константы', [
                            Divider::make('Контактные данные'),
                            Text::make('Телефон', 'phone')
                                ->hint('Формат для ссылки tel:, например: 77272242121')
                                ->nullable()
                                ->unescape(),
                            Text::make('Email', 'email')
                                ->hint('Например: sayhi@hseiipa.kz')
                                ->nullable()
                                ->unescape(),
                            Divider::make('Медиа'),
                            Text::make('ID видео YouTube (блок «Преимущества»)', 'youtube_video_id')
                                ->hint('Только ID видео, например: 9ofghOY94-4')
                                ->nullable()
                                ->unescape(),
                            Divider::make('Мобильные приложения'),
                            Text::make('Скачать в App Store', 'app_store')
                                ->hint('Ссылка на приложение в App Store')
                                ->nullable()
                                ->unescape(),
                            Text::make('Скачать в Google Play', 'google_play')
                                ->hint('Ссылка на приложение в Google Play')
                                ->nullable()
                                ->unescape(),
                        ])->icon('adjustments-vertical'),
                        Tab::make('Валюта', [
                            Divider::make('Выбрать валюту на всем сайте'),
                            Select::make('Валюта', 'currency')
                                ->options(function () {
                                    $all = config('currency.currency');
                                    return collect(['KZT' => $all['KZT']] + $all)
                                        ->map(fn($symbol, $code) => "{$code} ({$symbol})")
                                        ->toArray();
                                })
                                ->default('KZT')
                                ->required(),
                        ])->icon('currency-dollar'),

                        Tab::make('E-mail адреса', [
                            Divider::make('Получатели писем с форм сайта'),
                            Json::make('E-mail адреса', 'emails')->fields([
                                Text::make('E-mail', 'email')
                                    ->hint('Например: manager@hseiipa.kz'),
                            ])->vertical()->creatable()->removable(),
                        ])->icon('envelope'),

                        Tab::make('Нижнее меню', [
                            Grid::make([
                                Column::make([
                            Divider::make('Колонка 1'),
                            Json::make('Колонка 1', 'footer_col_1')->fields([
                                Text::make('Название', 'label'),
                                Text::make('Ссылка', 'url'),
                            ])->creatable()->removable(),

                            Divider::make('Колонка 2'),
                            Json::make('Колонка 2', 'footer_col_2')->fields([
                                Text::make('Название', 'label'),
                                Text::make('Ссылка', 'url'),
                            ])->creatable()->removable(),

                            Divider::make('Колонка 3'),
                            Json::make('Колонка 3', 'footer_col_3')->fields([
                                Text::make('Название', 'label'),
                                Text::make('Ссылка', 'url'),
                            ])->creatable()->removable(),

                            Divider::make('Колонка 4'),
                            Json::make('Колонка 4', 'footer_col_4')->fields([
                                Text::make('Название', 'label'),
                                Text::make('Ссылка', 'url'),
                            ])->creatable()->removable(),
                            Divider::make('Колонка 5'),
                            Json::make('Колонка 5', 'footer_col_5')->fields([
                                Text::make('Название', 'label'),
                                Text::make('Ссылка', 'url'),
                            ])->creatable()->removable(),

                                ])->columnSpan(8),

                            ]),

                        ])->icon('bars-3'),

                        Tab::make('Битрикс24', [
                            Grid::make([
                                Column::make([


                                                Text::make('', 'bx_webhook')->hint('BX_WEBHOOK')->locked(),
                                                Text::make('', 'bx_resp_id')->hint('BX_RESP_ID')->locked(),
                                                Text::make('', 'bx_email_to')->hint('Email')->locked(),

                                                Box::make([
                                                    Json::make('Формы', 'b24')->fields([
                                                        Select::make('Опции', 'json_forms')
                                                            ->options(
                                                                [
                                                                    'service'=> 'Услуги медиации',
                                                                    'training'=> 'Обучение медиации',
                                                                ]
                                                            )->required(),
                                                        Text::make('', 'bx_section_id')->hint('BX_SECTION_ID')->locked(),
                                                    ])->creatable(limit: 2)
                                                        ->removable(),
                                                    ])

                                ])->columnSpan(8),

                            ]),

                        ])->icon('bell-snooze'),
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
