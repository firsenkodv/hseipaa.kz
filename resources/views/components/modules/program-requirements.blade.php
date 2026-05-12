@props(['item'])

@php
    $icons = [
        asset('images/program/requirement-education.svg'),
        asset('images/program/requirement-experience.svg'),
        asset('images/program/requirement-knowledge.svg'),
        asset('images/program/requirement-language.svg'),
    ];
@endphp

@if($item->req_title || !empty($item->req_items))
<section class="program-block" aria-labelledby="requirements-title">
    @if($item->req_title || $item->req_desc)
        <div class="program-section__intro program-section__intro--center">
            @if($item->req_title)
                <h2 id="requirements-title">{{ $item->req_title }}</h2>
            @endif
            @if($item->req_desc)
                <p>{{ $item->req_desc }}</p>
            @endif
        </div>
    @endif

    @if(!empty($item->req_items))
        <div class="program-requirements__grid">
            @foreach($item->req_items as $index => $card)
                <article class="program-requirement-card">
                    <img src="{{ $icons[$index % count($icons)] }}" alt="">
                    @if(!empty($card['title']))
                        <h3>{{ $card['title'] }}</h3>
                    @endif
                    @if(!empty($card['desc']))
                        <p>{{ $card['desc'] }}</p>
                    @endif
                </article>
            @endforeach
        </div>
    @endif
</section>
@endif
