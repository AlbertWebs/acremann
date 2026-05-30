@extends('layouts.app')
@php
    $metaTitle = 'Sustainability | Sustainable real estate Kenya';
    $metaDescription = 'Responsible land use, green open spaces, solar-ready planning, and ethical stewardship across Acremann developments in Nairobi, Kiambu, Kikuyu and Nachu.';

    $pillars = [
        [
            'title' => 'Responsible land use',
            'body' => 'Plotting and infrastructure planned to protect drainage, access, and long-term usability — not just short-term sales.',
            'icon' => 'land',
        ],
        [
            'title' => 'Green & open spaces',
            'body' => 'Reserved green corridors and communal areas that improve liveability and long-term value for residents.',
            'icon' => 'leaf',
        ],
        [
            'title' => 'Solar-ready infrastructure',
            'body' => 'Layouts and service routes designed so homes and amenities can adopt solar and efficient power over time.',
            'icon' => 'solar',
        ],
        [
            'title' => 'Water-conscious design',
            'body' => 'Drainage, grading, and retention considered early to reduce erosion and protect neighbouring plots.',
            'icon' => 'water',
        ],
        [
            'title' => 'Community amenities',
            'body' => 'Shared access, lighting, and practical amenities that support safe, connected neighbourhoods.',
            'icon' => 'community',
        ],
        [
            'title' => 'Ethical compliance',
            'body' => 'Title verification, transparent conveyancing, and advisory discipline aligned with Kenyan regulation.',
            'icon' => 'shield',
        ],
    ];
@endphp
@section('content')
{{-- Hero --}}
<section class="sustain-hero sustain-hero--has-image section-padding" aria-labelledby="sustain-hero-heading">
    <div class="sustain-hero-media" aria-hidden="true">
        <img src="{{ asset('bg/APL105.jpg') }}" alt="" class="sustain-hero-image" fetchpriority="high">
        <div class="sustain-hero-overlay"></div>
    </div>
    <div class="sustain-hero-glow" aria-hidden="true"></div>
    <div class="container-site sustain-hero-inner">
        <div class="sustain-hero-grid">
            <div class="sustain-hero-copy">
                <p class="sustain-eyebrow">Sustainability</p>
                <h1 id="sustain-hero-heading" class="sustain-hero-title">Land investment for future generations</h1>
                <p class="sustain-hero-lead">{{ $settings->sustainabilityIntro() }}</p>
                <div class="sustain-hero-ctas">
                    <a href="{{ route('properties.index') }}" class="btn-primary">View sustainable projects</a>
                    <a href="{{ route('contact') }}" class="btn-outline sustain-btn-on-dark">Speak to our team</a>
                </div>
            </div>
            <div class="sustain-hero-aside" aria-label="Our commitments">
                <div class="sustain-hero-card">
                    <p class="sustain-hero-card-eyebrow">Our commitment</p>
                    <h2 class="sustain-hero-card-title">Built into every project</h2>
                    <ul class="sustain-hero-stats" role="list">
                        <li class="sustain-hero-stat">
                            <span class="sustain-hero-stat-icon" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
                                </svg>
                            </span>
                            <span class="sustain-hero-stat-text">
                                <span class="sustain-hero-stat-value">Verified</span>
                                <span class="sustain-hero-stat-label">Title &amp; compliance focus</span>
                            </span>
                        </li>
                        <li class="sustain-hero-stat">
                            <span class="sustain-hero-stat-icon" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5a17.92 17.92 0 0 1-8.716-2.247m0 0A8.966 8.966 0 0 1 3 12c0-.778.099-1.533.284-2.253"/>
                                </svg>
                            </span>
                            <span class="sustain-hero-stat-text">
                                <span class="sustain-hero-stat-value">Planned</span>
                                <span class="sustain-hero-stat-label">Green &amp; drainage design</span>
                            </span>
                        </li>
                        <li class="sustain-hero-stat">
                            <span class="sustain-hero-stat-icon" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                                </svg>
                            </span>
                            <span class="sustain-hero-stat-text">
                                <span class="sustain-hero-stat-value">Documented</span>
                                <span class="sustain-hero-stat-label">Milestones to handover</span>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Pillars --}}
<section class="sustain-pillars-section section-padding" aria-labelledby="sustain-pillars-heading">
    <div class="container-site">
        <div class="sustain-pillars-header">
            <div class="sustain-pillars-intro">
                <p class="sustain-eyebrow-dark">Our approach</p>
                <h2 id="sustain-pillars-heading" class="sustain-section-title">How we develop responsibly</h2>
                <p class="about-section-lead about-section-lead-left">Six principles shape planning, infrastructure, and community outcomes on every Acremann listing.</p>
            </div>
            <div class="about-team-cta-group about-team-cta-desktop sustain-pillars-actions">
                <a href="{{ route('properties.index') }}" class="about-team-cta">
                    View projects
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
                <a href="{{ route('contact') }}" class="about-team-cta about-team-cta-secondary">
                    Speak to our team
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
        </div>

        <p class="sustain-pillars-grid-label">Six principles</p>
        <div class="sustain-pillars-grid">
            @foreach($pillars as $index => $pillar)
                <article @class([
                    'sustain-pillar-card',
                    'sustain-pillar-card--forest' => $index % 2 === 0,
                    'sustain-pillar-card--gold' => $index % 2 === 1,
                ])>
                    <div @class([
                        'sustain-pillar-icon',
                        'sustain-pillar-icon--gold' => $index % 2 === 1,
                    ]) aria-hidden="true">
                        @if($pillar['icon'] === 'land')
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 21h19.5M4.5 21V9.75A2.25 2.25 0 0 1 6.75 7.5h10.5A2.25 2.25 0 0 1 19.5 9.75V21M6 21v-4.5h12V21"/></svg>
                        @elseif($pillar['icon'] === 'leaf')
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3s-4.5 4.03-4.5 9 4.015 9 9 9"/></svg>
                        @elseif($pillar['icon'] === 'solar')
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/></svg>
                        @elseif($pillar['icon'] === 'water')
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3c4.97 0 9 3.582 9 8 0 1.657-.672 3.157-1.757 4.243M12 21V11.25M8.25 15.75 12 21l3.75-5.25"/></svg>
                        @elseif($pillar['icon'] === 'community')
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                        @else
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>
                        @endif
                    </div>
                    <h3 class="sustain-pillar-title">{{ $pillar['title'] }}</h3>
                    <p class="sustain-pillar-body">{{ $pillar['body'] }}</p>
                </article>
            @endforeach
        </div>

        <div class="about-team-footer sustain-pillars-footer">
            <a href="{{ route('properties.index') }}" class="about-team-cta about-team-cta-full">
                View sustainable projects
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

