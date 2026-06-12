@extends('layouts.app')
@php
    $metaTitle = ($page?->title ?? 'Invest in Kenya land') . ' | Investment advisory';
    $metaDescription = 'Verified plots, clean title deeds, and diaspora-friendly land investment in Nairobi, Kiambu, Kikuyu and Nachu. Advisory from shortlist to handover.';
    $waInvest = 'Hello Acremann, I would like to discuss land investment opportunities.';

    $audiences = [
        [
            'title' => 'End users',
            'body' => 'Secure clean-title land to build your home, with transparent pricing and conveyancing support through handover.',
            'icon' => 'home',
            'cta' => 'Find residential plots',
            'href' => route('properties.index'),
        ],
        [
            'title' => 'Investors',
            'body' => 'Capital appreciation in growth corridors near Nairobi and Kiambu, with data-led shortlists and documented due diligence.',
            'icon' => 'chart',
            'cta' => 'View investment listings',
            'href' => route('properties.index'),
        ],
        [
            'title' => 'Diaspora',
            'body' => 'Buy land in Kenya from abroad with milestone updates, verified documentation, and remote or on-ground verification.',
            'icon' => 'globe',
            'cta' => 'Diaspora advisory',
            'href' => '#diaspora',
        ],
        [
            'title' => 'Joint ventures',
            'body' => 'Partner with Acremann on strategic land assembly and development where alignment on title, planning, and community matters.',
            'icon' => 'partnership',
            'cta' => 'Discuss a partnership',
            'href' => route('contact') . '#enquire',
        ],
    ];

    $processSteps = [
        ['step' => '01', 'title' => 'Discovery', 'body' => 'We clarify your goals, budget, timeline, and risk profile — locally or across time zones.'],
        ['step' => '02', 'title' => 'Curated shortlist', 'body' => 'Verified plots with title status, pricing, payment plans, and location context — no generic listings dump.'],
        ['step' => '03', 'title' => 'Verification', 'body' => 'Site visit on the ground or guided virtual walkthrough; access, beacons, and surroundings reviewed with you.'],
        ['step' => '04', 'title' => 'Due diligence', 'body' => 'Legal review, sale agreement structure, and financing guidance before you commit capital.'],
        ['step' => '05', 'title' => 'Handover', 'body' => 'Documented completion, title transfer support, and clear records for your portfolio or family.'],
    ];

    $trustSignals = [
        ['label' => 'Clean title focus', 'detail' => 'Verified deeds & transparent conveyancing'],
        ['label' => 'Growth corridors', 'detail' => 'Nairobi · Kiambu · Kikuyu · Nachu'],
        ['label' => 'Diaspora-ready', 'detail' => 'Remote purchase & milestone updates'],
    ];
@endphp
@section('content')
<x-page-hero-image
    class="page-hero-image--overlay-dark"
    :eyebrow="$page?->subtitle ?? 'Investment advisory'"
    :title="$page?->title ?? 'Invest in Kenya land with confidence'"
    :lead="$settings->investmentIntro()"
    heading-id="invest-hero-heading"
    aside-label="Quick actions"
