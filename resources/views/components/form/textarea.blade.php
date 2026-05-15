@props([
    'label',
    'name',
    'required' => false,
    'placeholder' => null,
    'rows' => 4,
    'rich' => false,
    'hint' => null,
])
<div class="form-group">
    <label for="{{ $name }}" class="form-label {{ $required ? 'form-label-required' : '' }}">{{ $label }}</label>
    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($required) required @endif
        @if($rich) data-rich-editor @endif
        {{ $attributes->merge(['class' => $rich ? 'hidden' : 'form-control']) }}
    >{{ old($name, $slot) }}</textarea>
    @if($hint)<p class="form-hint">{{ $hint }}</p>@endif
    @error($name)<p class="text-xs text-red-600">{{ $message }}</p>@enderror
</div>
