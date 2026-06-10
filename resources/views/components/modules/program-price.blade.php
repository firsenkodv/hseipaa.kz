@props(['item'])

@php
    $prices            = collect($item->price ?? [])->filter(fn($p) => !empty($p['value']));
    $priceOld          = $prices->count() >= 2 ? $prices->first() : null;
    $priceNew          = $prices->count() >= 2 ? $prices->last() : $prices->first();
    $currencyCode      = \App\Models\Setting::getGroup('social')->data['currency'] ?? 'KZT';
    $currencySymbol    = config('currency.currency.' . $currencyCode, '₸');
    $installmentMonths   = 12;
    $installmentMarkup   = 1 + (($item->installment_percent ?? 15) / 100);
    $installmentNew      = $priceNew ? (int) round(($priceNew['value'] / $installmentMonths) * $installmentMarkup) : null;
    $installmentOld      = $priceOld ? (int) round(($priceOld['value'] / $installmentMonths) * $installmentMarkup) : null;
    $discount          = ($priceOld && $priceNew && $priceOld['value'] > 0)
                             ? (int) round((1 - $priceNew['value'] / $priceOld['value']) * 100)
                             : null;
@endphp
@if($priceNew)
<section class="program-price-shell">
    <div class="program-price-block" aria-label="Стоимость курса">
        <div class="program-price-card">
            <div class="program-price-card__title">
                <h2 class="program-price-card__heading">Стоимость курса</h2>
                <p class="program-price-card__amount" data-program-price>
                    {{ price($priceNew['value']) }} {{ $currencySymbol }}
                </p>
            </div>
            <img class="program-price-card__coins" src="{{ Storage::url('/images/img/price-coins.png') }}" alt="" />
            @if($priceOld && $installmentOld && $installmentNew)
            <div class="program-price-card__payment">
                <div class="program-price-card__timer">Акция действует 2 дня 8 часов 56 минут</div>
                <div class="program-price-card__panel">
                    <div class="program-price-card__old">
                        <span data-program-old-price>{{ price($installmentOld) }} {{ $currencySymbol }}</span>
                        <small>{{ $currencySymbol }}/мес</small>
                    </div>
                    <div class="program-price-card__new">
                        <span data-program-installment>{{ price($installmentNew) }}</span>
                        <small>{{ $currencySymbol }}/мес</small>
                    </div>
                    <p>Рассрочка на {{ $installmentMonths }} месяцев</p>
                    @if($discount)
                        <div class="program-price-card__badge">{{ $discount }}%</div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <div class="program-signup-card">
            <h3 class="program-signup-card__heading">
                <span>Записаться на курс</span>
                <span>или получить бесплатную консультацию</span>
            </h3>
            <form class="program-inline-form" data-inline-signup>
                <label>
                    <input type="text" name="name" placeholder="Ваше имя" required />
                </label>
                <label>
                    <input type="tel" name="phone" placeholder="Номер телефона" required />
                </label>
                <label>
                    <input type="email" name="email" placeholder="Электронная почта" required />
                </label>
                <button type="submit" data-program-button>Записаться на курс</button>
                <p class="program-inline-form__feedback" data-inline-feedback></p>
            </form>
        </div>
    </div>
</section>
@endif
