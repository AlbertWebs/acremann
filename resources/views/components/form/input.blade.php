@props([
    'label',
    'name',
    'type' => 'text',
    'required' => false,
    'placeholder' => null,
    'value' => null,
    'hint' => null,
])
<div class="form-group">
    <label for="{{ $name }}" class="form-label {{ $required ? 'form-label-required' : '' }}">{{ $label }}</label>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'form-control']) }}
    >
    @if($hint)<p class="form-hint">{{ $hint }}</p>@endif
    @error($name)<p class="text-xs text-red-600">{{ $message }}</p>@enderror
</div>
