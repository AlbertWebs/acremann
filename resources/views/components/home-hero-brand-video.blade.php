@props(['embed'])

@php
    $posterUrl = \App\Support\VideoEmbed::vimeoThumbnailUrl(config('acremann.brand_video_url'))
        ?? asset('bg/APL105.jpg');
@endphp

<div class="home-hero-media-slot aspect-[2/1] w-full overflow-hidden rounded-sm bg-charcoal/5">
    <div
        class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('{{ e($posterUrl) }}')"
        role="img"
        aria-label=""
    ></div>
    <div class="brand-video-poster-overlay" aria-hidden="true"></div>
    <x-home-hero-video-play :embed="$embed" />
</div>
