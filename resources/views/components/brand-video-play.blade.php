@props([
    'embed' => null,
    'posterUrl' => null,
    'caption' => null,
    'slotClass' => '',
    'showPoster' => true,
    'autoplay' => false,
])

@php
    $videoUrl = \App\Support\VideoEmbed::brandVideoUrl();
    $backgroundEmbed = $autoplay ? \App\Support\VideoEmbed::fromUrl($videoUrl) : null;
    $embed ??= \App\Support\VideoEmbed::modalFromUrl($videoUrl);

    if ($showPoster && ! $autoplay) {
        $posterUrl ??= \App\Support\VideoEmbed::vimeoThumbnailUrl($videoUrl) ?? asset('bg/APL105.jpg');
    } else {
        $posterUrl = null;
    }

    $videoTitle = $embed['title'] ?? 'Acremann Properties video';
@endphp

@if($autoplay && $backgroundEmbed)
    <div {{ $attributes->class(['brand-video-slot', $slotClass]) }}>
        <iframe
            class="brand-video-iframe home-hero-video-media"
            src="{{ $backgroundEmbed['embed_url'] }}"
            title="{{ $videoTitle }}"
            allow="autoplay; fullscreen; picture-in-picture"
            allowfullscreen
            loading="eager"
            referrerpolicy="strict-origin-when-cross-origin"
        ></iframe>
        <div class="brand-video-poster-overlay" aria-hidden="true"></div>
        @if($caption)
            <p class="brand-video-caption">{{ $caption }}</p>
        @endif
    </div>
@elseif($embed)
    <div {{ $attributes->class(['brand-video-slot', $slotClass]) }}>
        @if($posterUrl)
            <div
                class="brand-video-poster"
                style="background-image: url('{{ e($posterUrl) }}')"
                role="img"
                aria-label=""
            ></div>
            <div class="brand-video-poster-overlay" aria-hidden="true"></div>
        @endif

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

        @if($caption)
            <p class="brand-video-caption">{{ $caption }}</p>
        @endif
    </div>
@endif
