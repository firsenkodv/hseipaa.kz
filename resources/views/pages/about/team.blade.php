@extends('layouts.layout')
<x-seo.meta-paginated :page="$page" :items="$items" />
@section('content')

    <div class="block">
        @if($page->title)
            <h1 class="h1">{{ $page->title }}</h1>
        @endif

        <ul>
            @foreach($items as $item)
                <li>{{ $item->title }}</li>
            @endforeach
        </ul>

        {{ $items->withQueryString()->links('pagination::default') }}

        @if($items->currentPage() === 1)
            @if($page->desc)
                <div class="desc">{!! $page->desc !!}</div>
            @endif
        @endif
    </div>

@endsection
