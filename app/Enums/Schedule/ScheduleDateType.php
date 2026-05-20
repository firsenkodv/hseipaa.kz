<?php

declare(strict_types=1);

namespace App\Enums\Schedule;

enum ScheduleDateType: string
{
    case Quarterly = 'quarterly';
    case Monthly   = 'monthly';
    case Weekly  = 'weekly';
    case OnDemand  = 'on_demand';

    public function label(): string
    {
        return match($this) {
            self::Quarterly => 'Ежеквартально',
            self::Monthly   => 'Ежемесячно',
            self::Weekly   => 'Еженедельно',
            self::OnDemand  => 'По мере формирования группы',
        };
    }

    public static function toOptions(): array
    {
        return array_column(
            array_map(fn(self $case) => ['value' => $case->value, 'label' => $case->label()], self::cases()),
            'label',
            'value'
        );
    }
}
