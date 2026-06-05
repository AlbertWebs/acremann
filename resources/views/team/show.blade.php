@extends('layouts.app')
@php
    $metaTitle = $member->seoTitle();
    $metaDescription = $member->seoDescription();
    $metaImage = $member->seoImageUrl();
    $metaType = 'profile';
    $profileUrl = route('leadership.show', $member);
    $companyName = $settings->company_name ?: 'Acremann Properties';
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
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'About', 'item' => route('about')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Leadership', 'item' => route('leadership.index')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $member->name, 'item' => $profileUrl],
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

@section('content')
<section class="leadership-profile-hero section-padding" aria-labelledby="profile-heading">
    <div class="container-site">
        <nav class="leadership-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('about') }}">About</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('leadership.index') }}">Leadership</a>
            <span aria-hidden="true">/</span>
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
                <p class="leadership-eyebrow">Leadership</p>
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
                    <a href="{{ route('leadership.index') }}" class="btn-outline leadership-btn-secondary">All leadership</a>
                </div>
            </div>
        </div>
    </div>
</section>

@if($otherLeaders->isNotEmpty())
<section class="leadership-others-section section-padding" aria-labelledby="leadership-others-heading">
    <div class="container-site">
        <div class="leadership-others-header">
            <div class="leadership-others-intro">
                <p class="about-eyebrow-dark">Leadership team</p>
                <h2 id="leadership-others-heading" class="about-section-title">Other leaders</h2>
                <p class="about-section-lead about-section-lead-left">
                    Explore profiles of the directors and senior advisors guiding Acremann’s work across Kenya and diaspora clients.
                </p>
            </div>
            <a href="{{ route('leadership.index') }}" class="about-team-cta about-team-cta-desktop">
                View all leadership
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>

        <div @class([
            'leadership-others-grid',
            'leadership-others-grid-single' => $otherLeaders->count() === 1,
        ])>
            @foreach($otherLeaders as $other)
                <x-leadership-profile-card :member="$other" />
            @endforeach
        </div>

        <div class="leadership-others-footer">
            <a href="{{ route('leadership.index') }}" class="about-team-cta about-team-cta-full">
                View all leadership
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif

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
@endsection
