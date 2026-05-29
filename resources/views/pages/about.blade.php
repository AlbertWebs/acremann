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

<section class="about-mv-section section-padding" aria-labelledby="about-mv-heading">
    <div class="container-site">
        <div class="about-team-header">
            <div class="about-team-intro">
                <p class="about-eyebrow-dark">Purpose</p>
                <h2 id="about-mv-heading" class="about-section-title">Mission &amp; vision</h2>
                <p class="about-section-lead about-section-lead-left">The principles that guide every plot we list, every title we verify, and every client we advise.</p>
            </div>
            <div class="about-team-cta-group about-team-cta-desktop">
                <a href="{{ route('services') }}" class="about-team-cta">
                    Our services
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
                <a href="{{ route('sustainability') }}" class="about-team-cta about-team-cta-secondary">
                    Our approach
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
        </div>

        <ul class="about-mv-principles" role="list">
            <li class="about-mv-principle about-mv-principle--forest">
                <span class="about-mv-principle-icon" aria-hidden="true">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>
                </span>
                Clean title discipline
            </li>
            <li class="about-mv-principle about-mv-principle--gold">
                <span class="about-mv-principle-icon about-mv-principle-icon--gold" aria-hidden="true">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                </span>
                Client-first advisory
            </li>
            <li class="about-mv-principle about-mv-principle--forest">
                <span class="about-mv-principle-icon" aria-hidden="true">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 21h19.5M4.5 21V9.75A2.25 2.25 0 0 1 6.75 7.5h10.5A2.25 2.25 0 0 1 19.5 9.75V21M6 21v-4.5h12V21"/></svg>
                </span>
                Legacy-minded development
            </li>
        </ul>

        <p class="about-mv-grid-label">Two commitments</p>
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

        <div class="about-team-footer about-mv-footer">
            <a href="{{ route('contact') }}" class="about-team-cta about-team-cta-full">
                Work with us
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

@if($leadership->isNotEmpty() || $team->isNotEmpty())
<section class="about-team-section section-padding" aria-labelledby="about-team-heading">
    <div class="container-site">
        <div class="about-team-header">
            <div class="about-team-intro">
                <p class="about-eyebrow-dark">Our team</p>
                <h2 id="about-team-heading" class="about-section-title">People behind every verified plot</h2>
                <p class="about-section-lead about-section-lead-left">
                    Experienced advisors and client specialists — from title discipline and diaspora support to on-ground site visits.
                </p>
            </div>
            <div class="about-team-cta-group about-team-cta-desktop">
                <a href="{{ route('leadership.index') }}" class="about-team-cta">
                    View leadership
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
                <a href="{{ route('contact') }}" class="about-team-cta about-team-cta-secondary">
                    Work with us
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
        </div>

        @if($leadership->isNotEmpty())
            <div class="about-team-leadership" aria-label="Leadership">
                <p class="about-team-subheading">Leadership</p>
                <div class="about-team-leadership-grid">
                    @foreach($leadership as $member)
                        <x-team-member-card :member="$member" variant="leadership" />
                    @endforeach
                </div>
            </div>
        @endif

        @if($team->isNotEmpty())
            <div @class(['about-team-specialists', 'about-team-specialists-spaced' => $leadership->isNotEmpty()]) aria-label="Advisory and sales team">
                <p class="about-team-subheading">Advisory &amp; sales specialists</p>
                <div class="about-team-grid">
                    @foreach($team as $member)
                        <x-team-member-card :member="$member" />
                    @endforeach
                </div>
            </div>
        @endif

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
