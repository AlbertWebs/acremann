@extends('layouts.app')
@php
    $metaTitle = 'Property services Kenya | Land sales, advisory & diaspora support';
    $metaDescription = 'Professional real estate services in Nairobi, Kiambu, Kikuyu and Nachu — land sales, investment advisory, conveyancing, and diaspora-friendly remote purchase support.';
@endphp
@section('content')
<section class="services-hero section-padding" aria-labelledby="services-hero-heading">
    <div class="container-site">
        <div class="services-hero-inner">
            @if($settings->servicesHeroLogoUrl())
                <a href="{{ route('home') }}" class="services-hero-brand mb-6 inline-block" aria-label="{{ $settings->company_name }}">
                    <img
                        src="{{ $settings->servicesHeroLogoUrl() }}"
                        alt=""
                        class="services-hero-logo"
                        width="176"
                        height="40"
                        decoding="async"
                    />
                </a>
            @endif
            <p class="services-eyebrow">{{ $settings->servicesPageEyebrow() }}</p>
            <h1 id="services-hero-heading" class="services-hero-title">{{ $settings->servicesPageHeadline() }}</h1>
            <p class="services-hero-lead">{{ $settings->servicesPageLead() }}</p>
        </div>
    </div>
</section>

<section class="services-list-section section-padding bg-white" aria-labelledby="services-list-heading">
    <div class="container-site">
        <div class="services-section-header">
            <h2 id="services-list-heading" class="services-section-title">{{ $settings->servicesPageSectionTitle() }}</h2>
            <p class="services-section-lead">{{ $settings->servicesPageSectionLead() }}</p>
        </div>

        <div class="services-grid">
            @foreach($services as $service)
                <a href="{{ route('services.show', $service->slug) }}" class="services-card group">
                    @if($featuredUrl = $service->featuredImageUrl())
                        <div class="services-card-media">
                            <img src="{{ $featuredUrl }}" alt="" class="services-card-media-img" loading="lazy" decoding="async">
                        </div>
                    @else
                        <div class="services-card-icon" aria-hidden="true">
                            @include('services.partials.icon', ['icon' => $service->icon, 'class' => 'h-6 w-6'])
                        </div>
                    @endif
                    <h3 class="services-card-title">{{ $service->title }}</h3>
                    <p class="services-card-summary">{{ $service->plainSummary() }}</p>
                    <span class="services-card-link">
                        View service
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                        </svg>
                    </span>
                </a>
            @endforeach
        </div>

        <div class="services-cta-band">
            <div>
                <h2 class="services-cta-title">Not sure which service you need?</h2>
                <p class="services-cta-lead">Tell us your goals — residential plot, investment, or diaspora purchase — and we will point you to the right advisory path.</p>
            </div>
            <div class="services-cta-buttons">
                <a href="{{ route('contact') }}" class="btn-primary">Speak to advisor</a>
                <a href="{{ route('invest') }}" class="btn-outline">Invest with Acremann</a>
            </div>
        </div>
    </div>
</section>
@endsection
