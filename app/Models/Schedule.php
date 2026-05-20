<?php

namespace App\Models;

use App\Enums\Resources\FullTemplate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Schedule extends Model
{
    protected $fillable = [
        'title',
        'menu_title',
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
        'courses',
    ];

    public function courseItems(): BelongsToMany
    {
        return $this->belongsToMany(ScheduleCourse::class, 'course_schedule', 'schedule_id', 'course_id');
    }

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
            'faq'       => 'array',
            'courses'   => 'array',
        ];
    }
}
