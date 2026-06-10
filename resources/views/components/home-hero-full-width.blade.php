@props(['settings'])

@php
    $primaryCta = $settings->heroPrimaryCta();
    $secondaryCta = $settings->heroSecondaryCta();
    $brandVideoEmbed = \App\Support\VideoEmbed::fromUrl(config('acremann.brand_video_url'));
@endphp

@if($brandVideoEmbed)
    <section class="home-hero-full-width" aria-labelledby="home-hero-full-width-heading">
        <x-brand-video-play
            autoplay
            :show-poster="false"
            slot-class="home-hero-full-width-video"
        />
        <div class="home-hero-full-width-overlay" aria-hidden="true"></div>
        <div class="home-hero-full-width-copy">
            <div class="container-site home-hero-full-width-copy-grid">
                <div class="home-hero-full-width-copy-inner">
                    <p class="home-hero-full-width-eyebrow">{{ $settings->heroEyebrow() }}</p>
                    <h1 id="home-hero-full-width-heading" class="home-hero-full-width-title">{{ $settings->heroHeadline() }}</h1>
                    <p class="home-hero-full-width-lead">{{ $settings->heroDescription() }}</p>
                    <div class="home-hero-full-width-ctas">
                        <a href="{{ $primaryCta['url'] }}" class="btn-primary">{{ $primaryCta['label'] }}</a>
                        <a href="{{ $secondaryCta['url'] }}" class="btn-outline about-btn-on-dark">{{ $secondaryCta['label'] }}</a>
                        @if($settings->heroShowsWhatsappCta())
                            <a href="{{ $settings->whatsappUrl() }}" target="_blank" rel="noopener noreferrer" class="btn-outline about-btn-on-dark">{{ $settings->heroWhatsappLabel() }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@else
    <section class="section-padding bg-white">
        <div class="container-site home-hero-full-width-copy home-hero-full-width-copy--fallback">
            <p class="text-sm font-semibold uppercase tracking-widest text-gold">{{ $settings->heroEyebrow() }}</p>
            <h1 id="home-hero-full-width-heading" class="mt-4 text-4xl leading-tight md:text-5xl lg:text-6xl">{{ $settings->heroHeadline() }}</h1>
            <p class="mt-6 max-w-xl text-muted">{{ $settings->heroDescription() }}</p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ $primaryCta['url'] }}" class="btn-primary">{{ $primaryCta['label'] }}</a>
                <a href="{{ $secondaryCta['url'] }}" class="btn-outline">{{ $secondaryCta['label'] }}</a>
                @if($settings->heroShowsWhatsappCta())
                    <a href="{{ $settings->whatsappUrl() }}" target="_blank" rel="noopener noreferrer" class="btn-outline">{{ $settings->heroWhatsappLabel() }}</a>
                @endif
            </div>
        </div>
    </section>
@endif
