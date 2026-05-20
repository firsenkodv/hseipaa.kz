<?php

namespace App\View\Components\Schedule;

use App\Enums\Months\Month;
use App\Enums\Schedule\ScheduleDateType;
use App\Models\Schedule;
use App\Models\ScheduleCourse;
use App\Models\Setting;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ScheduleTable extends Component
{
    public array $courses;
    public array $months;
    public string $currencySymbol;

    public function __construct(public Schedule $item)
    {
        $currencyCode         = Setting::getGroup('social')->data['currency'] ?? 'KZT';
        $this->currencySymbol = config('currency.currency')[$currencyCode] ?? $currencyCode;

        $courseIds    = collect($item->courses ?? [])
            ->pluck('course_id')
            ->filter()
            ->map(fn($id) => (int) $id)
            ->unique();

        $courseModels = ScheduleCourse::whereIn('id', $courseIds)->get()->keyBy('id');
        $allCurrencies = config('currency.currency');

        $this->courses = collect($item->courses ?? [])
            ->map(function ($entry) use ($courseModels, $allCurrencies) {
                $entry['course_title']    = $courseModels[(int) ($entry['course_id'] ?? 0)]?->title ?? '—';
                $entry['date_type_label'] = isset($entry['date_type']) && $entry['date_type']
                    ? ScheduleDateType::tryFrom($entry['date_type'])?->label()
                    : null;
                $entry['date_formatted']  = !empty($entry['date'])
                    ? Carbon::parse($entry['date'])->locale('ru')->translatedFormat('j F Y')
                    : null;
                // Per-entry currency symbol, fallback to global setting
                $entryCode = $entry['currency'] ?? null;
                $entry['currency_symbol'] = ($entryCode && isset($allCurrencies[$entryCode]))
                    ? $allCurrencies[$entryCode]
                    : $this->currencySymbol;
                return $entry;
            })
            ->toArray();

        // Unique months used (in calendar order) for the filter bar
        $monthNumToValue = [
            1 => 'january',  2 => 'february', 3 => 'march',    4 => 'april',
            5 => 'may',      6 => 'june',     7 => 'july',     8 => 'august',
            9 => 'september',10 => 'october', 11 => 'november',12 => 'december',
        ];

        $usedValues = collect($this->courses)
            ->flatMap(function ($c) use ($monthNumToValue) {
                $months = collect($c['months'] ?? []);
                if (!empty($c['date'])) {
                    $val = $monthNumToValue[(int) Carbon::parse($c['date'])->format('n')] ?? null;
                    if ($val) $months = $months->push($val);
                }
                return $months;
            })
            ->filter()
            ->unique()
            ->values();

        $this->months = collect(Month::cases())
            ->filter(fn($m) => $usedValues->contains($m->value))
            ->map(fn($m) => ['value' => $m->value, 'label' => $m->label()])
            ->values()
            ->toArray();
    }

    public function render(): View|Closure|string
    {
        return view('components.schedule.schedule-table');
    }
}
