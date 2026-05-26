@props(['property'])

@php
    $gallery = $property->galleryMedia();
@endphp

<div {{ $attributes->class(['property-gallery']) }} x-data="{ lightbox: null }">
    <div class="property-gallery-header">
        <div>
            <p class="property-show-eyebrow">Gallery</p>
            <h2 class="property-gallery-title">Photo gallery</h2>
        </div>
        @if($gallery->isNotEmpty())
            <p class="property-gallery-count">{{ $gallery->count() }} {{ $gallery->count() === 1 ? 'photo' : 'photos' }}</p>
        @endif
    </div>

    @if($gallery->isEmpty())
        <div class="property-gallery-empty">
            <p class="text-muted">Gallery images coming soon</p>
        </div>
    @else
        <div class="property-gallery-grid">
            @foreach($gallery as $index => $media)
                <button
                    type="button"
                    @class([
                        'property-gallery-item',
                        'property-gallery-item--featured' => $index === 0 && $gallery->count() > 1,
                    ])
                    @click="lightbox = {{ $index }}"
                    aria-label="Open photo {{ $index + 1 }} of {{ $gallery->count() }}"
                >
                    <img
                        src="{{ $property->mediaUrl($media) }}"
                        alt="{{ $property->title }} — photo {{ $index + 1 }}"
                        class="property-gallery-image"
                        loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                    >
                    <span class="property-gallery-overlay" aria-hidden="true">
                        <span class="property-gallery-zoom">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6"/>
                            </svg>
                        </span>
                        @if($index === 0 && $gallery->count() > 1)
                            <span class="property-gallery-hint">View all photos</span>
                        @endif
                    </span>
                </button>
            @endforeach
        </div>

        <p class="property-gallery-tip">Tip: click any image to view full size. Use arrow keys to browse.</p>

        <div
            x-show="lightbox !== null"
            x-cloak
            x-transition.opacity
            @keydown.escape.window="lightbox = null"
            @keydown.arrow-left.window="lightbox = lightbox === null ? null : (lightbox === 0 ? {{ $gallery->count() - 1 }} : lightbox - 1)"
            @keydown.arrow-right.window="lightbox = lightbox === null ? null : (lightbox === {{ $gallery->count() - 1 }} ? 0 : lightbox + 1)"
            class="property-lightbox"
            role="dialog"
            aria-modal="true"
            :aria-label="'Photo ' + (lightbox + 1) + ' of {{ $gallery->count() }}'"
        >
            <button type="button" class="property-lightbox-backdrop" @click="lightbox = null" aria-label="Close gallery"></button>
            <div class="property-lightbox-inner">
                <button type="button" class="property-lightbox-close" @click="lightbox = null" aria-label="Close">&times;</button>
                <p class="property-lightbox-counter" x-text="(lightbox + 1) + ' / {{ $gallery->count() }}'"></p>
                <button
                    type="button"
                    class="property-lightbox-nav property-lightbox-prev"
                    @click="lightbox = lightbox === 0 ? {{ $gallery->count() - 1 }} : lightbox - 1"
                    aria-label="Previous photo"
                >‹</button>
                @foreach($gallery as $index => $media)
                    <img
                        x-show="lightbox === {{ $index }}"
                        x-transition.opacity
                        src="{{ $property->mediaUrl($media, null) }}"
                        alt="{{ $property->title }} — photo {{ $index + 1 }}"
                        class="property-lightbox-image"
                    >
                @endforeach
                <button
                    type="button"
                    class="property-lightbox-nav property-lightbox-next"
                    @click="lightbox = lightbox === {{ $gallery->count() - 1 }} ? 0 : lightbox + 1"
                    aria-label="Next photo"
                >›</button>
            </div>
        </div>
    @endif
</div>
