@props(['settings'])

@php
    $video = $settings->heroVideoPayload();
    $useVideo = $settings->heroShowsPrimaryVideo();
    $imageUrls = $useVideo
        ? $settings->homepageHeroSecondaryImageUrls()
        : $settings->homepageHeroImageUrls();
    $homeHeroVideoEmbed = \App\Support\VideoEmbed::modalFromUrl(config('acremann.brand_video_url'));
@endphp

@if($useVideo && $video)
    <div class="grid grid-cols-2 gap-3">
        <div class="home-hero-video col-span-2 aspect-[2/1] overflow-hidden rounded-sm bg-charcoal/5">
            @if($video['type'] === 'file')
                <video
                    class="home-hero-video-media"
                    src="{{ $video['src'] }}"
                    autoplay
                    muted
                    loop
                    playsinline
                    preload="metadata"
                    aria-label="Hero background video"
                ></video>
            @else
                <iframe
                    class="home-hero-video-media"
                    src="{{ $video['embed_url'] }}"
                    title="Hero background video"
                    allow="autoplay; fullscreen; picture-in-picture"
                    allowfullscreen
                    loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin"
                ></iframe>
            @endif
        </div>
        @foreach($imageUrls as $url)
            <div class="overflow-hidden rounded-sm bg-charcoal/5 aspect-square">
                <img src="{{ $url }}" alt="" class="h-full w-full object-cover">
            </div>
        @endforeach
    </div>
@elseif(count($imageUrls) === 1)
    <div class="home-hero-media-slot overflow-hidden rounded-sm bg-charcoal/5 aspect-[4/3] lg:aspect-auto lg:min-h-[22rem]">
        <img src="{{ $imageUrls[0] }}" alt="" class="h-full w-full object-cover">
        @if($homeHeroVideoEmbed)
            <x-home-hero-video-play :embed="$homeHeroVideoEmbed" />
        @endif
    </div>
@else
    <div class="grid grid-cols-2 gap-3">
        @foreach($imageUrls as $i => $url)
            @if($i === 0 && $homeHeroVideoEmbed)
                <div class="home-hero-media-slot col-span-2 aspect-[2/1] overflow-hidden rounded-sm bg-charcoal/5">
                    <img src="{{ $url }}" alt="" class="h-full w-full object-cover">
                    <x-home-hero-video-play :embed="$homeHeroVideoEmbed" />
                </div>
            @else
                <div @class([
                    'overflow-hidden rounded-sm bg-charcoal/5',
                    'col-span-2 aspect-[2/1]' => $i === 0,
                    'aspect-square' => $i > 0,
                ])>
                    <img src="{{ $url }}" alt="" class="h-full w-full object-cover">
                </div>
            @endif
        @endforeach
    </div>
@endif
