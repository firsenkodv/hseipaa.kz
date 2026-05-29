@props(['prefix' => 'logo'])

@php
    $isHome = request()->routeIs('home');
@endphp

@if ($isHome)
    <div {{ $attributes->merge(['class' => $prefix]) }}>
@else
    <a href="{{ route('home') }}" {{ $attributes->merge(['class' => $prefix]) }}>
@endif


    <img src="{{ Storage::url('/images/logo.svg') }}" alt="{{ config('site.constants.logo.alt') }}" class="{{ $prefix }}-icon" width="369" height="36" />


@if ($isHome)
    </div>
@else
    </a>
@endif

