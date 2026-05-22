<div class="content_page__diploma2">


    @if($item->desc)
        <div class="content_page__desc desc">
            {!! $item->desc !!}
        </div>
    @endif

        @if($item->html)
            <div class="content_page__html">
                {!! $item->html !!}
            </div>
        @endif


        @if(!empty($item->gallery))
            <x-gallery.grid-diploms :items="$item->gallery" />
        @endif


    @if($item->desc2)
        <div class="content_page__desc desc">
            {!! $item->desc2 !!}
        </div>
    @endif





    @if(!empty($item->files))
        <x-files.download :files="$item->files" />
    @endif



    <x-modules.faq :items="$item->faq ?? []" :page-items="$page->faq ?? []" />

</div>

@if($item->script)
    <script>{!! $item->script !!}</script>
@endif
