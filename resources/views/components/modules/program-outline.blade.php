@props(['item'])

@php
    $statIcons = [
        asset('images/program/outline-book.svg'),
        asset('images/program/outline-clock.svg'),
        asset('images/program/outline-file.svg'),
    ];
    $iconPlus  = asset('images/program/outline-plus.svg');
    $iconClose = asset('images/program/outline-close.svg');
@endphp

@if($item->outline_title || !empty($item->outline_modules))
<section id="program-outline" class="program-block program-outline-block" aria-labelledby="outline-title">

    <div class="program-outline-block__overview">
        @if($item->outline_title || $item->outline_desc)
            <div class="program-section__intro">
                @if($item->outline_title)
                    <h2 id="outline-title">{{ $item->outline_title }}</h2>
                @endif
                @if($item->outline_desc)
                    <p>{{ $item->outline_desc }}</p>
                @endif
            </div>
        @endif

        @if(!empty($item->outline_stats))
            <div class="program-outline-block__stats">
                @foreach($item->outline_stats as $i => $stat)
                    @if(!empty($stat['value']) || !empty($stat['label']))
                        <div class="program-outline-stat">
                            @if(isset($statIcons[$i]))
                                <img src="{{ $statIcons[$i] }}" alt="">
                            @endif
                            <div>
                                @if(!empty($stat['value']))
                                    <strong>{{ $stat['value'] }}</strong>
                                @endif
                                @if(!empty($stat['label']))
                                    <span>{{ $stat['label'] }}</span>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>

    @if(!empty($item->outline_modules))
        <div class="program-outline-block__modules">
            @foreach($item->outline_modules as $index => $module)
                @if(!empty($module['title']))
                    <article class="program-module {{ $index === 0 ? 'is-active' : '' }}">
                        <button
                            class="program-module__header"
                            type="button"
                            data-icon-plus="{{ $iconPlus }}"
                            data-icon-close="{{ $iconClose }}"
                        >
                            <div class="program-module__heading">
                                @if(!empty($module['label']))
                                    <span>{{ $module['label'] }}</span>
                                @endif
                                <h3>{{ $module['title'] }}</h3>
                            </div>
                            <img src="{{ $index === 0 ? $iconClose : $iconPlus }}" alt="">
                        </button>

                        @if(!empty($module['items']))
                            <ul class="program-module__list">
                                @foreach($module['items'] as $point)
                                    @if(!empty($point['text']))
                                        <li>{{ $point['text'] }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </article>
                @endif
            @endforeach
        </div>
    @endif

</section>
@endif
