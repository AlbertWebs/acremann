@extends('layouts.app')
@php
    $metaTitle = ($event->meta_title ?: $event->title).' | Events | '.$settings->company_name;
    $metaDescription = $event->meta_description ?: $event->excerpt;
@endphp
@section('content')
@php($heroImageUrl = $event->heroImageUrl())
<section @class(['events-show-hero section-padding', 'events-show-hero--has-image' => $heroImageUrl])>
    @if($heroImageUrl)
        <div class="events-show-hero-media" aria-hidden="true">
            <img src="{{ $heroImageUrl }}" alt="" class="events-show-hero-image" fetchpriority="high">
            <div class="events-show-hero-overlay"></div>
        </div>
    @endif
    <div class="container-site events-show-hero-inner">
        <nav class="events-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('events.index') }}">Events</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page">{{ $event->title }}</span>
        </nav>
        <div class="events-show-header">
            @if($event->event_date)
                <p class="events-eyebrow">{{ $event->event_date->format('l, F j, Y') }}</p>
            @endif
            <h1 class="events-show-title">{{ $event->title }}</h1>
            @if($event->location)
                <p class="events-show-location">{{ $event->location }}</p>
            @endif
        </div>
    </div>
</section>

<section class="events-show-content section-padding" x-data="{ lightbox: null }">
    <div class="container-site">
        <div class="events-show-layout">
            <div class="events-show-main">
                @if($event->description)
                    <div class="events-show-prose" aria-label="Event details">
                        {!! $event->description !!}
                    </div>
                @endif

                <div id="event-gallery" class="events-show-gallery-block {{ $event->description ? 'mt-12 md:mt-16' : '' }}">
        <div class="events-gallery-header">
            <h2 class="events-gallery-title">Photo gallery</h2>
            @if($gallery->isNotEmpty())
                <p class="events-gallery-count">{{ $gallery->count() }} {{ $gallery->count() === 1 ? 'photo' : 'photos' }}</p>
            @endif
        </div>

        @if($gallery->isEmpty())
            <div class="events-empty card">
                <p class="text-muted">Photos for this event will be added soon.</p>
            </div>
        @else
            <div class="events-gallery-grid">
                @foreach($gallery as $index => $media)
                    <button
                        type="button"
                        class="events-gallery-item"
                        @click="lightbox = {{ $index }}"
                        aria-label="Open photo {{ $index + 1 }} of {{ $gallery->count() }}"
                    >
                        <img
                            src="{{ $event->mediaUrl($media) }}"
                            alt="{{ $event->title }} — photo {{ $index + 1 }}"
                            class="events-gallery-image"
                            loading="lazy"
                        >
                    </button>
                @endforeach
            </div>

            <div
                x-show="lightbox !== null"
                x-cloak
                x-transition.opacity
                @keydown.escape.window="lightbox = null"
                class="events-lightbox"
                role="dialog"
                aria-modal="true"
                :aria-label="'Photo ' + (lightbox + 1) + ' of {{ $gallery->count() }}'"
            >
                <button type="button" class="events-lightbox-backdrop" @click="lightbox = null" aria-label="Close gallery"></button>
                <div class="events-lightbox-inner">
                    <button type="button" class="events-lightbox-close" @click="lightbox = null" aria-label="Close">&times;</button>
                    <button
                        type="button"
                        class="events-lightbox-nav events-lightbox-prev"
                        @click="lightbox = lightbox === 0 ? {{ $gallery->count() - 1 }} : lightbox - 1"
                        aria-label="Previous photo"
                    >‹</button>
                    @foreach($gallery as $index => $media)
                        <img
                            x-show="lightbox === {{ $index }}"
                            src="{{ $event->mediaUrl($media, null) }}"
                            alt="{{ $event->title }} — photo {{ $index + 1 }}"
                            class="events-lightbox-image"
                        >
                    @endforeach
                    <button
                        type="button"
                        class="events-lightbox-nav events-lightbox-next"
                        @click="lightbox = lightbox === {{ $gallery->count() - 1 }} ? 0 : lightbox + 1"
                        aria-label="Next photo"
                    >›</button>
                </div>
            </div>
        @endif
                </div>
            </div>

            @include('events.partials.sidebar')
        </div>
    </div>
</section>
@endsection
