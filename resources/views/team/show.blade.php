@extends('layouts.app')
@php
    $metaTitle = $member->seoTitle();
    $metaDescription = $member->seoDescription();
    $metaImage = $member->seoImageUrl();
    $metaType = 'profile';
    $profileUrl = route('leadership.show', $member);
    $companyName = $settings->company_name ?: 'Acremann Properties';
    $isLeadership = $member->is_leadership;
    $teamLabel = $isLeadership ? 'Leadership' : 'Advisory & sales';
    $breadcrumbItems = [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'About', 'item' => route('about')],
    ];

    if ($isLeadership) {
        $breadcrumbItems[] = ['@type' => 'ListItem', 'position' => 2, 'name' => 'Leadership', 'item' => route('leadership.index')];
        $breadcrumbItems[] = ['@type' => 'ListItem', 'position' => 3, 'name' => $member->name, 'item' => $profileUrl];
    } else {
        $breadcrumbItems[] = ['@type' => 'ListItem', 'position' => 2, 'name' => $member->name, 'item' => $profileUrl];
    }
@endphp

@push('head')
    <script type="application/ld+json">
    {!! json_encode(array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Person',
        'name' => $member->name,
        'jobTitle' => $member->role,
        'description' => $metaDescription,
        'url' => $profileUrl,
        'image' => $metaImage,
        'worksFor' => [
            '@type' => 'Organization',
            'name' => $companyName,
            'url' => config('acremann.url'),
        ],
    ], fn (mixed $value): bool => $value !== null), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $breadcrumbItems,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

@section('content')
<section class="leadership-profile-hero section-padding" aria-labelledby="profile-heading">
    <div class="container-site">
        <nav class="leadership-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('about') }}">About</a>
            <span aria-hidden="true">/</span>
            @if($isLeadership)
                <a href="{{ route('leadership.index') }}">Leadership</a>
                <span aria-hidden="true">/</span>
            @endif
            <span aria-current="page">{{ $member->name }}</span>
        </nav>

        <div class="leadership-profile-header">
            <figure class="leadership-profile-portrait">
                <div class="leadership-profile-portrait-frame">
                    @if($url = $member->photoUrl())
                        <img src="{{ $url }}" alt="{{ $member->name }}" class="leadership-profile-photo">
                    @else
                        <span class="leadership-profile-initials" aria-hidden="true">{{ $member->initials() }}</span>
                    @endif
                </div>
            </figure>
            <div class="leadership-profile-intro">
                <p class="leadership-eyebrow">{{ $teamLabel }}</p>
                <h1 id="profile-heading" class="leadership-profile-name">{{ $member->name }}</h1>
                <p class="leadership-profile-role">{{ $member->role }}</p>
                @if($member->bio)
                    <div class="leadership-profile-bio prose prose-invert max-w-3xl">
                        {!! $member->bio !!}
                    </div>
                @elseif($member->plainBio())
                    <p class="leadership-profile-bio-plain">{{ $member->plainBio() }}</p>
                @endif
                <div class="leadership-profile-actions">
                    <a href="{{ route('contact') }}" class="btn-primary">Get in touch</a>
                    @if($isLeadership)
                        <a href="{{ route('leadership.index') }}" class="btn-outline leadership-btn-secondary">All leadership</a>
                    @else
                        <a href="{{ route('about') }}" class="btn-outline leadership-btn-secondary">About Acremann</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@if($otherMembers->isNotEmpty())
<section class="leadership-others-section section-padding" aria-labelledby="team-others-heading">
    <div class="container-site">
        <div class="leadership-others-header">
            <div class="leadership-others-intro">
                @if($isLeadership)
                    <p class="about-eyebrow-dark">Leadership team</p>
                    <h2 id="team-others-heading" class="about-section-title">Other leaders</h2>
                    <p class="about-section-lead about-section-lead-left">
                        Explore profiles of the directors and senior advisors guiding Acremann's work across Kenya and diaspora clients.
                    </p>
                @else
                    <p class="about-eyebrow-dark">Our team</p>
                    <h2 id="team-others-heading" class="about-section-title">Other specialists</h2>
                    <p class="about-section-lead about-section-lead-left">
                        Meet more of the advisory and sales team supporting buyers from enquiry through handover.
                    </p>
                @endif
            </div>
            @if($isLeadership)
                <a href="{{ route('leadership.index') }}" class="about-team-cta about-team-cta-desktop">
                    View all leadership
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            @else
                <a href="{{ route('about') }}" class="about-team-cta about-team-cta-desktop">
                    View full team
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            @endif
        </div>

        <div @class([
            'leadership-others-grid',
            'leadership-others-grid-single' => $otherMembers->count() === 1,
            'about-team-grid' => ! $isLeadership,
        ])>
            @foreach($otherMembers as $other)
                @if($isLeadership)
                    <x-leadership-profile-card :member="$other" />
                @else
                    <x-team-member-card :member="$other" />
                @endif
            @endforeach
        </div>

        <div class="leadership-others-footer">
            @if($isLeadership)
                <a href="{{ route('leadership.index') }}" class="about-team-cta about-team-cta-full">
                    View all leadership
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            @else
                <a href="{{ route('about') }}" class="about-team-cta about-team-cta-full">
                    View full team
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            @endif
        </div>
    </div>
</section>
@endif

@if($isLeadership)
<section class="leadership-legacy-section section-padding" aria-labelledby="leadership-legacy-heading">
    <div class="container-site">
        <div class="leadership-legacy-inner">
            <p class="leadership-legacy-eyebrow">Our leadership philosophy</p>
            <h2 id="leadership-legacy-heading" class="leadership-legacy-title">Together, Building Legacy Through Real Estate</h2>
            <div class="leadership-legacy-copy">
                <p>
                    At {{ $companyName }}, the leadership combines financial strategy, legal expertise, governance discipline, and a shared commitment to ethical, client-centered service delivery.
                </p>
                <p>
                    The firm was founded on a clear belief: that real estate should be transparent, professionally managed, legally secure, and intentionally structured to create long-term value for individuals, families, investors, and future generations.
                </p>
            </div>
            <div class="leadership-legacy-actions">
                <a href="{{ route('about') }}" class="btn-outline leadership-legacy-btn">About Acremann</a>
                <a href="{{ route('contact') }}" class="btn-primary leadership-legacy-btn-primary">Speak with our team</a>
            </div>
        </div>
    </div>
</section>
@else
<section class="about-cta-section section-padding" aria-label="Work with Acremann">
    <div class="container-site">
        <div class="about-cta-band">
            <div>
                <h2 class="about-cta-title">Ready to work with our team?</h2>
                <p class="about-cta-lead">Browse verified plots or book a site visit — our advisory specialists guide you from first enquiry to handover.</p>
            </div>
            <div class="about-cta-buttons">
                <a href="{{ route('properties.index') }}" class="btn-primary">View properties</a>
                <a href="{{ route('book-visit') }}" class="btn-outline about-btn-on-dark">Book a site visit</a>
            </div>
        </div>
    </div>
</section>
@endif
@endsection