>
    <div class="page-hero-actions">
        <a href="{{ route('properties.index') }}" class="btn-primary page-hero-btn-primary">Explore properties</a>
        <a href="#advisory" class="btn-outline page-hero-btn-outline">Speak to an advisor</a>
        <a href="{{ $settings->whatsappUrl($waInvest) }}" target="_blank" rel="noopener noreferrer" class="btn-outline page-hero-btn-outline inline-flex items-center gap-2" data-track="whatsapp_click">
            <x-icon-whatsapp class="h-5 w-5 shrink-0" />
            WhatsApp
        </a>
    </div>

    <ul class="invest-trust-list" role="list">
        @foreach($trustSignals as $signal)
            <li class="invest-trust-item">
                <span class="invest-trust-label">{{ $signal['label'] }}</span>
                <span class="invest-trust-detail">{{ $signal['detail'] }}</span>
            </li>
        @endforeach
    </ul>

    <x-slot:aside>
        <div class="invest-hero-panel-card">
            <h2 class="invest-panel-title">Start your investment journey</h2>
            <p class="invest-panel-lead">Typical buyers hear back within one business day.</p>
            <ul class="invest-panel-actions">
                <li>
                    <a href="{{ route('book-visit') }}" class="invest-panel-link group">
                        <span class="invest-panel-link-text">
                            <span class="invest-panel-link-label">Book a site visit</span>
                            <span class="invest-panel-link-hint">On-ground or virtual walkthrough</span>
                        </span>
                        <svg class="invest-panel-link-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </a>
                </li>
                <li>
                    <a href="#advisory" class="invest-panel-link group">
                        <span class="invest-panel-link-text">
                            <span class="invest-panel-link-label">Request investment brief</span>
                            <span class="invest-panel-link-hint">Shortlist aligned to your budget</span>
                        </span>
                        <svg class="invest-panel-link-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </a>
                </li>
                <li>
                    <a href="{{ route('certifications') }}" class="invest-panel-link group">
                        <span class="invest-panel-link-text">
                            <span class="invest-panel-link-label">Review our credentials</span>
                            <span class="invest-panel-link-hint">Legal precision & affiliations</span>
                        </span>
                        <svg class="invest-panel-link-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </a>
                </li>
            </ul>
            @if($settings->phone)
                <p class="invest-panel-phone">
                    Or call <a href="tel:{{ $settings->phone }}" class="invest-panel-phone-link" data-track="call_click">{{ $settings->phone }}</a>
                </p>
            @endif
        </div>
    </x-slot:aside>
</x-page-hero-image>

{{-- Who we serve --}}
<section class="invest-audiences-section section-padding" aria-labelledby="invest-audiences-heading">
    <div class="container-site">
        <div class="about-team-header">
            <div class="about-team-intro">
                <p class="about-eyebrow-dark">Who we serve</p>
                <h2 id="invest-audiences-heading" class="about-section-title">Built for every serious land buyer</h2>
                <p class="about-section-lead about-section-lead-left">From first-time homeowners to institutional capital and diaspora families — the same standards of title verification and advisory discipline apply.</p>
            </div>
            <div class="about-team-cta-group about-team-cta-desktop">
                <a href="{{ route('properties.index') }}" class="about-team-cta">
                    Explore properties
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
                <a href="#advisory" class="about-team-cta about-team-cta-secondary">
                    Speak to an advisor
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
        </div>

        <p class="invest-section-grid-label">Four buyer profiles</p>
        <div class="invest-audiences-grid">
            @foreach($audiences as $index => $audience)
                <article @class([
                    'invest-audience-card',
                    'invest-audience-card--forest' => $index % 2 === 0,
                    'invest-audience-card--gold' => $index % 2 === 1,
                ])>
                    <div @class([
                        'invest-audience-icon',
                        'invest-audience-icon--gold' => $index % 2 === 1,
                    ]) aria-hidden="true">
                        @if($audience['icon'] === 'home')
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                        @elseif($audience['icon'] === 'chart')
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 18 9 11.25l4.306 4.307a11.95 11.95 0 0 1 5.814-5.519l2.74-1.22m0 0-5.94-2.28m5.94 2.28-2.28 5.941"/></svg>
                        @elseif($audience['icon'] === 'globe')
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5a17.92 17.92 0 0 1-8.716-2.247m0 0A8.966 8.966 0 0 1 3 12c0-.778.099-1.533.284-2.253"/></svg>
                        @else
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                        @endif
                    </div>
                    <h3 class="invest-audience-title">{{ $audience['title'] }}</h3>
                    <p class="invest-audience-body">{{ $audience['body'] }}</p>
                    <a href="{{ $audience['href'] }}" class="invest-audience-cta">
                        {{ $audience['cta'] }}
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </a>
                </article>
            @endforeach
        </div>

        <div class="about-team-footer invest-section-footer">
            <a href="{{ route('properties.index') }}" class="about-team-cta about-team-cta-full">
                Explore properties
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- Process --}}
<section class="invest-process-section section-padding" aria-labelledby="invest-process-heading">
    <div class="container-site">
        <div class="about-team-header">
            <div class="about-team-intro">
                <p class="about-eyebrow-dark">How we work</p>
                <h2 id="invest-process-heading" class="about-section-title">A disciplined path from enquiry to title</h2>
                <p class="about-section-lead about-section-lead-left">Institutional-grade process without institutional friction — clear milestones at every stage.</p>
            </div>
            <div class="about-team-cta-group about-team-cta-desktop">
                <a href="{{ route('book-visit') }}" class="about-team-cta">
                    Book a site visit
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
                <a href="{{ route('services') }}" class="about-team-cta about-team-cta-secondary">
                    View all services
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
        </div>

        <p class="invest-section-grid-label">Five stages</p>
        <ol class="invest-process-list">
            @foreach($processSteps as $index => $step)
                <li @class([
                    'invest-process-step',
                    'invest-process-step--forest' => $index % 2 === 0,
                    'invest-process-step--gold' => $index % 2 === 1,
                ])>
                    <span @class([
                        'invest-process-number',
                        'invest-process-number--gold' => $index % 2 === 1,
                    ]) aria-hidden="true">{{ $step['step'] }}</span>
                    <h3 class="invest-process-title">{{ $step['title'] }}</h3>
                    <p class="invest-process-body">{{ $step['body'] }}</p>
                </li>
            @endforeach
        </ol>

        <div class="about-team-footer invest-section-footer">
            <a href="{{ route('book-visit') }}" class="about-team-cta about-team-cta-full">
                Book a site visit
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

