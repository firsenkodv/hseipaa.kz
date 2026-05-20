<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Schedule\Pages;

use App\MoonShine\Resources\Schedule\ScheduleResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Contracts\Core\DependencyInjection\CrudRequestContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Crud\JsonResponse;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Support\Attributes\AsyncMethod;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<ScheduleResource>
 */
final class ScheduleIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Заголовок', 'title')->unescape()->updateOnPreview(),
            Text::make('Меню', 'menu_title')->unescape()->updateOnPreview(),
            Text::make('Шаблон', 'template', fn($item) => $item->template?->label() ?? ''),
            Text::make('Валюта', 'currency', fn($item) => collect($item->courses ?? [])
                ->pluck('currency')
                ->filter()
                ->unique()
                ->implode(', ')
            ),
            Switcher::make('Опубликовано', 'published')->updateOnPreview(),
            Text::make('Сортировка', 'sorting')->updateOnPreview(),
        ];
    }
    protected function buttons(): ListOf
    {
        return parent::buttons()
            ->add(
                ActionButton::make('Clone')
                    ->icon('document-duplicate')
                    ->method('duplicateRow')
                    ->withConfirm('Clone this row?', 'Сохраняется без полей "img", к полю "slug" добавляется функция time(), исправьте это вручную.')
            );
    }


    #[AsyncMethod]
    public static function duplicateRow(CrudRequestContract $request, JsonResponse $response)
    {
        $resource = $request->getResource();

        /** @var Model $newItem */
        $newItem = $resource?->getItem()->replicate();

        $newItem->img = null;
        $newItem->slug = $newItem->slug . time();
        $newItem->save();

        $url = $resource?->getFormPageUrl($newItem->id);

        //return $response->redirect($url);
        return redirect()->back();
    }
}
