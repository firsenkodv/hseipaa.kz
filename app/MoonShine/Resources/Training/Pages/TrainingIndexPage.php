<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Training\Pages;

use App\MoonShine\Resources\Training\TrainingResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Contracts\Core\DependencyInjection\CrudRequestContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Crud\JsonResponse;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Support\Attributes\AsyncMethod;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Preview;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<TrainingResource>
 */
final class TrainingIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Image::make(__('Изображение'), 'img'),
            Text::make('Заголовок', 'title')->unescape()->updateOnPreview(),
            Text::make('Шаблон', 'template', fn($item) => $item->template?->label() ?? ''),
            Preview::make('Категории', 'categories', fn($item) => $item->categories->pluck('title')->implode(', ')),
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
                    ->withConfirm('Clone this row?', 'К полю "slug" добавляется функция time(), исправьте это вручную.')
            );
    }


    #[AsyncMethod]
    public static function duplicateRow(CrudRequestContract $request, JsonResponse $response)
    {
        $resource = $request->getResource();

        /** @var Model $newItem */
        $newItem = $resource?->getItem()->replicate();

        $newItem->slug = $newItem->slug . time();
        $newItem->save();

        $url = $resource?->getFormPageUrl($newItem->id);

        //return $response->redirect($url);
        return redirect()->back();
    }
}
