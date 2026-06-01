@extends('layouts.layout')
<x-seo.meta
    title="{{ $item->metatitle ?: $item->title }}"
    description="{{ $item->description }}"
    keywords="{{ $item->keywords }}"
/>
@section('content')

    <div class="content_page">
        <div class="block">

            <div class="block_content__breadcrumbs">{{ Breadcrumbs::render(Route::currentRouteName(), $item) }}</div>



            @if($item->template === \App\Enums\Resources\FullTemplate::Default)
                @if($item->title)
                    <h1 class="h1">{{ $item->title }}</h1>
                @endif
                @if($item->subtitle)
                    <div class="content_page__subtitle">{{ $item->subtitle }}</div>
                @endif
            @endif


            @include($item->template->view($resource), ['item' => $item])

            @if($resource === 'team' && isset($others) && $others->isNotEmpty())
                @php
                    $colors  = ['coral', 'violet', 'blue', 'green', 'amber'];
                    $heading = $page->komanda_title ?: $page->title ?? null;
                    $desc    = $page->komanda_desc  ?: $page->short_desc ?? null;
                @endphp
                <section class="team-wrap team-members">
                    @if($heading || $desc)
                        <div class="team-section-head">
                            @if($heading)<h2>{{ $heading }}</h2>@endif
                            @if($desc)<p>{{ $desc }}</p>@endif
                        </div>
                    @endif
                    <div class="team-members__grid">
                        @foreach($others as $member)
                            @php
                                $initials = collect(explode(' ', $member->title))
                                    ->take(2)
                                    ->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))
                                    ->join('');
                                $color = $colors[$loop->index % count($colors)];
                            @endphp
                            <a href="{{ route('about.team.show', [$member->slug]) }}" class="team-member-card">
                                <span class="team-member-card__avatar team-member-card__avatar--{{ $color }}">{{ $initials }}</span>
                                <strong>{{ $member->title }}</strong>
                                @if($member->subtitle)
                                    <span class="team-member-card__role">{{ $member->subtitle }}</span>
                                @endif
                                @if($member->short_desc)
                                    <p>{!! $member->short_desc !!}</p>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

        </div>
    </div>

@endsection
