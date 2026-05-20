<?php

namespace Domain\City\ViewModels;

use App\Models\City;
use Illuminate\Database\Eloquent\Collection;
use Support\Traits\Makeable;

class CityViewModel
{
    use Makeable;

    public function getCities(): Collection
    {
        return City::published()->get();
    }
}
