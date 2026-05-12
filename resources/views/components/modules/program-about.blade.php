@props(['item'])

@php
    $icons = [
        asset('images/program/about-practice.svg'),
        asset('images/program/about-teachers.svg'),
        asset('images/program/about-program.svg'),
        asset('images/program/about-growth.svg'),
    ];
@endphp

@if($item->course_title || !empty($item->course_items))
<section class="program-block program-block--soft" aria-labelledby="program-about-title">
    @if($item->course_title || $item->course_desc)
        <div class="program-section__intro program-section__intro--center">
            @if($item->course_title)
                <h2 id="program-about-title">{{ $item->course_title }}</h2>
            @endif
            @if($item->course_desc)
                <p>{{ $item->course_desc }}</p>
            @endif
        </div>
    @endif

    @if(!empty($item->course_items))
        <div class="program-about__grid">
            @foreach($item->course_items as $index => $card)
                <article class="program-about-card">
                    <div class="program-about-card__icon">
                        <img src="{{ $icons[$index % count($icons)] }}" alt="">
                    </div>
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
