@props(['item'])

@if($item->aud_title || !empty($item->aud_items))
<section class="program-block program-block--green audience" aria-labelledby="audience-title">
    @if($item->aud_title)
        <div class="program-section__intro program-section__intro--center">
            <h2 id="audience-title">{{ $item->aud_title }}</h2>
        </div>
    @endif

    @if(!empty($item->aud_items))
        <div class="program-benefits__grid">
            @foreach($item->aud_items as $chip)
                @if(!empty($chip['name']))
                    <div class="program-benefit-item">
                        <span class="program-check-icon">
                            <img src="{{ asset('images/program/benefit-check.svg') }}" alt="">
                        </span>
                        <span>{{ $chip['name'] }}</span>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</section>
@endif
