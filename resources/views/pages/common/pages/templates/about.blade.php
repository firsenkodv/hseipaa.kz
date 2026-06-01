<div class="pad_t20">
<x-modules.about-banner />
</div>
<div class="page-wrapper">
<x-modules.about-advantages />
<x-modules.about-programs />
<x-modules.about-benefits />
<x-modules.about-history />
<x-modules.about-app />
<x-modules.about-platform />

<section class="seo-section about">
    <div class="seo-inner">
        @if($items->currentPage() === 1)

            @if($page->desc)
                <div class="desc">{!! $page->desc !!}</div>
            @endif
        @endif
    </div>
</section>

<x-modules.about-join />
</div>
