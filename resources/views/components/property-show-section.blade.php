@props(['title', 'id' => null, 'eyebrow' => null])

<section
    @if($id) id="{{ $id }}" @endif
    {{ $attributes->class(['property-show-section']) }}
>
    @if($eyebrow)
        <p class="property-show-eyebrow">{{ $eyebrow }}</p>
    @endif
    <h2 class="property-show-section-title">{{ $title }}</h2>
    <div class="property-show-section-body">
        {{ $slot }}
    </div>
</section>
