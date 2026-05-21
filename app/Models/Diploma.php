<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Diploma extends Model
{
    protected $fillable = [
        'title',
        'fio',
        'issued_at',
        'discipline',
        'published',
        'sorting',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published', 1)->orderBy('sorting');
    }

    protected function casts(): array
    {
        return [
            'issued_at' => 'date',
            'published' => 'integer',
            'sorting'   => 'integer',
        ];
    }
}
