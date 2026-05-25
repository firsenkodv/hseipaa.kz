<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ConsultingCategory extends Model
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

    public function consultings(): BelongsToMany
    {
        return $this->belongsToMany(Consulting::class, 'consulting_consulting_category');
    }
}
