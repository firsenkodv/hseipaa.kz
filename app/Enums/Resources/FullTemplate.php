<?php

declare(strict_types=1);

namespace App\Enums\Resources;

enum FullTemplate: string
{
    case Default = 'default';
    case Training = 'training';
    case Team = 'team';
    case Schedule = 'schedule';
    case Diploma = 'diploma';
    case Record = 'record';
    case Diploma2 = 'diploma2';
    case Consulting = 'consulting';
    case Credit = 'credit';

    public function label(): string
    {
        return match($this) {
            self::Default   => 'Стандартный',
            self::Training  => 'Обучение',
            self::Consulting => 'Консалтинг',
            self::Team      => 'Команда',
            self::Schedule  => 'Расписание',
            self::Diploma   => 'Поиск диплома',
            self::Diploma2  => 'Страница с дипломами',
            self::Record    => 'Запись на курс',
            self::Credit    => 'Обучение в кредит',
        };
    }

    public function view(string $resource): string
    {
        $specific = "pages.resourses.{$resource}.templates.full.{$this->value}";
        $common   = "pages.common.resourses.templates.full.{$this->value}";

        if (view()->exists($specific)) return $specific;

        return $common;
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
