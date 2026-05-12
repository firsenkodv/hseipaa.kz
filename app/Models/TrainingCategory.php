<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TrainingCategory extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'sorting',
    ];

    protected function casts(): array
    {
        return [
            'sorting' => 'integer',
        ];
    }

    public function trainings(): BelongsToMany
    {
        return $this->belongsToMany(Training::class, 'training_training_category');
    }
}
