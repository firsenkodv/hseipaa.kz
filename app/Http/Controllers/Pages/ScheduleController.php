<?php

namespace App\Http\Controllers\Pages;

use App\Enums\Months\Month;
use Carbon\Carbon;
use App\Enums\Pages\PageTemplate;
use App\Enums\Resources\TeaserTemplate;
use App\Enums\Schedule\ScheduleDateType;
use App\Models\Schedule;
use App\Models\ScheduleCourse;
use App\Models\Setting;
use Domain\Schedule\ViewModels\ScheduleViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleController extends PageController
{
    public function index(): View
    {
        $vm    = ScheduleViewModel::make();
        $items = $vm->getPublished();
        $page  = $vm->getPageData();

        return view('pages.schedule.list', [
            'page'            => $page,
            'items'           => $items,
            'pageSuffix'      => $this->pageSuffix($items),
            'template'        => PageTemplate::from($page->page_template ?? PageTemplate::Default->value),
            'teaser_template' => TeaserTemplate::from($page->section_template ?? TeaserTemplate::Default->value),
            'section'         => 'raspisani',
            'route'           => 'schedule.show',
        ]);
    }

    public function filterByCourse(Request $request): JsonResponse
    {
        $courseId = (int) $request->input('course_id');

        $currencyCode   = Setting::getGroup('social')->data['currency'] ?? 'KZT';
        $currencySymbol = config('currency.currency')[$currencyCode] ?? $currencyCode;

        $results = [];

        Schedule::published()->each(function (Schedule $schedule) use ($courseId, $currencySymbol, &$results) {
            foreach ($schedule->courses ?? [] as $entry) {
                if ((int) ($entry['course_id'] ?? 0) !== $courseId) {
                    continue;
                }

                $months = array_values(array_filter(
                    array_map(fn($m) => Month::tryFrom($m)?->label(), (array) ($entry['months'] ?? []))
                ));

                $dateType = isset($entry['date_type']) && $entry['date_type']
                    ? ScheduleDateType::tryFrom($entry['date_type'])?->label()
                    : null;

                $results[] = [
                    'city'      => $schedule->menu_title ?: $schedule->title,
                    'url'       => route('schedule.show', $schedule->slug),
                    'date'      => !empty($entry['date'])
                        ? Carbon::parse($entry['date'])->locale('ru')->translatedFormat('j F Y')
                        : null,
                    'date_type' => $dateType,
                    'months'    => $months,
                    'time'      => $entry['time'] ?? null,
                    'hours'     => $entry['hours'] ?? null,
                    'price'     => $entry['price'] ?? null,
                    'currency'  => $currencySymbol,
                    'note'      => $entry['note'] ?? null,
                ];
            }
        });

        return response()->json($results);
    }

    public function filterByMonth(string $slug, Request $request): JsonResponse
    {
        $schedule = Schedule::published()->where('slug', $slug)->firstOrFail();
        $month    = $request->input('month');

        $globalCode     = Setting::getGroup('social')->data['currency'] ?? 'KZT';
        $allCurrencies  = config('currency.currency');
        $globalSymbol   = $allCurrencies[$globalCode] ?? $globalCode;

        $courseIds    = collect($schedule->courses ?? [])
            ->pluck('course_id')->filter()->map(fn($id) => (int) $id)->unique();
        $courseModels = ScheduleCourse::whereIn('id', $courseIds)->get()->keyBy('id');

        $monthNumToValue = [
            1 => 'january',  2 => 'february', 3 => 'march',    4 => 'april',
            5 => 'may',      6 => 'june',     7 => 'july',     8 => 'august',
            9 => 'september',10 => 'october', 11 => 'november',12 => 'december',
        ];

        $rows = collect($schedule->courses ?? [])
            ->filter(function ($entry) use ($month, $monthNumToValue) {
                if (!$month || $month === 'all') return true;
                if (in_array($month, (array) ($entry['months'] ?? []))) return true;
                if (!empty($entry['date'])) {
                    $dateMonthVal = $monthNumToValue[(int) Carbon::parse($entry['date'])->format('n')] ?? null;
                    if ($dateMonthVal === $month) return true;
                }
                return false;
            })
            ->map(function ($entry) use ($courseModels, $allCurrencies, $globalSymbol) {
                $entryCode     = $entry['currency'] ?? null;
                $currencySymbol = ($entryCode && isset($allCurrencies[$entryCode]))
                    ? $allCurrencies[$entryCode]
                    : $globalSymbol;

                $dateFormatted = !empty($entry['date'])
                    ? Carbon::parse($entry['date'])->locale('ru')->translatedFormat('j F Y')
                    : null;

                return [
                    'course_title'    => $courseModels[(int) ($entry['course_id'] ?? 0)]?->title ?? '—',
                    'date_formatted'  => $dateFormatted,
                    'date_type_label' => isset($entry['date_type']) && $entry['date_type']
                        ? ScheduleDateType::tryFrom($entry['date_type'])?->label()
                        : null,
                    'note'  => $entry['note']  ?? '',
                    'time'  => $entry['time']  ?? '',
                    'price' => !empty($entry['price'])
                        ? price($entry['price']) . ' ' . $currencySymbol
                        : '',
                    'hours' => $entry['hours'] ?? '',
                ];
            })
            ->values();

        return response()->json($rows);
    }

    public function indexShow(string $slug): View
    {
        $vm   = ScheduleViewModel::make();
        $item = $vm->getBySlug($slug);
        $page = $vm->getPageData();

        return view('pages.schedule.show', [
            'page' => $page,
            'item' => $item,
        ]);
    }
}
