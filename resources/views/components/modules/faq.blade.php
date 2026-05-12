@props(['items' => [], 'pageItems' => []])
@php $faqItems = !empty($items) ? $items : $pageItems; @endphp

<section class="faq" id="faq">
    <div class="container faq__content">

        @if(!empty($faqItems))
            @foreach($faqItems as $block)
                @if(!empty($block['options']))
                    @if(!empty($block['title']))
                        <h2>{{ $block['title'] }}</h2>
                    @endif
                    <div class="faq-list">
                        @foreach($block['options'] as $index => $qa)
                            <details {{ $index === 0 ? 'open' : '' }}>
                                @if(!empty($qa['question']))
                                    <summary>{{ $qa['question'] }}</summary>
                                @endif
                                @if(!empty($qa['answer']))
                                    <div>{!! $qa['answer'] !!}</div>
                                @endif
                            </details>
                        @endforeach
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</section>
