@extends('layouts.app')
@php
    $metaTitle = 'About Acremann | Legacy-minded real estate advisory Kenya';
    $metaDescription = 'Professional property advisory in Nairobi, Kiambu, Kikuyu and Nachu — clean title deeds, transparent conveyancing, and diaspora-friendly land investment.';
@endphp
@section('content')
<section class="about-hero section-padding" aria-labelledby="about-hero-heading">
    <div class="container-site">
        <div class="about-hero-grid">
            <div class="about-hero-copy">
                @if($settings->whiteLogoUrl())
                    <x-site-logo :settings="$settings" variant="white" class="mb-6 max-h-10 w-auto" />
                @endif
                <p class="about-eyebrow">About Acremann</p>
                <h1 id="about-hero-heading" class="about-hero-title">Legacy-minded real estate advisory</h1>
                <p class="about-hero-lead">{{ $settings->aboutSummary() }}</p>
                <div class="about-hero-ctas">
                    <a href="{{ route('services') }}" class="btn-primary">Our services</a>
                    <a href="{{ route('contact') }}" class="btn-outline about-btn-on-dark">Get in touch</a>
                </div>
            </div>
            <div class="about-hero-aside" aria-label="What we stand for">
                <div class="about-mv-preview">
                    <article class="about-mv-preview-card">
                        <span class="about-mv-preview-label">Mission</span>
                        <p class="about-mv-preview-text">{{ $settings->missionStatement() }}</p>
                    </article>
                    <article class="about-mv-preview-card">
                        <span class="about-mv-preview-label">Vision</span>
                        <p class="about-mv-preview-text">{{ $settings->visionStatement() }}</p>
                    </article>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about-mv-section section-padding bg-white" aria-labelledby="about-mv-heading">
    <div class="container-site">
        <div class="about-section-header">
            <p class="about-eyebrow-dark">Purpose</p>
            <h2 id="about-mv-heading" class="about-section-title">Mission &amp; vision</h2>
            <p class="about-section-lead">The principles that guide every plot we list, every title we verify, and every client we advise.</p>
        </div>
        <div class="about-mv-grid">
            <article class="about-mv-card about-mv-card-mission">
                <div class="about-mv-icon" aria-hidden="true">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                    </svg>
                </div>
                <p class="about-mv-label">Our mission</p>
                <h3 class="about-mv-title">What we do every day</h3>
                <p class="about-mv-body">{{ $settings->missionStatement() }}</p>
            </article>
            <article class="about-mv-card about-mv-card-vision">
                <div class="about-mv-icon about-mv-icon-vision" aria-hidden="true">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                </div>
                <p class="about-mv-label">Our vision</p>
                <h3 class="about-mv-title">Where we are headed</h3>
                <p class="about-mv-body">{{ $settings->visionStatement() }}</p>
            </article>
        </div>
    </div>
</section>

@if($leadership->isNotEmpty())
<section class="about-team-section section-padding" aria-labelledby="about-leadership-heading">
    <div class="container-site">
        <div class="about-team-header">
            <div>
                <p class="about-eyebrow-dark">Leadership</p>
                <h2 id="about-leadership-heading" class="about-section-title">People who set the standard</h2>
                <p class="about-section-lead about-section-lead-left">Experienced advisors overseeing title discipline, client care, and project integrity.</p>
            </div>
        </div>
        <div class="about-team-grid about-team-grid-leadership">
            @foreach($leadership as $member)
                <article class="about-team-card about-team-card-leadership">
                    <div class="about-team-avatar" aria-hidden="true">
                        <span>{{ collect(explode(' ', $member->name))->map(fn ($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('') }}</span>
                    </div>
                    <h3 class="about-team-name">{{ $member->name }}</h3>
                    <p class="about-team-role">{{ $member->role }}</p>
                    @if($member->plainBio())
                        <p class="about-team-bio">{{ $member->plainBio() }}</p>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($team->isNotEmpty())
<section class="about-team-section about-team-section-alt section-padding" aria-labelledby="about-team-heading">
    <div class="container-site">
        <div class="about-team-header">
            <div>
                <p class="about-eyebrow-dark">Our team</p>
                <h2 id="about-team-heading" class="about-section-title">Advisory &amp; sales specialists</h2>
                <p class="about-section-lead about-section-lead-left">The people you will work with from first enquiry through to handover.</p>
            </div>
            <a href="{{ route('contact') }}" class="about-team-cta hidden shrink-0 md:inline-flex">
                Work with us
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>
        <div class="about-team-grid">
            @foreach($team as $member)
                <article class="about-team-card">
                    <div class="about-team-avatar about-team-avatar-muted" aria-hidden="true">
                        <span>{{ collect(explode(' ', $member->name))->map(fn ($w) => strtoupper(substr($w, 0, 1)))->take(2)->join('') }}</span>
                    </div>
                    <h3 class="about-team-name">{{ $member->name }}</h3>
                    <p class="about-team-role about-team-role-muted">{{ $member->role }}</p>
                    @if($member->plainBio())
                        <p class="about-team-bio">{{ $member->plainBio() }}</p>
                    @endif
                </article>
            @endforeach
        </div>
        <div class="about-team-footer">
            <a href="{{ route('contact') }}" class="about-team-cta about-team-cta-full">
                Contact the team
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif

<section class="about-cta-section section-padding" aria-label="Explore Acremann">
    <div class="container-site">
        <div class="about-cta-band">
            <div>
                <h2 class="about-cta-title">Ready to explore verified plots?</h2>
                <p class="about-cta-lead">Browse listings across Nairobi, Kiambu, Kikuyu and Nachu — or book a site visit with our advisory team.</p>
            </div>
            <div class="about-cta-buttons">
                <a href="{{ route('properties.index') }}" class="btn-primary">View properties</a>
                <a href="{{ route('book-visit') }}" class="btn-outline about-btn-on-dark">Book a site visit</a>
            </div>
        </div>
    </div>
</section>
@endsection
