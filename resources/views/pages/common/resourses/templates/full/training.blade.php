<div class="content_page__training">
    <x-modules.program-about :item="$item" />

    <x-modules.program-benefits :item="$item" />

    <x-modules.program-advantages :item="$item" />
</div>
    <x-modules.actions_strip />
<div class="content_page__training">
    <x-modules.program-requirements :item="$item" />
    <x-modules.faq :items="$item->faq ?? []" :page-items="$page->faq ?? []" />
</div>

@if($item->script)
    <script>{!! $item->script !!}</script>
@endif
