@if($items->count())
@php
    $heading = $page->komanda_title ?: $page->title;
    $desc    = $page->komanda_desc  ?: $page->short_desc;
    $colors  = ['coral', 'violet', 'blue', 'green', 'amber'];
@endphp
<x-modules.team-hero :page="$page" />

<section class="team-wrap team-members">

    @if($heading || $desc)
        <div class="team-section-head">
            @if($heading)<h2>{{ $heading }}</h2>@endif
            @if($desc)<p>{{ $desc }}</p>@endif
        </div>
    @endif

    <div class="team-members__grid">
        @foreach($items as $item)
            @php
                $initials = collect(explode(' ', $item->title))
                    ->take(2)
                    ->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))
                    ->join('');
                $color = $colors[$loop->index % count($colors)];
            @endphp
            <a href="{{ route('about.team.show', [$item->slug]) }}" class="team-member-card">
                <span class="team-member-card__avatar team-member-card__avatar--{{ $color }}">{{ $initials }}</span>
                <strong>{{ $item->title }}</strong>
                @if($item->subtitle)
                    <span class="team-member-card__role">{{ $item->subtitle }}</span>
                @endif
                @if($item->short_desc)
                    <p>{!! $item->short_desc !!}</p>
                @endif
            </a>
        @endforeach
    </div>

    {{ $items->withQueryString()->links('pagination::default') }}


</section>
@endif


<x-modules.team-values :page="$page" />
<x-modules.team-structure :page="$page" />
