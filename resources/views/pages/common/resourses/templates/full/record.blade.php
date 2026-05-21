@if($item->title)
    <h1 class="h1">{{ $item->title }}</h1>
@endif
@if($item->subtitle)
    <div class="content_page__subtitle">{{ $item->subtitle }}</div>
@endif
@if($item->desc)
    <div class="desc">{!! $item->desc !!}</div>
@endif
<br>
<button class="btn btn-big open-fancybox" data-form="record_me">
    Записаться на курс
</button>


