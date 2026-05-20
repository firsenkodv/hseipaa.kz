<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Domain\City\ViewModels\CityViewModel;
use Illuminate\Contracts\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $cities = CityViewModel::make()->getCities();

        return view('pages.contacts', [
            'cities' => $cities,
        ]);
    }
}
