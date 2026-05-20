@props([
    'title',
    'sub' => null,
])

<div class="form_title">
    <div class="form_title__h1">{{ $title }}</div>
    @if($sub)
        <p class="form_title__sub">{{ $sub }}</p>
    @endif
</div>
