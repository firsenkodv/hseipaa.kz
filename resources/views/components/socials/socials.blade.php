@props(['btnClass' => 'social-btn'])

<div {{ $attributes }}>
    @if(!empty($social['telegram']))
    <a href="{{ $social['telegram'] }}" class="{{ $btnClass }}" aria-label="Telegram" target="_blank" rel="noopener">
        <img src="{{ Storage::url('/images/icons/footer/telegram.svg') }}" alt="Telegram" />
    </a>
    @endif
    @if(!empty($social['facebook']))
    <a href="{{ $social['facebook'] }}" class="{{ $btnClass }}" aria-label="Facebook" target="_blank" rel="noopener">
        <img src="{{ Storage::url('/images/icons/footer/facebook.svg') }}" alt="Facebook" />
    </a>
    @endif
    @if(!empty($social['youtube_channel']))
    <a href="{{ $social['youtube_channel'] }}" class="{{ $btnClass }}" aria-label="YouTube" target="_blank" rel="noopener">
        <img src="{{ Storage::url('/images/icons/footer/youtube.svg') }}" alt="YouTube" />
    </a>
    @endif
    @if(!empty($social['instagram']))
    <a href="{{ $social['instagram'] }}" class="{{ $btnClass }}" aria-label="Instagram" target="_blank" rel="noopener">
        <img src="{{ Storage::url('/images/icons/footer/instagram.svg') }}" alt="Instagram" />
    </a>
    @endif
</div>
