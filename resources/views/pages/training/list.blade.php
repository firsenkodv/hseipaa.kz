@extends('layouts.layout')
<x-seo.meta-paginated :page="$page" :items="$items" />
@section('content')
    <div class="content_page">
        <div class="block">
            <div class="block_content__breadcrumbs">{{ Breadcrumbs::render(Route::currentRouteName()) }}</div>


            @if($page->title && $template !== \App\Enums\Pages\PageTemplate::Training)
                <h1 class="h1">{{ $page->title }}</h1>
            @endif


            @include($template->view($section))
            @if($items->count())
                <!--Список-->
                @include($teaser_template->view($section), ['items' => $items, 'route' => $route])
              @endif
        </div>
        <div class="page-wrapper">
        <x-modules.about-platform />
            @if($page->faq)
            <div class="pad_t20">
            <x-modules.faq :items="$page->faq" />
            </div>
            @endif
        </div>
    </div>
@endsection
