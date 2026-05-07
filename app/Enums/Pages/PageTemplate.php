<?php

declare(strict_types=1);

namespace App\Enums\Pages;

enum PageTemplate: string
{
    case Width = 'width';
    case Column = 'column';


    public function label(): string
    {
        return match($this) {
            self::Width => 'Во всю ширину',
            self::Column => 'Колонками',
        };
    }

    public function view(string $section): string
    {
        $specific = "pages.{$section}.templates.{$this->value}";
        $common   = "pages.common.templates.{$this->value}";

        if (view()->exists($specific)) return $specific;
        if (view()->exists($common))   return $common;

        return "pages.common.templates." . self::Width->value;
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
