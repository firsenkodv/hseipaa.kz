<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ScheduleCourse extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'sorting',
    ];

    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(Schedule::class, 'course_schedule', 'course_id', 'schedule_id');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sorting');
    }

    protected function casts(): array
    {
        return [
            'sorting' => 'integer',
        ];
    }
}
