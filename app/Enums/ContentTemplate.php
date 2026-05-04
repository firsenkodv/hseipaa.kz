<?php

declare(strict_types=1);

namespace App\Enums;

enum ContentTemplate: string
{
    case Default = 'default';
/*    case Wide    = 'wide';
    case Promo   = 'promo';
    case Gallery = 'gallery';*/

    public function label(): string
    {
        return match($this) {
            self::Default => 'Стандартный',
/*            self::Wide    => 'Широкий',
            self::Promo   => 'Промо',
            self::Gallery => 'Галерея',*/
        };
    }

    /**
     * Resolves view path: resource-specific if exists, otherwise common fallback.
     */
    public function view(string $resource): string
    {
        $specific = "templates.{$resource}.{$this->value}";

        return view()->exists($specific) ? $specific : "templates.common.{$this->value}";
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