@if($impactMarkers->isNotEmpty())
@php
    $impactIcon = function (string $marker): string {
        $text = strtolower($marker);

        if (str_contains($text, 'tree') || str_contains($text, 'green') || str_contains($text, 'plant')) {
            return 'leaf';
        }

        if (str_contains($text, 'solar') || str_contains($text, 'power') || str_contains($text, 'energy')) {
            return 'solar';
        }

        if (str_contains($text, 'drain') || str_contains($text, 'water')) {
            return 'water';
        }

        if (str_contains($text, 'community') || str_contains($text, 'access') || str_contains($text, 'road')) {
            return 'community';
        }

        return 'shield';
    };
@endphp
<section class="sustain-impact-section section-padding" aria-labelledby="sustain-impact-heading">
    <div class="sustain-impact-bg" aria-hidden="true"></div>
    <div class="container-site sustain-impact-container">
        <div class="sustain-impact-panel">
            <div class="sustain-impact-layout">
                <div class="sustain-impact-copy">
                    <p class="sustain-impact-eyebrow">On the ground</p>
                    <h2 id="sustain-impact-heading" class="sustain-impact-title">Impact across our developments</h2>
                    <p class="sustain-impact-lead">Real markers from active Acremann projects, updated as new phases launch.</p>

                    <dl class="sustain-impact-stats" aria-label="Impact summary">
                        <div class="sustain-impact-stat">
                            <dt class="sustain-impact-stat-value">{{ $impactMarkers->count() }}</dt>
                            <dd class="sustain-impact-stat-label">Live commitments</dd>
                        </div>
                        <div class="sustain-impact-stat">
                            <dt class="sustain-impact-stat-value">{{ $impactPropertyCount }}</dt>
                            <dd class="sustain-impact-stat-label">Projects reporting</dd>
                        </div>
                    </dl>

                    <a href="{{ route('properties.index') }}" class="btn-primary sustain-impact-cta">
                        Explore sustainable projects
                    </a>
                </div>

                <div class="sustain-impact-board" aria-label="Sustainability commitments">
                    <p class="sustain-impact-board-label">What buyers see on site</p>
                    <ul class="sustain-impact-cards" role="list">
                        @foreach($impactMarkers as $index => $marker)
                            @php($icon = $impactIcon($marker))
                            <li
                                class="sustain-impact-card sustain-impact-card--{{ $icon }}"
                                style="--impact-i: {{ $index }}"
                            >
                                <span class="sustain-impact-card-icon" aria-hidden="true">
                                    @if($icon === 'leaf')
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3s-4.5 4.03-4.5 9 4.015 9 9 9"/></svg>
                                    @elseif($icon === 'solar')
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/></svg>
                                    @elseif($icon === 'water')
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3c4.97 0 9 3.582 9 8 0 1.657-.672 3.157-1.757 4.243M12 21V11.25"/></svg>
                                    @elseif($icon === 'community')
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                    @else
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>
                                    @endif
                                </span>
                                <span class="sustain-impact-card-text">{{ $marker }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($settings->csr_statement)
<section class="sustain-csr-section section-padding bg-white" aria-labelledby="sustain-csr-heading">
    <div class="container-site">
        <div class="sustain-csr-card">
            <div class="sustain-csr-accent" aria-hidden="true"></div>
            <div class="sustain-csr-body">
                <p class="sustain-eyebrow-dark">CSR</p>
                <h2 id="sustain-csr-heading" class="sustain-csr-title">Community &amp; stewardship</h2>
                <p class="sustain-csr-text">{{ $settings->csrStatement() }}</p>
                <div class="sustain-csr-actions">
                    <a href="{{ route('certifications') }}" class="btn-outline">Our credentials</a>
                    <a href="{{ route('invest') }}" class="sustain-inline-cta">Investment approach →</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<section class="sustain-cta-section section-padding" aria-label="Get in touch">
    <div class="container-site">
        <div class="sustain-cta-band">
            <div>
                <h2 class="sustain-cta-title">Planning a purchase with legacy in mind?</h2>
                <p class="sustain-cta-lead">Book a site visit or speak with advisory — we'll walk you through sustainability features plot by plot.</p>
            </div>
            <div class="sustain-cta-buttons">
                <a href="{{ route('book-visit') }}" class="btn-primary">Book a site visit</a>
                <a href="{{ route('contact') }}" class="btn-outline sustain-btn-on-dark">Contact us</a>
            </div>
        </div>
    </div>
</section>
@endsection
