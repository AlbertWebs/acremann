@extends('layouts.app')
@php
    $metaTitle = $service->seoTitle();
    $metaDescription = $service->seoDescription();
    $headerImageUrl = $service->headerImageUrl();
    $waMessage = "Hello Acremann, I would like to enquire about your {$service->title} service.";
    $localSummary = $service->plainLocalSummary() ?: 'Whether you are buying your first plot in Nairobi, Kiambu, Kikuyu or Nachu, or adding to an existing portfolio, we provide on-ground verification, transparent pricing, and advisory through handover.';
    $diasporaSummary = $service->plainDiasporaSummary() ?: 'Buying from the UK, US, UAE or elsewhere? We structure remote purchases with documented milestones, verified title packs, video walkthroughs, and clear communication across time zones.';
@endphp
@section('content')
<section @class(['service-show-hero section-padding', 'service-show-hero--has-image' => filled($headerImageUrl)]) aria-labelledby="service-show-heading">
    @if(filled($headerImageUrl))
        <div class="service-show-hero-bg" style="background-image: url('{{ e($headerImageUrl) }}')" role="presentation" aria-hidden="true"></div>
    @endif
    <div class="service-show-hero-overlay" aria-hidden="true"></div>
    <div class="container-site service-show-hero-inner">
        <nav class="service-show-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('services') }}" class="service-show-breadcrumb-link">Services</a>
            <span aria-hidden="true">/</span>
            <span class="service-show-breadcrumb-current">{{ $service->title }}</span>
        </nav>
        <div class="service-show-hero-grid">
            <div>
                <div class="service-show-icon" aria-hidden="true">
                    @include('services.partials.icon', ['icon' => $service->icon, 'class' => 'h-7 w-7'])
                </div>
                <h1 id="service-show-heading" class="service-show-title">{{ $service->title }}</h1>
                <p class="service-show-lead">{{ $service->plainSummary() }}</p>
                <div class="service-show-hero-ctas">
                    <a href="{{ route('contact') }}" class="btn-primary">Enquire about this service</a>
                    <a href="{{ $settings->whatsappUrl($waMessage) }}" target="_blank" rel="noopener noreferrer" class="btn-outline service-btn-on-dark inline-flex items-center gap-2" data-track="whatsapp_click">
                        <x-icon-whatsapp class="h-5 w-5 shrink-0" />
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="service-show-audience section-padding bg-white" aria-label="Who this service is for">
    <div class="container-site">
        <div class="service-show-audience-grid">
            <article class="service-show-audience-card service-show-audience-local">
                <p class="service-show-audience-label">Buyers in Kenya</p>
                <h2 class="service-show-audience-title">On-ground advisory</h2>
                <p class="service-show-audience-body">{{ $localSummary }}</p>
                <a href="{{ route('properties.index') }}" class="service-show-inline-link">Browse plots →</a>
            </article>
            <article class="service-show-audience-card service-show-audience-diaspora">
                <p class="service-show-audience-label">Diaspora investors</p>
                <h2 class="service-show-audience-title">Buy land from abroad</h2>
                <p class="service-show-audience-body">{{ $diasporaSummary }}</p>
                <a href="{{ route('invest') }}#diaspora" class="service-show-inline-link">Diaspora guidance →</a>
            </article>
        </div>
    </div>
</section>

@if(filled($service->body))
<section class="service-show-content section-padding" aria-label="Service details">
    <div class="container-site">
        <div class="service-show-content-inner">
            <div class="service-show-prose prose prose-sm max-w-none">
                {!! $service->body !!}
            </div>
        </div>
    </div>
</section>
@endif

@if($otherServices->isNotEmpty())
<section class="service-show-related section-padding border-t border-charcoal/8 bg-gradient-to-b from-cream/40 to-white" aria-labelledby="service-related-heading">
    <div class="container-site">
        <h2 id="service-related-heading" class="service-show-related-title">Other services</h2>
        <div class="services-grid services-grid-compact">
            @foreach($otherServices as $other)
                <a href="{{ route('services.show', $other->slug) }}" class="services-card services-card-compact group">
                    @if($otherFeaturedUrl = $other->featuredImageUrl())
                        <div class="services-card-media services-card-media-compact">
                            <img src="{{ $otherFeaturedUrl }}" alt="" class="services-card-media-img" loading="lazy" decoding="async">
                        </div>
                    @else
                        <div class="services-card-icon" aria-hidden="true">
                            @include('services.partials.icon', ['icon' => $other->icon, 'class' => 'h-5 w-5'])
                        </div>
                    @endif
                    <h3 class="services-card-title">{{ $other->title }}</h3>
                    <p class="services-card-summary">{{ $other->plainSummary() }}</p>
                    <span class="services-card-link">Learn more</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="service-show-cta section-padding" aria-label="Get started">
    <div class="container-site">
        <div class="service-show-cta-band">
            <div>
                <h2 class="service-show-cta-title">Ready to get started?</h2>
                <p class="service-show-cta-lead">Book a site visit, request a callback, or message us on WhatsApp — we typically respond within one business day.</p>
            </div>
            <div class="service-show-cta-buttons">
                <a href="{{ route('book-visit') }}" class="btn-primary">Book a site visit</a>
                <a href="{{ route('contact') }}" class="btn-outline service-btn-on-dark">Contact us</a>
            </div>
        </div>
    </div>
</section>
@endsection