@if($page?->content)
<section class="invest-insight-section section-padding" aria-label="Investment perspective">
    <div class="container-site">
        <div class="invest-insight">
            <div class="invest-insight-accent" aria-hidden="true"></div>
            <div class="invest-insight-body prose prose-lg max-w-none">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</section>
@endif

{{-- Diaspora --}}
<section id="diaspora" class="invest-diaspora section-padding" aria-labelledby="invest-diaspora-heading">
    <div class="container-site">
        <div class="invest-diaspora-grid">
            <div>
                <p class="invest-eyebrow">Diaspora investors</p>
                <h2 id="invest-diaspora-heading" class="invest-diaspora-title">Buy land in Kenya from anywhere in the world</h2>
                <p class="invest-diaspora-lead">Time zones should not weaken your due diligence. We structure remote purchases with documented milestones, verified title packs, and regular progress updates — so you invest with the same clarity as if you were on site.</p>
                <ul class="invest-diaspora-list">
                    <li>Video walkthroughs and beacon checks before you wire funds</li>
                    <li>Sale agreements and payment schedules explained in plain language</li>
                    <li>Coordination with advocates and surveyors through handover</li>
                </ul>
                <div class="invest-diaspora-ctas">
                    <a href="{{ $settings->whatsappUrl('Hello Acremann, I am a diaspora buyer interested in Kenya land investment.') }}" target="_blank" rel="noopener noreferrer" class="btn-outline invest-btn-on-dark inline-flex items-center gap-2" data-track="whatsapp_click">
                        <x-icon-whatsapp class="h-5 w-5 shrink-0" />
                        WhatsApp our diaspora desk
                    </a>
                    <a href="{{ route('book-visit') }}" class="btn-outline invest-btn-on-dark">Schedule virtual visit</a>
                </div>
            </div>
            <div class="invest-diaspora-aside">
                <div class="invest-diaspora-card">
                    <h3 class="font-serif text-xl text-cream">What you'll receive</h3>
                    <ul class="mt-4 space-y-3 text-sm text-cream/80">
                        <li class="flex gap-2"><span class="text-gold" aria-hidden="true">✓</span> Curated shortlist matched to budget & horizon</li>
                        <li class="flex gap-2"><span class="text-gold" aria-hidden="true">✓</span> Title & encumbrance summary per plot</li>
                        <li class="flex gap-2"><span class="text-gold" aria-hidden="true">✓</span> Milestone timeline from offer to registration</li>
                        <li class="flex gap-2"><span class="text-gold" aria-hidden="true">✓</span> Direct line to your advisory contact</li>
                    </ul>
                    <a href="{{ route('faqs') }}" class="invest-diaspora-faq-link">Investment FAQs →</a>
                </div>
            </div>
        </div>
    </div>
