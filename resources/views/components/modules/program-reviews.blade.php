@props(['page' => null, 'reviewsKey' => null])

@php
    if ($reviewsKey === 'consulting') {
        $title   = $page?->konsalt_reviews_title ?? 'Отзывы клиентов';
        $desc    = $page?->konsalt_reviews_desc  ?? 'Стать востребованным профессионалом может каждый';
        $reviews = $page?->konsalt_reviews_items ?? [];
    } else {
        $title   = $page?->edu_reviews_title ?? 'Отзывы клиентов';
        $desc    = $page?->edu_reviews_desc  ?? 'Стать востребованным профессионалом может каждый';
        $reviews = $page?->edu_reviews_items ?? [];
    }

    if (empty($reviews)) {
        $reviews = [
            ['name' => 'Данияр Сейітов',    'role' => 'Руководитель проекта',            'cover' => 'images/img/review-card-1.jpg', 'avatar' => 'images/img/review-author-1.png', 'video_url' => 'https://www.youtube.com/embed/9ofghOY94-4?autoplay=1&rel=0'],
            ['name' => 'Арман Ашимов',       'role' => 'Инженер-программист',             'cover' => 'images/img/review-card-2.jpg', 'avatar' => 'images/img/review-author-2.png', 'video_url' => 'https://www.youtube.com/embed/9ofghOY94-4?autoplay=1&rel=0'],
            ['name' => 'Аружан Нұрсұлтан',  'role' => 'Дизайнер пользовательского опыта','cover' => 'images/img/review-card-3.jpg', 'avatar' => 'images/img/review-author-3.png', 'video_url' => 'https://www.youtube.com/embed/9ofghOY94-4?autoplay=1&rel=0'],
            ['name' => 'Ерлан Тұрар',        'role' => 'Аналитик данных',                 'cover' => 'images/img/review-card-4.jpg', 'avatar' => 'images/img/review-author-4.png', 'video_url' => 'https://www.youtube.com/embed/9ofghOY94-4?autoplay=1&rel=0'],
            ['name' => 'Айгерим Садыкова',   'role' => 'Кредитный аналитик',              'cover' => 'images/img/review-card-2.jpg', 'avatar' => 'images/img/review-author-1.png', 'video_url' => 'https://www.youtube.com/embed/9ofghOY94-4?autoplay=1&rel=0'],
        ];
    }
@endphp

