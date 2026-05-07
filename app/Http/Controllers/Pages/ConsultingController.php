<?php

namespace App\Http\Controllers\Pages;

use Domain\Consulting\ViewModels\ConsultingViewModel;
use Illuminate\Contracts\View\View;

class ConsultingController extends PageController
{
    public function index(): View
    {
        $vm    = ConsultingViewModel::make();
        $items = $vm->getPublished();

        return view('pages.consulting.index', [
            'page'       => $vm->getPageData(),
            'items'      => $items,
            'pageSuffix' => $this->pageSuffix($items),
        ]);
    }
}
