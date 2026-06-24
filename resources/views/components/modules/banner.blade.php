@props(['home' => null])

@php
    $link = $home['home_banner_link'] ?? '/poleznoe/stati/123-cap-icfm';
@endphp

<div class="block">
    <a href="{{ $link }}" class="banner" style="background-image: url({{ Storage::url('images/banner.jpg') }})"></a>
</div>
