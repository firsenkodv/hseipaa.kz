<?php

namespace Domain\Training\ViewModels;

use App\Models\Training;
use App\Models\Setting;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Fluent;
use Support\Traits\Makeable;

class TrainingViewModel
{
    use Makeable;

    public function getPageData(): Fluent
    {
        return new Fluent(Setting::getGroup('obuchenie')->data ?? []);
    }

    public function getPublished(?string $categorySlug = null, ?string $search = null): LengthAwarePaginator
    {
        return Training::with('categories')
            ->published()
            ->when($categorySlug, fn($q) => $q->whereHas('categories', fn($q) => $q->where('training_categories.slug', $categorySlug)))
            ->when($search, fn($q) => $q->where('title', 'like', '%' . $search . '%'))
            ->reorder('sorting', 'desc')
            ->paginate(config('site.constants.paginate'));
    }

    public function getBySlug(string $slug): Training
    {
        return Training::published()->where('slug', $slug)->firstOrFail();
    }
}