<section class="program-reviews">
<div class="program-reviews-shell">
    <div class="program-block program-reviews">
        <div class="program-reviews__header">
            <div class="program-section__intro">
                <h2>{{ $title }}</h2>
                @if($desc)<p>{{ $desc }}</p>@endif
            </div>
            <div class="program-reviews__avatars">
                @foreach($reviews as $review)
                    <img src="{{ Storage::url($review['avatar'] ?? 'images/img/review-author-1.png') }}" alt="" draggable="false" />
                @endforeach
                <button class="program-reviews__arrow" type="button" aria-label="Следующий отзыв" data-reviews-next>
                    <img class="program-reviews__arrow-full" src="{{ Storage::url('images/img/review-arrow-custom.svg') }}" alt="" draggable="false" />
                </button>
            </div>
        </div>

        <div class="program-reviews__viewport" data-reviews-viewport>
            <div class="program-reviews__track">
                @foreach($reviews as $i => $review)
                    <article class="program-review-card{{ $i === 1 ? ' program-review-card--gradient' : '' }}" data-review-index="{{ $i }}">
                        <div class="program-review-card__video">
                            <img class="program-review-card__cover" src="{{ Storage::url($review['cover'] ?? 'images/img/review-card-1.jpg') }}" alt="" draggable="false" />
                            <button class="program-review-card__play" type="button" aria-label="Смотреть отзыв">
                                <img src="{{ Storage::url('images/img/review-play.svg') }}" alt="" draggable="false" />
                            </button>
                        </div>
                        <div class="program-review-card__author">
                            <img src="{{ Storage::url($review['avatar'] ?? 'images/img/review-author-1.png') }}" alt="" draggable="false" />
                            <div>
                                <strong>{{ $review['name'] ?? '' }}</strong>
                                <span>{{ $review['role'] ?? '' }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="program-review-modal" data-review-modal hidden>
    <button class="program-review-modal__backdrop" type="button" data-review-close aria-label="Закрыть отзыв"></button>
    <div class="program-review-modal__dialog" role="dialog" aria-modal="true" aria-label="Отзыв слушателя">
        <div class="program-review-modal__card">
            <iframe
                class="program-review-modal__video"
                src=""
                title="Видео отзыв"
                allow="autoplay; fullscreen; picture-in-picture"
                allowfullscreen
                data-review-modal-video
                hidden
            ></iframe>
            <img class="program-review-modal__image" src="" alt="" data-review-modal-image hidden />
            <p class="program-review-modal__caption" data-review-modal-caption hidden></p>
            <button class="program-review-modal__play" type="button" data-review-modal-play aria-label="Смотреть видео отзыв">
                <img src="{{ Storage::url('images/img/review-play.svg') }}" alt="" draggable="false" />
            </button>
        </div>
        <button class="program-review-modal__close" type="button" data-review-close aria-label="Закрыть отзыв">
            <span></span>
        </button>
    </div>
</div>
</section>

<script>
    const reviews = @json(array_values(array_map(fn($r) => [
        'cover'    => '/storage/' . ($r['cover']    ?? 'images/img/review-card-1.jpg'),
        'videoUrl' => $r['video_url'] ?? '',
        'name'     => $r['name']      ?? '',
    ], $reviews)));

    const viewport = document.querySelector("[data-reviews-viewport]");
    const nextButton = document.querySelector("[data-reviews-next]");
    const modal = document.querySelector("[data-review-modal]");
    const modalImage = document.querySelector("[data-review-modal-image]");
    const modalVideo = document.querySelector("[data-review-modal-video]");
    const modalCaption = document.querySelector("[data-review-modal-caption]");
    const modalPlay = document.querySelector("[data-review-modal-play]");
    let currentVideoUrl = "";

    nextButton?.addEventListener("click", () => {
        if (!viewport) return;
        const firstCard = viewport.querySelector(".program-review-card");
        const step = firstCard ? firstCard.getBoundingClientRect().width + 24 : 340;
        const maxScroll = viewport.scrollWidth - viewport.clientWidth;
        const target = viewport.scrollLeft + step >= maxScroll - 4 ? 0 : viewport.scrollLeft + step;
        viewport.scrollTo({ left: target, behavior: "smooth" });
    });

    if (viewport) {
        let isPointerDown = false, didDrag = false, openedFromPointer = false, pressedCard = null, startX = 0, startScrollLeft = 0;

        viewport.addEventListener("pointerdown", (e) => {
            isPointerDown = true; didDrag = false;
            pressedCard = e.target.closest(".program-review-card");
            startX = e.clientX; startScrollLeft = viewport.scrollLeft;
            viewport.setPointerCapture(e.pointerId);
        });

        viewport.addEventListener("pointermove", (e) => {
            if (!isPointerDown) return;
            const d = e.clientX - startX;
            if (Math.abs(d) > 5) { didDrag = true; viewport.classList.add("is-dragging"); viewport.scrollLeft = startScrollLeft - d; }
        });

        const stopDragging = (e, canOpen = false) => {
            if (!isPointerDown) return;
            const shouldOpen = canOpen && !didDrag && pressedCard;
            isPointerDown = false;
            viewport.classList.remove("is-dragging");
            if (viewport.hasPointerCapture(e.pointerId)) viewport.releasePointerCapture(e.pointerId);
            if (shouldOpen) { openedFromPointer = true; openModal(Number(pressedCard.dataset.reviewIndex || 0)); window.setTimeout(() => { openedFromPointer = false; }, 0); }
            pressedCard = null;
        };

        viewport.addEventListener("pointerup", (e) => stopDragging(e, true));
        viewport.addEventListener("pointercancel", stopDragging);
        viewport.addEventListener("pointerleave", stopDragging);

        viewport.addEventListener("click", (e) => {
            if (openedFromPointer || didDrag) return;
            const card = e.target.closest(".program-review-card");
            if (card) openModal(Number(card.dataset.reviewIndex || 0));
        });
    }

    const openModal = (index) => {
        const review = reviews[index];
        if (!modal || !modalImage || !modalVideo || !modalCaption || !modalPlay || !review) return;
        currentVideoUrl = review.videoUrl || "";
        modalImage.src = review.cover; modalImage.alt = review.name || "Отзыв"; modalImage.hidden = false;
        modalVideo.src = ""; modalVideo.hidden = true;
        modalCaption.textContent = (review.name || "Отзыв").toUpperCase(); modalCaption.hidden = false;
        modalPlay.hidden = !currentVideoUrl;
        modal.hidden = false;
        requestAnimationFrame(() => { modal.classList.add("is-open"); document.body.classList.add("is-review-modal-open"); });
    };

    const closeModal = () => {
        if (!modal || !modalVideo) return;
        modal.classList.remove("is-open"); document.body.classList.remove("is-review-modal-open");
        modalVideo.src = "";
        window.setTimeout(() => { modal.hidden = true; }, 220);
    };

    modalPlay?.addEventListener("click", (e) => {
        e.preventDefault(); e.stopPropagation();
        if (!currentVideoUrl || !modalVideo) return;
        modalVideo.src = currentVideoUrl; modalVideo.hidden = false; modalPlay.hidden = true;
    });

    modal?.addEventListener("click", (e) => { if (e.target.closest("[data-review-close]")) closeModal(); });
    document.addEventListener("keydown", (e) => { if (e.key === "Escape" && modal && !modal.hidden) closeModal(); });
</script>
