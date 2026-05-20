<?php

namespace App\Models;

use App\Enums\Resources\FullTemplate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Training extends Model
{
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(TrainingCategory::class, 'training_training_category');
    }

    protected $fillable = [
        'title',
        'slug',
        'template',
        'subtitle',
        'short_desc',
        'img',
        'desc',
        'img2',
        'desc2',
        'html',
        'html2',
        'published',
        'params',
        'video',
        'gallery',
        'files',
        'metatitle',
        'description',
        'keywords',
        'script',
        'sorting',
        'faq',
        'custom_field',
        'custom_field2',
        'custom_field3',
        // Покупка
        'buy_title',
        'buy_desc',
        'buy_calendar',
        'buy_hours',
        'buy_certificate',
        'price',
        // О курсе
        'course_title',
        'course_desc',
        'course_items',
        // Что вы получаете
        'get_title',
        'get_items',
        // Преимущества
        'adv_title',
        'adv_desc',
        'adv_items',
        // Требования
        'req_title',
        'req_desc',
        'req_items',
        // Кому подойдет
        'aud_title',
        'aud_items',
        // Программа курса
        'outline_title',
        'outline_desc',
        'outline_stats',
        'outline_modules',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', 1)->orderBy('sorting');
    }

    protected function casts(): array
    {
        return [
            'published' => 'integer',
            'sorting'   => 'integer',
            'template'  => FullTemplate::class,
            'video'     => 'array',
            'gallery'   => 'array',
            'files'     => 'array',
            'faq'          => 'array',
            'course_items'  => 'array',
            'get_items'     => 'array',
            'price' => 'array',
            'adv_items'     => 'array',
            'req_items'     => 'array',
            'aud_items'     => 'array',
            'outline_stats'   => 'array',
            'outline_modules' => 'array',
        ];
    }
}
