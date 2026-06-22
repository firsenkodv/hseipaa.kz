<div class="pad_t20">
<x-modules.about-banner
    :title="$page->banner_title ?? ''"
    :subtitle="$page->banner_subtitle ?? ''"
    :btn1="$page->banner_btn1 ?? 'Начать обучение'"
    :btn2="$page->banner_btn2 ?? 'Получить консультацию'"
    :quote="$page->banner_quote ?? ''"
    :author-name="$page->banner_author_name ?? ''"
    :author-role="$page->banner_author_role ?? ''"
    :banner-desktop="$page->banner_desktop ?? 'about/banner.jpg'"
    :banner-mobile="$page->banner_mobile ?? 'about/banner2.png'"
/>
</div>
<div class="page-wrapper">
<x-modules.about-advantages :advantages="$page->advantages ?? []" />
<x-modules.about-programs />
<x-modules.about-benefits :items="$page->benefits ?? []" />
<x-modules.about-history
    :title="$page->history_title ?? ''"
    :subtitle="$page->history_subtitle ?? ''"
    :items="$page->history_items ?? []"
/>
<x-modules.about-app
    :title="$page->app_title ?? ''"
    :desc="$page->app_desc ?? ''"
    :app-store-url="$page->app_store_url ?? '#'"
    :app-google-url="$page->app_google_url ?? '#'"
/>
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
