@props(['title' => '', 'subtitle' => '', 'items' => []])

<section class="history-section" aria-labelledby="history-title">
    <div class="history-inner">
        <header class="history-header">
            <h2 id="history-title">{{ $title }}</h2>
            <p>{{ $subtitle }}</p>
        </header>

        <div class="history-timeline">
            @foreach($items as $i => $item)
                <article class="history-item{{ $loop->last ? ' history-item-last' : '' }}">
                    <div class="history-icon-wrap">
                        <img class="history-icon-image" src="{{ Storage::url('about/icons/16/' . ($i + 1) . '.png') }}" alt="" />
                    </div>
                    <div class="history-year">{{ $item['year'] ?? '' }}</div>
                    <div class="history-content">
                        <h3>{{ $item['title'] ?? '' }}</h3>
                        <p>{{ $item['text'] ?? '' }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
