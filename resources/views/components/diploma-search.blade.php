<div class="diploma-search">
    <div class="diploma-search__card">
<div class="diploma-search__wrap">
        <h3 class="diploma-search__title">Поиск диплома</h3>
        <p class="diploma-search__hint">Введите номер диплома для проверки подлинности</p>

        @if($short_desc)
            <div class="short_desc desc">{!! $short_desc !!}</div>
        @endif

        @if($desc)
            <div class="desc">{!! $desc !!}</div>
        @endif
</div>
        <form method="GET" action="{{ route('resources.diplomas') }}">
            <div class="diploma-search__form-row">

                <div class="input-group">
                    <input
                        class="input-group__input"
                        type="text"
                        name="number"
                        value="{{ $number }}"
                        placeholder=" "
                        autocomplete="off"
                    >
                    <label class="input-group__label">Номер диплома</label>
                </div>

                <div class="diploma-search__actions">
                    <button class="btn btn-big" type="submit">Найти</button>
                    @if($searched)
                        <a class="btn btn_grey btn-big"
                           href="{{ route('resources.diplomas') }}">Сбросить</a>
                    @endif
                </div>

            </div>
        </form>

        @if($searched)

            @if($diploma)
                <div class="diploma-search__result">
                    <p class="diploma-search__result-label">Результат проверки</p>
                    <div class="diploma-search__result-rows">
                        <div class="diploma-search__result-row">
                            <span class="diploma-search__result-key">Номер диплома</span>
                            <span class="diploma-search__result-val">{{ $diploma->title }}</span>
                        </div>
                        <div class="diploma-search__result-row">
                            <span class="diploma-search__result-key">Владелец</span>
                            <span class="diploma-search__result-val">{{ $diploma->fio }}</span>
                        </div>
                        <div class="diploma-search__result-row">
                            <span class="diploma-search__result-key">Дисциплина</span>
                            <span class="diploma-search__result-val">{{ $diploma->discipline }}</span>
                        </div>
                        <div class="diploma-search__result-row">
                            <span class="diploma-search__result-key">Дата выдачи</span>
                            <span class="diploma-search__result-val">
                                {{ $diploma->issued_at?->format('d.m.Y') ?? '—' }}
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="diploma-search__not-found">
                    Диплом с номером <strong>{{ $number }}</strong> не найден в базе данных.
                </div>
            @endif

        @endif

    </div>
</div>
