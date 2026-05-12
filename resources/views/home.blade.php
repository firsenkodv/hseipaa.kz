@extends('layouts.layout')
<x-seo.meta
    title="{{ $home['metatitle'] }}"
    description="{{ $home['description'] }}"
    keywords="{{ $home['keywords'] }}"
/>
@section('content')

   <x-modules.slider_news/>

   <x-modules.banner />

    <x-modules.programs />

    <x-modules.schedule />

    <x-modules.advantages />

    <x-modules.consulting />

    <x-modules.actions_strip />

    <x-modules.faq :items="$home['faq']" />

   <x-form.form-end-to-end.form-blue-component />

    @if($home['desc'])
        <div class="block home_desc">
            <h1 class="h1">{{ $home['title'] }}</h1>
            <div class="desc">
            {!! $home['desc'] !!}
        </div>
        </div>
    @endif
@endsection

