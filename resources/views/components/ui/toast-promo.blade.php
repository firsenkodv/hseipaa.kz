@php
    $toastData    = \App\Models\Setting::getGroup('toast')->data ?? [];
    $toastText    = $toastData['toast_text'] ?? null;
    $toastLink    = !empty($toastData['toast_link']) ? $toastData['toast_link'] : '#';
    $dismissDays  = isset($toastData['toast_dismiss_days']) ? (int) $toastData['toast_dismiss_days'] : 3;
@endphp

@if($toastText)
<div class="toast-promo" id="toastPromo" role="alert" aria-live="polite"
     data-dismiss-days="{{ $dismissDays }}">
    <button class="toast-promo__close" id="toastPromoClose" aria-label="Закрыть">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 4L4 12M4 4L12 12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
        </svg>
    </button>

    <p class="toast-promo__text">{!! $toastText !!}</p>
    <a href="{{ $toastLink }}" class="toast-promo__btn">Подробнее</a>
</div>
@endif
