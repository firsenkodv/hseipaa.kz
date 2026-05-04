@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1>{{ $page->title }}</h1>

        @if ($page->subtitle)
            <p class="subtitle">{{ $page->subtitle }}</p>
        @endif

        @if ($page->img)
            <img src="{{ Storage::url($page->img) }}" alt="{{ $page->title }}">
        @endif

        @if ($page->short_desc)
            <div class="short-desc">{!! $page->short_desc !!}</div>
        @endif

        @if ($page->desc)
            <div class="desc">{!! $page->desc !!}</div>
        @endif
    </div>
@endsection
