<?php

namespace Domain\Consulting\ViewModels;

use App\Models\Consulting;
use App\Models\Setting;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Fluent;
use Support\Traits\Makeable;

class ConsultingViewModel
{
    use Makeable;

    public function getPageData(): Fluent
    {
        return new Fluent(Setting::getGroup('konsalting')->data ?? []);
    }

    public function getPublished(?string $categorySlug = null, ?string $search = null): LengthAwarePaginator
    {
        return Consulting::with('categories')
            ->published()
            ->when($categorySlug, fn($q) => $q->whereHas('categories', fn($q) => $q->where('consulting_categories.slug', $categorySlug)))
            ->when($search, fn($q) => $q->where('title', 'like', '%' . $search . '%'))
            ->paginate(config('site.constants.paginate'));
    }

    public function getBySlug(string $slug): Consulting
    {
        return Consulting::published()->where('slug', $slug)->firstOrFail();
    }
}
