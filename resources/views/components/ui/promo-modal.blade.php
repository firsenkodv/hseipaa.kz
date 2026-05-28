@php
    $data        = \App\Models\Setting::getGroup('promo_modal')->data ?? [];
    $enabled     = (bool) ($data['promo_modal_enabled'] ?? false);
    $dismissDays = isset($data['promo_modal_dismiss_days']) ? (int) $data['promo_modal_dismiss_days'] : 3;
    $delay       = isset($data['promo_modal_delay']) ? (int) $data['promo_modal_delay'] : 4;
@endphp

@if($enabled)
<div id="promoModal" data-dismiss-days="{{ $dismissDays }}" data-delay="{{ $delay }}" hidden></div>
@endif
