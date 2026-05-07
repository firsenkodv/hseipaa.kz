<?php

namespace App\Http\Controllers\Pages;

use Domain\About\ViewModels\AboutViewModel;
use Domain\About\ViewModels\DocumentViewModel;
use Domain\About\ViewModels\PartnerViewModel;
use Domain\About\ViewModels\TeamViewModel;
use Illuminate\Contracts\View\View;

class AboutController extends PageController
{
    public function index(): View
    {
        $vm    = AboutViewModel::make();
        $items = $vm->getPublished();

        return view('pages.about.index', [
            'page'       => $vm->getPageData(),
            'items'      => $items,
            'pageSuffix' => $this->pageSuffix($items),
        ]);
    }

    public function team(): View
    {
        $vm    = TeamViewModel::make();
        $items = $vm->getPublished();

        return view('pages.about.team', [
            'page'       => $vm->getPageData(),
            'items'      => $items,
            'pageSuffix' => $this->pageSuffix($items),
        ]);
    }

    public function partners(): View
    {
        $vm    = PartnerViewModel::make();
        $items = $vm->getPublished();

        return view('pages.about.partners', [
            'page'       => $vm->getPageData(),
            'items'      => $items,
            'pageSuffix' => $this->pageSuffix($items),
        ]);
    }

    public function documents(): View
    {
        $vm    = DocumentViewModel::make();
        $items = $vm->getPublished();

        return view('pages.about.documents', [
            'page'       => $vm->getPageData(),
            'items'      => $items,
            'pageSuffix' => $this->pageSuffix($items),
        ]);
    }
}
