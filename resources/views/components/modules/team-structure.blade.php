@props(['page'])

@php
    $heading = $page->sila_title ?: $page->title;
    $desc    = $page->sila_desc  ?: $page->short_desc;
    $cards   = collect($page->sila_items ?? []);
@endphp

@if($cards->isNotEmpty())
<section class="team-wrap team-structure">

    @if($heading || $desc)
        <div class="team-section-head">
            @if($heading)<h2>{{ $heading }}</h2>@endif
            @if($desc)<p>{{ $desc }}</p>@endif
        </div>
    @endif

    <div class="team-structure__grid">
        @foreach($cards as $card)
            <article class="team-structure__card">
                @if(!empty($card['title']))
                    <strong>{{ $card['title'] }}</strong>
                @endif
                @if(!empty($card['desc']))
                    <p>{!! $card['desc'] !!}</p>
                @endif
            </article>
        @endforeach
    </div>

</section>
@endif
