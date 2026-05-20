@props(['page'])

@php
    $heading = $page->komanda_title ?: $page->title;
    $desc    = $page->komanda_desc  ?: $page->short_desc;
    $notes   = collect($page->komanda_items ?? []);
@endphp

<section class="team-wrap team-hero">
    <div class="team-hero__copy">

        @if($page->menu_title)
            <span class="team-hero__kicker">{{ $page->menu_title }}</span>
        @endif

        <h1>{{ $heading }}</h1>

        @if($desc)
            <p>{{ $desc }}</p>
        @endif

        <nav class="team-hero__nav" aria-label="Раздел О нас">
            <a href="{{ route('about') }}">О компании</a>
            <a class="is-active" href="{{ route('about.team') }}">Команда</a>
            <a href="{{ route('about.partners') }}">Партнёры</a>
            <a href="{{ route('about.documents') }}">Документы</a>
        </nav>

    </div>

    @if($notes->isNotEmpty())
        <aside class="team-hero__aside">
            @foreach($notes as $note)
                <article class="team-note">
                    @if(!empty($note['title']))
                        <strong>{{ $note['title'] }}</strong>
                    @endif
                    @if(!empty($note['desc']))
                        <p>{{ $note['desc'] }}</p>
                    @endif
                </article>
            @endforeach
        </aside>
    @endif
</section>
