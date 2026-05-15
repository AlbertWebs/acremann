@props([
    'label',
    'name',
    'required' => false,
    'hint' => null,
])
<div class="form-group">
    <label for="{{ $name }}" class="form-label {{ $required ? 'form-label-required' : '' }}">{{ $label }}</label>
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'form-control']) }}
    >
        {{ $slot }}
    </select>
    @if($hint)<p class="form-hint">{{ $hint }}</p>@endif
    @error($name)<p class="text-xs text-red-600">{{ $message }}</p>@enderror
</div>
