<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ScheduleCourse\Pages;

use App\MoonShine\Resources\ScheduleCourse\ScheduleCourseResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Contracts\Core\DependencyInjection\CrudRequestContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Crud\JsonResponse;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Support\Attributes\AsyncMethod;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<ScheduleCourseResource>
 */
final class ScheduleCourseIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Название', 'title')->unescape()->updateOnPreview(),
           // Text::make('Подзаголовок', 'subtitle')->unescape()->updateOnPreview(),
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
                    ->withConfirm('Clone this row?', 'Сохраняется...')
            );
    }


    #[AsyncMethod]
    public static function duplicateRow(CrudRequestContract $request, JsonResponse $response)
    {
        $resource = $request->getResource();

        /** @var Model $newItem */
        $newItem = $resource?->getItem()->replicate();

        $newItem->save();

        $url = $resource?->getFormPageUrl($newItem->id);

        //return $response->redirect($url);
        return redirect()->back();
    }
}