</section>

@if($featuredProperties->isNotEmpty())
<section class="invest-section section-padding bg-white" aria-labelledby="invest-properties-heading">
    <div class="container-site">
        <div class="invest-section-header invest-section-header-row">
            <div>
                <p class="invest-eyebrow invest-eyebrow-dark">Current opportunities</p>
                <h2 id="invest-properties-heading" class="invest-section-title">Featured investment properties</h2>
                <p class="invest-section-lead">Verified listings with transparent pricing — explore title status and location context on each property page.</p>
            </div>
            <a href="{{ route('properties.index') }}" class="featured-projects-cta hidden shrink-0 md:inline-flex">
                View all properties
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>
        <div class="featured-projects-grid">
            @foreach($featuredProperties as $property)
                <x-property-card :property="$property" />
            @endforeach
        </div>
        <div class="featured-projects-footer">
            <a href="{{ route('properties.index') }}" class="featured-projects-cta featured-projects-cta-full">Browse all properties</a>
        </div>
    </div>
</section>
@endif

@if($testimonials->isNotEmpty())
<section class="invest-section section-padding border-t border-charcoal/8 bg-cream/30" aria-labelledby="invest-testimonials-heading">
    <div class="container-site">
        <p class="invest-eyebrow invest-eyebrow-dark">Client perspective</p>
        <h2 id="invest-testimonials-heading" class="invest-section-title">Trusted by buyers at home and abroad</h2>
        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @foreach($testimonials as $t)
                <blockquote class="card">
                    <p class="font-serif text-lg italic leading-relaxed text-charcoal">"{{ $t->quote }}"</p>
                    <footer class="mt-4 text-sm text-muted">
                        — {{ $t->client_name }}
                        @if($t->client_detail)<span class="block text-xs">{{ $t->client_detail }}</span>@endif
                    </footer>
                </blockquote>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Advisory form --}}
