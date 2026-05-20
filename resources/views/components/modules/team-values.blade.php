@props(['page'])

@php
    $heading = $page->kak_title ?: $page->title;
    $desc    = $page->kak_desc  ?: $page->short_desc;
    $items   = collect($page->kak_items ?? []);
@endphp

@if($items->isNotEmpty())
<section class="team-wrap team-values">

    @if($heading || $desc)
        <div class="team-section-head">
            @if($heading)<h2>{{ $heading }}</h2>@endif
            @if($desc)<p>{{ $desc }}</p>@endif
        </div>
    @endif

    <div class="team-values__grid">
        @foreach($items as $item)
            <article>
                <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                @if(!empty($item['title']))
                    <h3>{{ $item['title'] }}</h3>
                @endif
                @if(!empty($item['desc']))
                    <p>{!! $item['desc'] !!}</p>
                @endif
            </article>
        @endforeach
    </div>

</section>
@endif
