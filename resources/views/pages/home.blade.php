@extends('layouts.app')
@section('content')
@php
    $primaryCta = $settings->heroPrimaryCta();
    $secondaryCta = $settings->heroSecondaryCta();
    $homeHeroVideoEmbed = \App\Support\VideoEmbed::modalFromUrl(config('acremann.brand_video_url'));
@endphp
<section class="section-padding bg-white">
    <div @class([
        'container-site grid items-center gap-12',
        'lg:grid-cols-2' => ! $settings->heroIsTextOnly(),
    ])>
        <div @class(['max-w-3xl' => $settings->heroIsTextOnly()])>
            <p class="text-sm font-semibold uppercase tracking-widest text-gold">{{ $settings->heroEyebrow() }}</p>
            <h1 class="mt-4 text-4xl leading-tight md:text-5xl lg:text-6xl">{{ $settings->heroHeadline() }}</h1>
            <p class="mt-6 max-w-xl text-muted">{{ $settings->heroDescription() }}</p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ $primaryCta['url'] }}" class="btn-primary">{{ $primaryCta['label'] }}</a>
                <a href="{{ $secondaryCta['url'] }}" class="btn-outline">{{ $secondaryCta['label'] }}</a>
                @if($settings->heroShowsWhatsappCta())
                    <a href="{{ $settings->whatsappUrl() }}" target="_blank" rel="noopener noreferrer" class="btn-outline">{{ $settings->heroWhatsappLabel() }}</a>
                @endif
            </div>
        </div>
        @if($settings->heroShowsFeaturedProperties())
            @if($featuredProperties->isNotEmpty())
                <div class="grid grid-cols-2 gap-3">
                    @foreach($featuredProperties->take(4) as $i => $property)
                        @if($i === 0 && $homeHeroVideoEmbed)
                            <div class="home-hero-media-slot col-span-2 aspect-[2/1] overflow-hidden rounded-sm bg-charcoal/5">
                                <a href="{{ route('properties.show', $property->slug) }}" class="block h-full min-h-[12rem]">
                                    @if($url = $property->getFirstMediaUrl('hero'))
                                        <img src="{{ $url }}" alt="{{ $property->title }}" class="h-full w-full object-cover">
                                    @endif
                                </a>
                                <x-home-hero-video-play :embed="$homeHeroVideoEmbed" />
                            </div>
                        @else
                            <a href="{{ route('properties.show', $property->slug) }}" class="block overflow-hidden rounded-sm {{ $i === 0 ? 'col-span-2 aspect-[2/1]' : 'aspect-square' }} bg-charcoal/5">
                                @if($url = $property->getFirstMediaUrl('hero'))
                                    <img src="{{ $url }}" alt="{{ $property->title }}" class="h-full w-full object-cover">
                                @endif
                            </a>
                        @endif
                    @endforeach
                </div>
            @elseif($homeHeroVideoEmbed)
                <div class="w-full">
                    <x-home-hero-brand-video :embed="$homeHeroVideoEmbed" />
                </div>
            @endif
        @elseif($settings->heroShowsGallery())
            <x-home-hero-gallery :settings="$settings" :brand-video-embed="$homeHeroVideoEmbed" />
        @elseif($homeHeroVideoEmbed)
            <div class="w-full">
                <x-home-hero-brand-video :embed="$homeHeroVideoEmbed" />
            </div>
        @endif
    </div>
</section>

@include('pages.partials.home-sections')
@endsection

