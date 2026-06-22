@props(['advantages' => []])

@php
$icons = [
    [
        'color' => 'blue',
        'svg'   => '<path d="M16 21v-2.1a4.3 4.3 0 0 0-4.3-4.3H6.4a4.3 4.3 0 0 0-4.3 4.3V21"></path><circle cx="9" cy="7" r="3.8"></circle><path d="M22 21v-2a4.1 4.1 0 0 0-3-3.9"></path><path d="M16.2 3.2a3.8 3.8 0 0 1 0 7.4"></path>',
    ],
    [
        'color' => 'purple',
        'svg'   => '<path d="m2.5 8 9.5-4 9.5 4-9.5 4-9.5-4Z"></path><path d="M6.5 10v4.6c0 1.9 2.5 3.4 5.5 3.4s5.5-1.5 5.5-3.4V10"></path><path d="M21.5 8v5"></path>',
    ],
    [
        'color' => 'green',
        'svg'   => '<circle cx="12" cy="8" r="5"></circle><path d="M8.7 12.1 7.4 21l4.6-2.7 4.6 2.7-1.3-8.9"></path>',
    ],
    [
        'color' => 'orange',
        'svg'   => '<path d="M3.5 21h17"></path><path d="M6 21V5.8A1.8 1.8 0 0 1 7.8 4h5.4A1.8 1.8 0 0 1 15 5.8V21"></path><path d="M15 9h2.8A2.2 2.2 0 0 1 20 11.2V21"></path><path d="M9 8h3"></path><path d="M9 12h3"></path><path d="M9 16h3"></path>',
    ],
    [
        'color' => 'pink',
        'svg'   => '<path d="m3 16 5.5-5.5 4 4L21 6"></path><path d="M15 6h6v6"></path>',
    ],
    [
        'color' => 'indigo',
        'svg'   => '<path d="M8 3h8"></path><path d="M8 21h8"></path><path d="M10 3v4.2c0 1.1.7 2.1 1.7 2.6l.3.2-.3.2a4.6 4.6 0 0 0-1.7 3.6V21"></path><path d="M14 3v4.2c0 1.1-.7 2.1-1.7 2.6l-.3.2.3.2a4.6 4.6 0 0 1 1.7 3.6V21"></path><path d="M9.8 15h4.4"></path>',
    ],
];
@endphp

<section class="advantages-section" aria-label="Преимущества">
    <div class="advantages-grid">
        @foreach($advantages as $i => $item)
            @php $icon = $icons[$i % count($icons)]; @endphp
            <article class="advantage-card">
                <div class="advantage-icon advantage-icon-{{ $icon['color'] }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true">{!! $icon['svg'] !!}</svg>
                </div>
                <p class="advantage-number">{{ $item['number'] ?? '' }}</p>
                <p class="advantage-text">{{ $item['text'] ?? '' }}</p>
            </article>
        @endforeach
    </div>
</section>
