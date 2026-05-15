@props(['label', 'name', 'value' => '1', 'required' => false, 'checked' => false])
<label class="form-check">
    <input
        type="checkbox"
        name="{{ $name }}"
        value="{{ $value }}"
        @if($required) required @endif
        @if($checked || old($name)) checked @endif
        {{ $attributes->merge(['class' => 'form-check-input']) }}
    >
    <span class="form-check-label">{{ $label }}</span>
</label>
