@props([
    'name',
    'label',
    'type'     => 'text',
    'required' => false,
])

<div class="input-group app_input_group">
    <input
        class="input-group__input app_input_name {{ $type === 'tel' ? 'imask' : '' }}"
        name="{{ $name }}"
        type="{{ $type }}"
        placeholder=" "
        @if($required) required @endif
    >
    <label class="input-group__label">
        {{ $label }}@if($required) <span>*</span>@endif
    </label>
    <div class="app_input_error"></div>
</div>
