@props(['embed' => null])

@php
    $embed ??= \App\Support\VideoEmbed::modalFromUrl(config('acremann.brand_video_url'));
@endphp

@if($embed)
    <div
        class="home-hero-video-play"
        x-data="homeHeroVideoModal(@js($embed))"
        @keydown.escape.window="closeVideo()"
    >
        <button
            type="button"
            class="home-hero-play-btn"
            @click.stop="openVideo()"
            @mouseenter.once="warmConnection()"
            @focus.once="warmConnection()"
            aria-haspopup="dialog"
            :aria-expanded="isOpen.toString()"
            aria-label="Play {{ $embed['title'] }}"
        >
            <span class="home-hero-play-btn-ripple home-hero-play-btn-ripple--1" aria-hidden="true"></span>
            <span class="home-hero-play-btn-ripple home-hero-play-btn-ripple--2" aria-hidden="true"></span>
            <span class="home-hero-play-btn-core" aria-hidden="true">
                <svg class="home-hero-play-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M8 5v14l11-7z"/>
                </svg>
            </span>
        </button>

        <template x-teleport="body">
            <div
                x-show="isOpen"
                x-cloak
                x-transition.opacity.duration.200ms
                class="home-hero-video-modal"
                role="dialog"
                aria-modal="true"
                :aria-label="@js($embed['title'])"
            >
                <button
                    type="button"
                    class="home-hero-video-modal-backdrop"
                    @click="closeVideo()"
                    aria-label="Close video"
                ></button>
                <div class="home-hero-video-modal-panel">
                    <button
                        type="button"
                        class="home-hero-video-modal-close"
                        @click="closeVideo()"
                        aria-label="Close video"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    <div class="home-hero-video-modal-frame">
                        <iframe
                            x-bind:src="iframeSrc"
                            class="home-hero-video-modal-iframe"
                            title="{{ $embed['title'] }}"
                            allow="autoplay; fullscreen; picture-in-picture"
                            allowfullscreen
                            loading="lazy"
                            referrerpolicy="strict-origin-when-cross-origin"
                        ></iframe>
                    </div>
                </div>
            </div>
        </template>
    </div>
@endif
