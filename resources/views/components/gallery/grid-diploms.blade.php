@props([
    'items'  => [],
    'group'  => 'gallery',
])

@if(!empty($items))
    <div class="diplomas-grid">
        @foreach($items as $photo)
            @if(!empty($photo['image']))
                <figure class="diploma-card">
                    <a class="diploma-card__image"
                       href="{{ Storage::url($photo['image']) }}"
                       data-fancybox="{{ $group }}"
                       @if(!empty($photo['label'])) data-caption="{{ $photo['label'] }}" @endif>
                        <img loading="lazy"
                             src="{{ Storage::url($photo['image']) }}"
                             alt="{{ $photo['label'] ?? '' }}">
                    </a>
                    @if(!empty($photo['label']))
                        <figcaption>{{ $photo['label'] }}</figcaption>
                    @endif
                </figure>
            @endif
        @endforeach
    </div>
@endif
