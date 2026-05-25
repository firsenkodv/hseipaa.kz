<x-modules.program-hero :item="$item"/>

<div class="content_page__training">
    <x-modules.program-about :item="$item"/>
    <x-modules.program-benefits :item="$item"/>
    <x-modules.program-advantages :item="$item"/>
    <x-modules.program-requirements :item="$item"/>
    <x-modules.program-audience :item="$item"/>

</div>
<div class="content_page__training">

    <x-modules.program-outline :item="$item"/>
    <x-modules.program-price :item="$item"/>
    <x-modules.program-reviews/>
    <div class="block pad_b32">
    <x-modules.about-platform />
    </div>
    <x-modules.faq :items="$item->faq ?? []" :page-items="$page->faq ?? []"/>
    <div class="pad_t32">
    <x-modules.program-price :item="$item"/>
    </div>

</div>
<div class="block pad_t20">

    @if($item->desc)
        <div class="content_page__desc desc">
            {!! $item->desc !!}
        </div>
    @endif
    <div class="modules-about-join-wrap pad_t20">
        <x-modules.about-join
        title="Не знаете, какую программу выбрать?"
        desc="Наши специалисты помогут подобрать программу обучения под ваши цели и ответят на все вопросы. Консультация бесплатная!"
        />

    </div>

</div>

@if($item->script)
    <script>{!! $item->script !!}</script>
@endif