<section id="advisory" class="invest-advisory-section section-padding" aria-labelledby="invest-advisory-heading">
    <div class="container-site">
        <div class="about-team-header">
            <div class="about-team-intro">
                <p class="about-eyebrow-dark">Get started</p>
                <h2 id="invest-advisory-heading" class="about-section-title">Request investment advisory</h2>
                <p class="about-section-lead about-section-lead-left">Share your goals and we'll respond with a tailored shortlist — no obligation, advisory-first.</p>
            </div>
            <div class="about-team-cta-group about-team-cta-desktop">
                <a href="{{ route('properties.index') }}" class="about-team-cta">
                    Explore properties
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
                <a href="{{ route('book-visit') }}" class="about-team-cta about-team-cta-secondary">
                    Book a site visit
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
        </div>

        <div class="invest-advisory-grid">
            <div class="invest-advisory-aside">
                <div class="invest-advisory-panel invest-advisory-panel--forest">
                    <p class="invest-advisory-panel-label">What you get</p>
                    <p class="invest-advisory-badge">
                        <svg class="h-4 w-4 shrink-0 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Typical response within one business day
                    </p>

                    <ul class="invest-advisory-benefits" role="list">
                        <li>
                            <svg class="invest-advisory-check" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Curated shortlist matched to your budget and timeline
                        </li>
                        <li>
                            <svg class="invest-advisory-check" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Title status and location context for every plot
                        </li>
                        <li>
                            <svg class="invest-advisory-check" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            No obligation — speak with us before you commit
                        </li>
                    </ul>
                </div>

                <div class="invest-advisory-panel invest-advisory-panel--gold">
                    <p class="invest-advisory-panel-label">Prefer a conversation first?</p>
                    <ul class="invest-advisory-channels">
                        @if($settings->phone)
                            <li>
                                <a href="tel:{{ $settings->phone }}" class="invest-advisory-channel group" data-track="call_click">
                                    <span class="invest-advisory-channel-icon" aria-hidden="true">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.352.47-.98.642-1.496.383a12.04 12.04 0 01-5.801-5.801c-.259-.516-.087-1.144.383-1.496l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 6.75z"/></svg>
                                    </span>
                                    <span class="invest-advisory-channel-text">
                                        <span class="invest-advisory-channel-label">Phone</span>
                                        <span class="invest-advisory-channel-value">{{ $settings->phone }}</span>
                                    </span>
                                    <svg class="invest-advisory-channel-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                                </a>
                            </li>
                        @endif
                        @if($settings->email)
                            <li>
                                <a href="mailto:{{ $settings->email }}" class="invest-advisory-channel group">
                                    <span class="invest-advisory-channel-icon" aria-hidden="true">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                    </span>
                                    <span class="invest-advisory-channel-text">
                                        <span class="invest-advisory-channel-label">Email</span>
                                        <span class="invest-advisory-channel-value">{{ $settings->email }}</span>
                                    </span>
                                    <svg class="invest-advisory-channel-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                                </a>
                            </li>
                        @endif
                        @if($settings->whatsapp)
                            <li>
                                <a href="{{ $settings->whatsappUrl($waInvest) }}" target="_blank" rel="noopener noreferrer" class="invest-advisory-channel invest-advisory-channel-whatsapp group" data-track="whatsapp_click">
                                    <span class="invest-advisory-channel-icon invest-advisory-channel-icon-whatsapp" aria-hidden="true">
                                        <x-icon-whatsapp class="h-5 w-5" />
                                    </span>
                                    <span class="invest-advisory-channel-text">
                                        <span class="invest-advisory-channel-label">WhatsApp</span>
                                        <span class="invest-advisory-channel-value">Message our advisory desk</span>
                                    </span>
                                    <svg class="invest-advisory-channel-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('book-visit') }}" class="invest-advisory-channel group">
                                <span class="invest-advisory-channel-icon" aria-hidden="true">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                </span>
                                <span class="invest-advisory-channel-text">
                                    <span class="invest-advisory-channel-label">Site visit</span>
                                    <span class="invest-advisory-channel-value">On-ground or virtual walkthrough</span>
                                </span>
                                <svg class="invest-advisory-channel-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="invest-advisory-aside-ctas about-team-cta-group hidden md:flex">
                    <a href="{{ route('sustainability') }}" class="about-team-cta">
                        Our sustainability approach
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div id="enquire" class="form-card invest-advisory-form-card invest-advisory-panel invest-advisory-panel--gold">
                @if(session('success'))
                    <p class="mb-6 rounded-sm border border-forest/20 bg-forest/5 px-4 py-3 text-sm text-forest">{{ session('success') }}</p>
                @endif
                <p class="invest-advisory-panel-label">Investment enquiry</p>
                <h3 class="invest-advisory-form-title">Tell us about your goals</h3>
                <p class="invest-advisory-form-lead">We typically respond within one business day.</p>
                <div class="mt-6">
                    <x-lead-form
                        source="invest"
                        submit-label="Request advisory call"
                        message-label="Investment goals & timeline"
                        message-placeholder="e.g. diaspora buyer, KES 3–5M budget, 12-month horizon, prefer Kiambu or Nachu…"
                    />
                </div>
            </div>
        </div>

        <div class="about-team-footer invest-section-footer">
            <a href="{{ route('book-visit') }}" class="about-team-cta about-team-cta-full">
                Book a site visit
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endsection
