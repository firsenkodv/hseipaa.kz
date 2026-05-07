<?php

namespace App\Http\Controllers\Pages;

use Domain\Remote\ViewModels\RemoteViewModel;
use Illuminate\Contracts\View\View;

class RemoteController extends PageController
{
    public function index(): View
    {
        $vm    = RemoteViewModel::make();
        $items = $vm->getPublished();

        return view('pages.remote.index', [
            'page'       => $vm->getPageData(),
            'items'      => $items,
            'pageSuffix' => $this->pageSuffix($items),
        ]);
    }
}
