<?php

declare(strict_types=1);

namespace App\Enums\Months;

enum Month: string
{
    case January   = 'january';
    case February  = 'february';
    case March     = 'march';
    case April     = 'april';
    case May       = 'may';
    case June      = 'june';
    case July      = 'july';
    case August    = 'august';
    case September = 'september';
    case October   = 'october';
    case November  = 'november';
    case December  = 'december';

    public function label(): string
    {
        return match($this) {
            self::January   => 'Январь',
            self::February  => 'Февраль',
            self::March     => 'Март',
            self::April     => 'Апрель',
            self::May       => 'Май',
            self::June      => 'Июнь',
            self::July      => 'Июль',
            self::August    => 'Август',
            self::September => 'Сентябрь',
            self::October   => 'Октябрь',
            self::November  => 'Ноябрь',
            self::December  => 'Декабрь',
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
