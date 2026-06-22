@props(['items' => []])

<section class="education-benefits-section" aria-labelledby="education-benefits-title">
    <div class="education-benefits-inner">
        <header class="education-benefits-header">
            <h2 id="education-benefits-title">Наши преимущества</h2>
            <p>Что делает наш образовательный центр особенным</p>
        </header>

        <div class="education-benefits-grid">
            @foreach($items as $i => $item)
                <article class="education-benefit-card">
                    <span class="education-benefit-number">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}.</span>
                    <h3>{{ $item['title'] ?? '' }}</h3>
                    <p>{{ $item['text'] ?? '' }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
