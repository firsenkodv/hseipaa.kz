@props(['item'])

@php
    $icons = [
        asset('images/program/advantage-format.svg'),
        asset('images/program/advantage-materials.svg'),
        asset('images/program/advantage-practice.svg'),
        asset('images/program/advantage-support.svg'),
        asset('images/program/advantage-testing.svg'),
        asset('images/program/advantage-certificate.svg'),
    ];
@endphp

@if($item->adv_title || !empty($item->adv_items))
<section class="program-block advantages-title" aria-labelledby="advantages-title">
    @if($item->adv_title || $item->adv_desc)
        <div class="program-section__intro program-section__intro--center">
            @if($item->adv_title)
                <h2 id="advantages-title">{{ $item->adv_title }}</h2>
            @endif
            @if($item->adv_desc)
                <p>{{ $item->adv_desc }}</p>
            @endif
        </div>
    @endif

    @if(!empty($item->adv_items))
        <div class="program-advantages__grid">
            @foreach($item->adv_items as $index => $card)
                <article class="program-advantage-card">
                    <div class="program-advantage-card__icon">
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
