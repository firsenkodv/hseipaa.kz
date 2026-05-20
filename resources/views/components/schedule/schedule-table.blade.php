@if(!empty($courses))
<section class="schedule-table-section"
         data-month-filter-url="{{ route('schedule.filterByMonth', $item->slug) }}">

    @if(!empty($months))
    <div class="schedule-month-filter">
        <button class="schedule-month-filter__btn" data-schedule-month="all" type="button">Все</button>
        @foreach($months as $month)
            <button class="schedule-month-filter__btn" data-schedule-month="{{ $month['value'] }}" type="button">{{ $month['label'] }}</button>
        @endforeach
    </div>
    @endif

    <div class="schedule-table">
        <div class="schedule-table__head">
            <span>Дата</span>
            <span>Курс</span>
            <span>Примечание</span>
            <span>Время</span>
            <span>Стоимость</span>
            <span>Ак.ч.</span>
        </div>
        <div id="schedule-table-body">
            @foreach($courses as $entry)
            <article class="schedule-row"
                     data-course="{{ $entry['course_title'] }}"
                     data-price="{{ !empty($entry['price']) ? price($entry['price']) . ' ' . $entry['currency_symbol'] : '' }}"
                     data-date="{{ $entry['date_formatted'] ?? $entry['date_type_label'] ?? '' }}">
                <div class="schedule-row__date">
                    @if($entry['date_formatted'])
                        <strong>{{ $entry['date_formatted'] }}</strong>
                    @endif
                    @if($entry['date_type_label'])
                        <span>{{ $entry['date_type_label'] }}</span>
                    @endif
                </div>
                <div class="schedule-row__course">
                    <strong>{{ $entry['course_title'] }}</strong>
                </div>
                <div class="schedule-row__note">{{ $entry['note'] ?? '' }}</div>
                <div class="schedule-row__time">{{ $entry['time'] ?? '' }}</div>
                <div class="schedule-row__price">
                    @if(!empty($entry['price']))
                        {{ price($entry['price']) }} {{ $entry['currency_symbol'] }}
                    @endif
                </div>
                <div class="schedule-row__hours"><span>Академические часы</span>{{ $entry['hours'] ?? '' }}</div>
            </article>
            @endforeach
        </div>
    </div>

    <p class="schedule-courses-empty" id="schedule-courses-empty" style="display:none">
        По выбранному месяцу курсов не найдено
    </p>

</section>
@endif
