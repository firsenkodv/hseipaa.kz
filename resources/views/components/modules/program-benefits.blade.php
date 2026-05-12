@props(['item'])

@if($item->get_title || !empty($item->get_items))
<section class="program-block program-block--green" aria-labelledby="benefits-title">
    @if($item->get_title)
        <div class="program-section__intro program-section__intro--center">
            <h2 id="benefits-title">{{ $item->get_title }}</h2>
        </div>
    @endif

    @if(!empty($item->get_items))
        <div class="program-benefits__grid">
            @foreach($item->get_items as $benefit)
                @if(!empty($benefit['name']))
                    <div class="program-benefit-item">
                        <span class="program-check-icon">
                            <img src="{{ asset('images/program/benefit-check.svg') }}" alt="">
                        </span>
                        <span>{{ $benefit['name'] }}</span>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</section>
@endif
