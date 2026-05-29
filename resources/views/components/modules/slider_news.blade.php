<section class="block block_3">
    <div class="flex_block flex_3">

        {{-- СЛАЙДЕР --}}
        <div class="block_3_slider">
            <div class="swiper block3-swiper">
                <div class="swiper-wrapper">

                    @foreach($slides as $slide)
                    @php $sid = 'slide-' . $loop->index; @endphp
                    <style>
                        #{{ $sid }} { background-image: url('{{ $slide->bg }}'); }
                        @if($slide->bg_mobile)
                        @media (max-width: 794px) {
                            #{{ $sid }} { background-image: url('{{ $slide->bg_mobile }}'); }
                        }
                        @endif
                    </style>
                    <div class="swiper-slide">
                        <{{ $slide->tag }}
                            id="{{ $sid }}"
                            class="slide-bg"
                            @if($slide->href) href="{{ $slide->href }}" @endif
                        >
                            @if($slide->title || $slide->desc || $slide->html)
                            <div class="slide-content">
                                @if($slide->title)
                                    <h2 class="slide-title">{!! $slide->title !!}</h2>
                                @endif
                                @if($slide->desc)
                                    <p class="slide-desc">{!! $slide->desc !!}</p>
                                @endif
                                @if($slide->html)
                                    <div class="slide-html">{!! $slide->html !!}</div>
                                @endif
                            </div>
                            @endif
                        </{{ $slide->tag }}>
                    </div>
                    @endforeach

                </div>

                <button class="swiper-button-prev" aria-label="Предыдущий слайд"></button>
                <button class="swiper-button-next" aria-label="Следующий слайд"></button>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        {{-- НОВОСТИ --}}
        <div class="block_3_news">
            <div class="scroll-block block_mod_news">

                @foreach($newsList as $item)
                <div class="bl_one_new">
                    <div class="teaser_title_600">
                        <h4><a class="color_282828" href="{{ route('resources.news.show', $item->slug) }}">{!! $item->title !!}</a></h4>
                    </div>
                    <div class="teaser_shortdesc desc_static">
                        <a href="{{ route('resources.news.show', $item->slug) }}" class="desc_p">{!! $item->short_desc !!}</a>
                    </div>
                </div>
                @if(!$loop->last)
                <div class="new_line"></div>
                @endif
                @endforeach

            </div>
        </div>

    </div>
</section>
