<div class="diploma-page">

    {{-- Hero --}}
    <section class="diploma-hero">
        <div class="container">
            <div class="diploma-hero__inner">

                <div class="diploma-hero__copy">
                    @if($title)
                        <h1>{{ $title }}</h1>
                    @endif
                    @if($short_desc)
                        <div>{!! $short_desc !!}</div>
                    @endif
                    @if($desc)
                        <div>{!! $desc !!}</div>
                    @endif
                </div>

                <form class="diploma-search-form" method="GET" action="">
                    <div class="diploma-search-form__field">
                        <label for="diploma-number">Номер диплома</label>
                        <input
                            id="diploma-number"
                            type="text"
                            name="number"
                            value="{{ $number }}"
                            placeholder="Например, HSE-2026-00125"
                            autocomplete="off"
                        >
                    </div>
                    <div class="diploma-search-form__actions">
                        <button type="submit" class="diploma-search-form__submit">Найти диплом</button>
                        @if($searched)
                            <a class="diploma-search-form__reset" href="{{ request()->url() }}">Очистить</a>
                        @endif
                    </div>
                </form>

            </div>
        </div>
    </section>

    {{-- Results --}}
    <section class="diploma-results">
        <div class="">

            @if(!$searched)
                <div class="diploma-results__empty">
                    <h2>Результаты поиска</h2>
                    <p>Введите номер диплома, чтобы проверить документ в базе HSEIPAA.</p>
                </div>

            @elseif($diploma)
                <div class="diploma-results__list">
                    <div class="diploma-card">
                        <div class="diploma-card__head">
                            <div>
                                <h3>{{ $diploma->title }}</h3>
                                @if($diploma->discipline)
                                    <p>{{ $diploma->discipline }}</p>
                                @endif
                            </div>
                            <span class="diploma-card__status">Подтверждён</span>
                        </div>
                        <div class="diploma-card__grid">
                            <div class="diploma-card__item">
                                <span>Владелец</span>
                                <strong>{{ $diploma->fio ?? '—' }}</strong>
                            </div>
                            <div class="diploma-card__item">
                                <span>Дисциплина</span>
                                <strong>{{ $diploma->discipline ?? '—' }}</strong>
                            </div>
                            <div class="diploma-card__item">
                                <span>Дата выдачи</span>
                                <strong>{{ $diploma->issued_at?->format('d.m.Y') ?? '—' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <div class="diploma-results__not-found">
                    <h3>Документ не найден</h3>
                    <p>
                        Диплом с номером <strong>{{ $number }}</strong> не найден в базе данных.
                        Проверьте написание. Если документ выдан недавно — отправьте скан на
                        <a href="mailto:info@hseipaa.kz">info@hseipaa.kz</a>.
                    </p>
                </div>
            @endif

        </div>
    </section>

</div>
