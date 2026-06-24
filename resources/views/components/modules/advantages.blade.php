<section class="advantages" id="consulting">
    <div class="container advantages__grid">

        <div class="advantages__info">
            <h2>{{ $h2 }}</h2>
            @if($advDesc)<p>{{ $advDesc }}</p>@endif

            <div class="adv-cards">
                @foreach($advCards as $card)
                    <article>
                        <strong>{{ $card['value'] ?? '' }}</strong>
                        <p>{{ $card['text'] ?? '' }}</p>
                    </article>
                @endforeach
            </div>
        </div>

        <div class="advantages__media">
            <div class="advantages__background" data-fancybox="advantages-video" data-src="https://www.youtube.com/watch?v={{ $youtubeVideoId }}" style="background-image: url({{ Storage::url('/images/adv/video.jpg') }}); cursor:pointer;">
                <button
                    class="video-card video-card--image"
                    type="button"
                    aria-label="Смотреть видео о Высшей Школе Экономики"
                    data-video-src="https://www.youtube.com/embed/{{ $youtubeVideoId }}?autoplay=1"
                >
                    <div class="video-card__play"></div>
                </button>
            </div>
            <p class="advantages__rules">*Обязательно ознакомьтесь с <a href="{{ $rulesLink }}">Правилами обучения</a></p>
        </div>

    </div>
</section>
