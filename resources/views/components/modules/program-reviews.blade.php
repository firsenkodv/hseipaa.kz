<section class="program-reviews">
<div class="program-reviews-shell">
    <div class="program-block program-reviews">
        <div class="program-reviews__header">
            <div class="program-section__intro">
                <h2>Отзывы клиентов</h2>
                <p>Стать востребованным профессионалом может каждый</p>
            </div>
            <div class="program-reviews__avatars">
                <img src="{{ Storage::url('images/img/review-author-1.png') }}" alt="" draggable="false" />
                <img src="{{ Storage::url('images/img/review-author-2.png') }}" alt="" draggable="false" />
                <img src="{{ Storage::url('images/img/review-author-3.png') }}" alt="" draggable="false" />
                <img src="{{ Storage::url('images/img/review-author-4.png') }}" alt="" draggable="false" />
                <img src="{{ Storage::url('images/img/review-author-1.png') }}" alt="" draggable="false" />
                <button class="program-reviews__arrow" type="button" aria-label="Следующий отзыв" data-reviews-next>
                    <img class="program-reviews__arrow-full" src="{{ Storage::url('images/img/review-arrow-custom.svg') }}" alt="" draggable="false" />
                </button>
            </div>
        </div>

        <div class="program-reviews__viewport" data-reviews-viewport>
            <div class="program-reviews__track">
                <article class="program-review-card" data-review-index="0">
                    <div class="program-review-card__video">
                        <img class="program-review-card__cover" src="{{ Storage::url('images/img/review-card-1.jpg') }}" alt="" draggable="false" />
                        <button class="program-review-card__play" type="button" aria-label="Смотреть отзыв">
                            <img src="{{ Storage::url('images/img/review-play.svg') }}" alt="" draggable="false" />
                        </button>
                    </div>
                    <div class="program-review-card__author">
                        <img src="{{ Storage::url('images/img/review-author-1.png') }}" alt="" draggable="false" />
                        <div>
                            <strong>Данияр Сейітов</strong>
                            <span>Руководитель проекта</span>
                        </div>
                    </div>
                </article>

                <article class="program-review-card program-review-card--gradient" data-review-index="1">
                    <div class="program-review-card__video">
                        <img class="program-review-card__cover" src="{{ Storage::url('images/img/review-card-2.jpg') }}" alt="" draggable="false" />
                        <button class="program-review-card__play" type="button" aria-label="Смотреть отзыв">
                            <img src="{{ Storage::url('images/img/review-play.svg') }}" alt="" draggable="false" />
                        </button>
                    </div>
                    <div class="program-review-card__author">
                        <img src="{{ Storage::url('images/img/review-author-2.png') }}" alt="" draggable="false" />
                        <div>
                            <strong>Арман Ашимов</strong>
                            <span>Инженер-программист</span>
                        </div>
                    </div>
                </article>

                <article class="program-review-card" data-review-index="2">
                    <div class="program-review-card__video">
                        <img class="program-review-card__cover" src="{{ Storage::url('images/img/review-card-3.jpg') }}" alt="" draggable="false" />
                        <button class="program-review-card__play" type="button" aria-label="Смотреть отзыв">
                            <img src="{{ Storage::url('images/img/review-play.svg') }}" alt="" draggable="false" />
                        </button>
                    </div>
                    <div class="program-review-card__author">
                        <img src="{{ Storage::url('images/img/review-author-3.png') }}" alt="" draggable="false" />
                        <div>
                            <strong>Аружан Нұрсұлтан</strong>
                            <span>Дизайнер пользовательского опыта</span>
                        </div>
                    </div>
                </article>

                <article class="program-review-card" data-review-index="3">
                    <div class="program-review-card__video">
                        <img class="program-review-card__cover" src="{{ Storage::url('images/img/review-card-4.jpg') }}" alt="" draggable="false" />
                        <button class="program-review-card__play" type="button" aria-label="Смотреть отзыв">
                            <img src="{{ Storage::url('images/img/review-play.svg') }}" alt="" draggable="false" />
                        </button>
                    </div>
                    <div class="program-review-card__author">
                        <img src="{{ Storage::url('images/img/review-author-4.png') }}" alt="" draggable="false" />
                        <div>
                            <strong>Ерлан Тұрар</strong>
                            <span>Аналитик данных</span>
                        </div>
                    </div>
                </article>

                <article class="program-review-card" data-review-index="4">
                    <div class="program-review-card__video">
                        <img class="program-review-card__cover" src="{{ Storage::url('images/img/review-card-2.jpg') }}" alt="" draggable="false" />
                        <button class="program-review-card__play" type="button" aria-label="Смотреть отзыв">
                            <img src="{{ Storage::url('images/img/review-play.svg') }}" alt="" draggable="false" />
                        </button>
                    </div>
                    <div class="program-review-card__author">
                        <img src="{{ Storage::url('images/img/review-author-1.png') }}" alt="" draggable="false" />
                        <div>
                            <strong>Айгерим Садыкова</strong>
                            <span>Кредитный аналитик</span>
                        </div>
                    </div>
                </article>
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
    const reviews = [
        {
            cover: "/storage/images/img/review-card-1.jpg",
            videoUrl: "https://www.youtube.com/embed/9ofghOY94-4?autoplay=1&rel=0",
            name: "Данияр Сейітов",
        },
        {
            cover: "/storage/images/img/review-card-2.jpg",
            videoUrl: "https://www.youtube.com/embed/9ofghOY94-4?autoplay=1&rel=0",
            name: "Арман Ашимов",
        },
        {
            cover: "/storage/images/img/review-card-3.jpg",
            videoUrl: "https://www.youtube.com/embed/9ofghOY94-4?autoplay=1&rel=0",
            name: "Аружан Нұрсұлтан",
        },
        {
            cover: "/storage/images/img/review-card-4.jpg",
            videoUrl: "https://www.youtube.com/embed/9ofghOY94-4?autoplay=1&rel=0",
            name: "Ерлан Тұрар",
        },
        {
            cover: "/storage/images/img/review-card-2.jpg",
            videoUrl: "https://www.youtube.com/embed/9ofghOY94-4?autoplay=1&rel=0",
            name: "Айгерим Садыкова",
        },
    ];

    const viewport = document.querySelector("[data-reviews-viewport]");
    const nextButton = document.querySelector("[data-reviews-next]");
    const modal = document.querySelector("[data-review-modal]");
    const modalImage = document.querySelector("[data-review-modal-image]");
    const modalVideo = document.querySelector("[data-review-modal-video]");
    const modalCaption = document.querySelector("[data-review-modal-caption]");
    const modalPlay = document.querySelector("[data-review-modal-play]");
    let currentVideoUrl = "";

    nextButton?.addEventListener("click", () => {
        if (!viewport) {
            return;
        }

        const firstCard = viewport.querySelector(".program-review-card");
        const step = firstCard ? firstCard.getBoundingClientRect().width + 24 : 340;
        const maxScroll = viewport.scrollWidth - viewport.clientWidth;
        const target = viewport.scrollLeft + step >= maxScroll - 4 ? 0 : viewport.scrollLeft + step;

        viewport.scrollTo({
            left: target,
            behavior: "smooth",
        });
    });

    if (viewport) {
        let isPointerDown = false;
        let didDrag = false;
        let openedFromPointer = false;
        let pressedCard = null;
        let startX = 0;
        let startScrollLeft = 0;

        viewport.addEventListener("pointerdown", (event) => {
            isPointerDown = true;
            didDrag = false;
            pressedCard = event.target.closest(".program-review-card");
            startX = event.clientX;
            startScrollLeft = viewport.scrollLeft;
            viewport.setPointerCapture(event.pointerId);
        });

        viewport.addEventListener("pointermove", (event) => {
            if (!isPointerDown) {
                return;
            }

            const distance = event.clientX - startX;
            if (Math.abs(distance) > 5) {
                didDrag = true;
                viewport.classList.add("is-dragging");
                viewport.scrollLeft = startScrollLeft - distance;
            }
        });

        const stopDragging = (event, canOpenCard = false) => {
            if (!isPointerDown) {
                return;
            }

            const shouldOpenCard = canOpenCard && !didDrag && pressedCard;
            isPointerDown = false;
            viewport.classList.remove("is-dragging");

            if (viewport.hasPointerCapture(event.pointerId)) {
                viewport.releasePointerCapture(event.pointerId);
            }

            if (shouldOpenCard) {
                openedFromPointer = true;
                openModal(Number(pressedCard.dataset.reviewIndex || 0));
                window.setTimeout(() => {
                    openedFromPointer = false;
                }, 0);
            }

            pressedCard = null;
        };

        viewport.addEventListener("pointerup", (event) => stopDragging(event, true));
        viewport.addEventListener("pointercancel", stopDragging);
        viewport.addEventListener("pointerleave", stopDragging);

        viewport.addEventListener("click", (event) => {
            if (openedFromPointer || didDrag) {
                return;
            }

            const card = event.target.closest(".program-review-card");
            if (card) {
                openModal(Number(card.dataset.reviewIndex || 0));
            }
        });
    }

    const openModal = (index) => {
        const review = reviews[index];
        if (!modal || !modalImage || !modalVideo || !modalCaption || !modalPlay || !review) {
            return;
        }

        currentVideoUrl = review.videoUrl || "";
        modalImage.src = review.cover;
        modalImage.alt = review.name || "Отзыв";
        modalImage.hidden = false;
        modalVideo.src = "";
        modalVideo.hidden = true;
        modalCaption.textContent = (review.name || "Отзыв").toUpperCase();
        modalCaption.hidden = false;
        modalPlay.hidden = !currentVideoUrl;

        modal.hidden = false;
        requestAnimationFrame(() => {
            modal.classList.add("is-open");
            document.body.classList.add("is-review-modal-open");
        });
    };

    const closeModal = () => {
        if (!modal || !modalVideo) {
            return;
        }

        modal.classList.remove("is-open");
        document.body.classList.remove("is-review-modal-open");
        modalVideo.src = "";

        window.setTimeout(() => {
            modal.hidden = true;
        }, 220);
    };

    modalPlay?.addEventListener("click", (event) => {
        event.preventDefault();
        event.stopPropagation();

        if (!currentVideoUrl || !modalVideo) {
            return;
        }

        modalVideo.src = currentVideoUrl;
        modalVideo.hidden = false;
        modalPlay.hidden = true;
    });

    modal?.addEventListener("click", (event) => {
        if (event.target.closest("[data-review-close]")) {
            closeModal();
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && modal && !modal.hidden) {
            closeModal();
        }
    });

</script>
