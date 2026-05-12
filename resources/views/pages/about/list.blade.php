@extends('layouts.layout')
<x-seo.meta-paginated :page="$page" :items="$items" />
@section('content')
    <div class="content_page">
        <div class="block">
            <div class="block_content__breadcrumbs">{{ Breadcrumbs::render(Route::currentRouteName()) }}</div>

            <!--Список-->
            @include($teaser_template->view($section), ['items' => $items, 'route' => $route])
        </div>
            <!--Описание-->
            @include($template->view($section))

    </div>
@endsection
