@extends('layouts.layout')
<x-seo.meta
    title="{{ $home['metatitle'] }}"
    description="{{ $home['description'] }}"
    keywords="{{ $home['keywords'] }}"
/>
@section('content')

   <x-modules.slider_news/>

   <x-modules.banner :home="$home" />

    <x-modules.programs :home="$home" />

    <x-modules.schedule :home="$home" />

    <x-modules.advantages :home="$home" />

    <x-modules.consulting :home="$home" />

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

