<?php

namespace App\Http\Controllers\Pages;

use App\Enums\Pages\PageTemplate;
use App\Models\News;
use Domain\News\ViewModels\NewsViewModel;
use Domain\Resources\ViewModels\DiplomaViewModel;
use Domain\Resources\ViewModels\ImportantViewModel;
use Domain\Resources\ViewModels\LawViewModel;
use Domain\Resources\ViewModels\SeminarViewModel;
use Domain\Resources\ViewModels\UsefulViewModel;
use Illuminate\Contracts\View\View;

class ResourcesController extends PageController
{
    public function index(): View
    {
        $vm    = UsefulViewModel::make();
        $items = $vm->getPublished();

        return view('pages.resources.index', [
            'page'       => $vm->getPageData(),
            'items'      => $items,
            'pageSuffix' => $this->pageSuffix($items),
        ]);
    }

    public function laws(): View
    {
        $vm    = LawViewModel::make();
        $items = $vm->getPublished();
        $page  = $vm->getPageData();

        return view('pages.resources.laws', [
            'page'       => $page,
            'items'      => $items,
            'pageSuffix' => $this->pageSuffix($items),
            'template'   => PageTemplate::from($page->page_template ?? PageTemplate::Width->value),
            'section'    => 'resources.laws',
            'route'      => 'resources.laws.show',
        ]);
    }

    public function lawsShow(string $slug): View
    {
        $vm   = LawViewModel::make();
        $item = $vm->getBySlug($slug);
        $page = $vm->getPageData();

        return view('pages.resources.laws-show', [
            'page' => $page,
            'item' => $item,
        ]);
    }

    public function news(): View
    {
        $vm    = NewsViewModel::make();
        $items = $vm->getPublished();
        $page  = $vm->getPageData();



        return view('pages.resources.news', [
            'page'       => $page,
            'items'      => $items,
            'pageSuffix' => $this->pageSuffix($items),
            'template'   => PageTemplate::from($page->page_template ?? PageTemplate::Width->value),
            'section'    => 'resources.news',
            'route'      => 'resources.news.show',
        ]);
    }

    public function newsShow(string $slug): View
    {
        $vm   = NewsViewModel::make();
        $item = $vm->getBySlug($slug);
        $page = $vm->getPageData();

        return view('pages.resources.news-show', [
            'page' => $page,
            'item' => $item,
        ]);
    }

    public function important(): View
    {
        $vm    = ImportantViewModel::make();
        $items = $vm->getPublished();

        return view('pages.resources.important', [
            'page'       => $vm->getPageData(),
            'items'      => $items,
            'pageSuffix' => $this->pageSuffix($items),
        ]);
    }

    public function diplomas(): View
    {
        $vm    = DiplomaViewModel::make();
        $items = $vm->getPublished();
        $page  = $vm->getPageData();

        return view('pages.resources.diplomas', [
            'page'       => $page,
            'items'      => $items,
            'pageSuffix' => $this->pageSuffix($items),
            'template'   => PageTemplate::from($page->page_template ?? PageTemplate::Width->value),
            'section'    => 'resources.diplomas',
            'route'      => 'resources.diplomas.show',
        ]);
    }

    public function diplomasShow(string $slug): View
    {
        $vm   = DiplomaViewModel::make();
        $item = $vm->getBySlug($slug);
        $page = $vm->getPageData();

        return view('pages.resources.diplomas-show', [
            'page' => $page,
            'item' => $item,
        ]);
    }

    public function seminar(): View
    {
        $vm    = SeminarViewModel::make();
        $items = $vm->getPublished();
        $page  = $vm->getPageData();

        return view('pages.resources.seminar', [
            'page'       => $page,
            'items'      => $items,
            'pageSuffix' => $this->pageSuffix($items),
            'template'   => PageTemplate::from($page->page_template ?? PageTemplate::Width->value),
            'section'    => 'resources.seminar',
            'route'      => 'resources.seminar.show',
        ]);
    }

    public function seminarShow(string $slug): View
    {
        $vm   = SeminarViewModel::make();
        $item = $vm->getBySlug($slug);
        $page = $vm->getPageData();

        return view('pages.resources.seminar-show', [
            'page' => $page,
            'item' => $item,
        ]);
    }
}
