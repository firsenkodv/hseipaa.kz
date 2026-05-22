<div class="content_page__diploma2">
    @if($page->title)
        <h1 class="h1">{{ $page->title }}</h1>
    @endif
    @if($page->short_desc)
        <div class="short_desc desc">{!!  $page->short_desc  !!}</div>
    @endif
        <br>
@if(!empty($page->gallery))
    <x-gallery.grid-diploms :items="$page->gallery" />
@endif

@if($items->currentPage() === 1)
            <br>
    @if($page->desc)
        <div class="desc">{!! $page->desc !!}</div>
    @endif
@endif


</div>
