@extends('layouts.layout')
<x-seo.meta-paginated :page="$page" :items="$items" />
@section('content')

    <div class="content_page">
    <div class="block">
        <div class="block_content__breadcrumbs">{{ Breadcrumbs::render(Route::currentRouteName()) }}</div>
       @if($page->title)
            <h1 class="h1">{{ $page->title }}</h1>
        @endif

        @include($template->view($section), ['items' => $items, 'route' => $route])
        {{ $items->withQueryString()->links('pagination::default') }}

        @if($items->currentPage() === 1)
            @if($page->desc)
                <div class="desc">{!! $page->desc !!}</div>
            @endif
        @endif

    </div>
    </div>
@endsection
