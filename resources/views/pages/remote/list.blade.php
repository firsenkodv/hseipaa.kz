@extends('layouts.layout')
<x-seo.meta-paginated :page="$page" :items="$items"/>
@section('content')
    <div class="content_page">
        <div class="block">
            <div class="block_content__breadcrumbs">{{ Breadcrumbs::render(Route::currentRouteName()) }}</div>

            @if($template === \App\Enums\Pages\PageTemplate::Default)
                @if($page->title)
                    <h1 class="h1">{{ $page->title }}</h1>
                @endif
                @if($page->short_desc)
                    <div class="short_desc desc">{!!  $page->short_desc  !!}</div>
                @endif
            @endif

            @if($items->count())
                <!--Список-->
                @include($teaser_template->view($section), ['items' => $items, 'route' => $route])
            @endif

            <!--Описание-->
            @include($template->view($section))
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
