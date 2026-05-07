/columns/
<div class="columns">
    @foreach($items as $item)
        <div class="column-item">{{ $item->title }}</div>
    @endforeach
</div>
