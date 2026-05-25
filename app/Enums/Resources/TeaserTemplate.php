<?php

declare(strict_types=1);

namespace App\Enums\Resources;

enum TeaserTemplate: string
{
    case No = 'no';
    case Default = 'default';
    case Colomns = 'colomns';
    case Training = 'training';
    case About = 'about';
    case Team = 'team';
    case Schedule = 'schedule';
    case Consulting = 'consulting';

    public function label(): string
    {
        return match($this) {
            self::No        => 'Не выводить!',
            self::Default   => 'Стандартный',
            self::Colomns   => 'Колонки',
            self::Training  => 'Обучение',
            self::Consulting => 'Консалтинг',
            self::About     => 'О нас',
            self::Team      => 'Команда',
            self::Schedule  => 'Расписание',
        };
    }

    public function view(string $section): string
    {
        $specific = "pages.{$section}.resourses.templates.teaser.{$this->value}";
        $common   = "pages.common.resourses.templates.teaser.{$this->value}";

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
