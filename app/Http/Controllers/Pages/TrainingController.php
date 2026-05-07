<?php

namespace App\Http\Controllers\Pages;

use Domain\Training\ViewModels\TrainingViewModel;
use Illuminate\Contracts\View\View;

class TrainingController extends PageController
{
    public function index(): View
    {
        $vm    = TrainingViewModel::make();
        $items = $vm->getPublished();

        return view('pages.training.index', [
            'page'       => $vm->getPageData(),
            'items'      => $items,
            'pageSuffix' => $this->pageSuffix($items),
        ]);
    }
}
