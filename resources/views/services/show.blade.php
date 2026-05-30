@extends('layouts.app')
@php
    $metaTitle = $service->seoTitle();
    $metaDescription = $service->seoDescription();
    $headerImageUrl = $service->headerImageUrl();
    $waMessage = "Hello Acremann, I would like to enquire about your {$service->title} service.";
    $localSummary = $service->plainLocalSummary() ?: 'Whether you are buying your first plot in Nairobi, Kiambu, Kikuyu or Nachu, or adding to an existing portfolio, we provide on-ground verification, transparent pricing, and advisory through handover.';
    $diasporaSummary = $service->plainDiasporaSummary() ?: 'Buying from the UK, US, UAE or elsewhere? We structure remote purchases with documented milestones, verified title packs, video walkthroughs, and clear communication across time zones.';

    $trustSignals = match ($service->slug) {
        'land-sales' => [
            ['label' => 'Verified listings', 'detail' => 'Clean-title plots across growth corridors'],
            ['label' => 'Site visits', 'detail' => 'On-ground or virtual walkthroughs'],
            ['label' => 'Transparent pricing', 'detail' => 'Documented payment milestones'],
        ],
        'investment-advisory' => [
            ['label' => 'Curated shortlists', 'detail' => 'Matched to budget & horizon'],
            ['label' => 'Due diligence', 'detail' => 'Title & encumbrance summaries'],
            ['label' => 'Portfolio view', 'detail' => 'Hold or exit guidance'],
        ],
        'conveyancing' => [
            ['label' => 'Official searches', 'detail' => 'Title & encumbrance checks'],
            ['label' => 'Advocate network', 'detail' => 'Qualified legal coordination'],
            ['label' => 'To registration', 'detail' => 'Tracked through completion'],
        ],
        'diaspora-support' => [
            ['label' => 'Remote-first', 'detail' => 'UK · US · UAE · Europe'],
            ['label' => 'Virtual visits', 'detail' => 'Video walkthroughs & beacons'],
            ['label' => 'Milestone updates', 'detail' => 'Plain-language progress reports'],
        ],
        default => [
            ['label' => 'Verified process', 'detail' => 'Documented from enquiry to handover'],
            ['label' => 'Local & diaspora', 'detail' => 'Advisory for buyers on-ground & abroad'],
            ['label' => 'Trusted guidance', 'detail' => 'Transparent, regulation-aligned support'],
        ],
    };

    $highlights = match ($service->slug) {
        'land-sales' => [
            ['title' => 'Clean title focus', 'body' => 'Every plot is presented with documented title status and official search coordination before you commit.'],
            ['title' => 'Growth corridors', 'body' => 'Residential and commercial land in Nairobi, Kiambu, Kikuyu and Nachu — with access and infrastructure context.'],
            ['title' => 'Flexible payments', 'body' => 'Clear pricing and milestone-based instalment plans where applicable, documented upfront.'],
        ],
        'investment-advisory' => [
            ['title' => 'Data-led shortlists', 'body' => 'Opportunities matched to your budget, timeline, and risk profile — not generic listing dumps.'],
            ['title' => 'Location intelligence', 'body' => 'Infrastructure, access, and corridor growth context for each recommendation.'],
            ['title' => 'End-to-end support', 'body' => 'Coordination with advocates and surveyors through reservation and registration.'],
        ],
        'conveyancing' => [
            ['title' => 'Title verification', 'body' => 'Official searches and encumbrance review before agreements are signed.'],
            ['title' => 'Plain-language milestones', 'body' => 'Sale agreements, charges, and timelines explained clearly at every stage.'],
            ['title' => 'Registration tracking', 'body' => 'Transfer and completion monitored until the title is in your name.'],
        ],
        'diaspora-support' => [
            ['title' => 'Buy from abroad', 'body' => 'Structured remote purchase with verified documentation and secure communication.'],
            ['title' => 'Virtual site visits', 'body' => 'Video walkthroughs, beacon checks, and surroundings reviewed with you live.'],
            ['title' => 'POA & milestones', 'body' => 'Power-of-attorney guidance and progress alerts across time zones.'],
        ],
        default => [
            ['title' => 'Professional advisory', 'body' => 'Experienced guidance from first conversation through to documented completion.'],
            ['title' => 'Transparent process', 'body' => 'Clear steps, pricing, and timelines — no hidden encumbrances.'],
            ['title' => 'Buyer-focused', 'body' => 'Support for local buyers, investors, and diaspora purchasers alike.'],
        ],
    };

    $processSteps = match ($service->slug) {
        'land-sales' => [
            ['step' => '01', 'title' => 'Shortlist', 'body' => 'Share your budget and location preferences — we curate verified plots with title context.'],
            ['step' => '02', 'title' => 'Site visit', 'body' => 'Walk the plot on-ground or join a virtual tour; access, beacons, and surroundings reviewed together.'],
            ['step' => '03', 'title' => 'Due diligence', 'body' => 'Official search, advocate review, and payment structure agreed before reservation.'],
            ['step' => '04', 'title' => 'Reservation', 'body' => 'Secure your plot with documented terms and a clear instalment or completion schedule.'],
            ['step' => '05', 'title' => 'Handover', 'body' => 'Title transfer and registration support through to documented completion.'],
        ],
        'investment-advisory' => [
            ['step' => '01', 'title' => 'Discovery', 'body' => 'Clarify investment goals, horizon, and capital allocation.'],
            ['step' => '02', 'title' => 'Analysis', 'body' => 'Market and corridor review with title-risk assessment.'],
            ['step' => '03', 'title' => 'Shortlist', 'body' => 'Curated plots with pricing, access, and hold/exit context.'],
            ['step' => '04', 'title' => 'Execution', 'body' => 'Site verification, legal coordination, and milestone tracking.'],
        ],
        'conveyancing' => [
            ['step' => '01', 'title' => 'Title search', 'body' => 'Official encumbrance and ownership verification.'],
            ['step' => '02', 'title' => 'Agreement', 'body' => 'Sale agreement structure, charges, and timelines explained.'],
            ['step' => '03', 'title' => 'Transfer', 'body' => 'Stamp duty, consent, and transfer documentation coordinated.'],
            ['step' => '04', 'title' => 'Registration', 'body' => 'Completion tracked until the title reflects your ownership.'],
        ],
        'diaspora-support' => [
            ['step' => '01', 'title' => 'Remote brief', 'body' => 'Goals, budget, and time zone — captured in a structured advisory call.'],
            ['step' => '02', 'title' => 'Virtual visit', 'body' => 'Live video walkthrough with beacon and access checks.'],
            ['step' => '03', 'title' => 'Legal pack', 'body' => 'Verified documents, POA guidance, and advocate coordination.'],
            ['step' => '04', 'title' => 'Milestones', 'body' => 'Payment and progress updates until registration completes.'],
        ],
        default => [
            ['step' => '01', 'title' => 'Enquiry', 'body' => 'Tell us your goals — we respond within one business day.'],
            ['step' => '02', 'title' => 'Advisory', 'body' => 'Curated options with transparent pricing and documentation.'],
            ['step' => '03', 'title' => 'Verification', 'body' => 'On-ground or virtual review before you commit.'],
            ['step' => '04', 'title' => 'Completion', 'body' => 'Documented handover and ongoing support as needed.'],
        ],
    };
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
            <div class="service-show-hero-copy">
                <div class="service-show-icon" aria-hidden="true">
                    @include('services.partials.icon', ['icon' => $service->icon, 'class' => 'h-7 w-7'])
                </div>
                <p class="service-show-eyebrow">Acremann service</p>
                <h1 id="service-show-heading" class="service-show-title">{{ $service->title }}</h1>
                <p class="service-show-lead">{{ $service->plainSummary() }}</p>
                <div class="service-show-hero-ctas">
                    <a href="{{ route('contact') }}" class="btn-primary">Enquire about this service</a>
                    <a href="{{ route('book-visit') }}" class="btn-outline service-btn-on-dark">Book a site visit</a>
                    <a href="{{ $settings->whatsappUrl($waMessage) }}" target="_blank" rel="noopener noreferrer" class="btn-outline service-btn-on-dark inline-flex items-center gap-2" data-track="whatsapp_click">
                        <x-icon-whatsapp class="h-5 w-5 shrink-0" />
                        WhatsApp
                    </a>
                </div>

                <ul class="service-show-trust-list" role="list">
                    @foreach($trustSignals as $signal)
                        <li class="service-show-trust-item">
                            <span class="service-show-trust-label">{{ $signal['label'] }}</span>
                            <span class="service-show-trust-detail">{{ $signal['detail'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <aside class="service-show-hero-panel" aria-label="Quick actions">
                <div class="service-show-panel-card">
                    <h2 class="service-show-panel-title">How can we help?</h2>
                    <p class="service-show-panel-lead">Typical enquiries receive a response within one business day.</p>
                    <ul class="service-show-panel-actions">
                        <li>
                            <a href="{{ route('properties.index') }}" class="service-show-panel-link group">
                                <span class="service-show-panel-link-text">
                                    <span class="service-show-panel-link-label">Browse available plots</span>
                                    <span class="service-show-panel-link-hint">Verified listings with clean titles</span>
                                </span>
                                <svg class="service-show-panel-link-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('book-visit') }}" class="service-show-panel-link group">
                                <span class="service-show-panel-link-text">
                                    <span class="service-show-panel-link-label">Schedule a site visit</span>
                                    <span class="service-show-panel-link-hint">On-ground or virtual walkthrough</span>
                                </span>
                                <svg class="service-show-panel-link-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('certifications') }}" class="service-show-panel-link group">
                                <span class="service-show-panel-link-text">
                                    <span class="service-show-panel-link-label">Review our credentials</span>
                                    <span class="service-show-panel-link-hint">Affiliations & compliance focus</span>
                                </span>
                                <svg class="service-show-panel-link-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                            </a>
                        </li>
                    </ul>
                    @if($settings->phone)
                        <p class="service-show-panel-phone">
                            Or call <a href="tel:{{ $settings->phone }}" class="service-show-panel-phone-link" data-track="call_click">{{ $settings->phone }}</a>
                        </p>
                    @endif
                </div>
            </aside>
        </div>
    </div>
</section>

<section class="service-show-highlights section-padding bg-gradient-to-b from-cream/60 to-white" aria-labelledby="service-highlights-heading">
    <div class="container-site">
        <div class="service-show-section-header">
            <p class="service-show-eyebrow-dark">Why choose this service</p>
            <h2 id="service-highlights-heading" class="service-show-section-title">What sets our {{ strtolower($service->title) }} apart</h2>
        </div>
        <div class="service-show-highlights-grid">
            @foreach($highlights as $index => $highlight)
                <article class="service-show-highlight-card">
                    <span class="service-show-highlight-number" aria-hidden="true">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                    <h3 class="service-show-highlight-title">{{ $highlight['title'] }}</h3>
                    <p class="service-show-highlight-body">{{ $highlight['body'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="service-show-audience section-padding bg-white" aria-label="Who this service is for">
    <div class="container-site">
        <div class="service-show-section-header service-show-section-header--left">
            <p class="service-show-eyebrow-dark">Built for every buyer</p>
            <h2 class="service-show-section-title">Local buyers & diaspora investors</h2>
        </div>
        <div class="service-show-audience-grid">
            <article class="service-show-audience-card service-show-audience-local">
                <div class="service-show-audience-icon" aria-hidden="true">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                </div>
                <p class="service-show-audience-label">Buyers in Kenya</p>
                <h3 class="service-show-audience-title">On-ground advisory</h3>
                <p class="service-show-audience-body">{{ $localSummary }}</p>
                <a href="{{ route('properties.index') }}" class="service-show-inline-link">Browse plots →</a>
            </article>
            <article class="service-show-audience-card service-show-audience-diaspora">
                <div class="service-show-audience-icon" aria-hidden="true">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c2.485 0 4.5-4.03 4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5a17.92 17.92 0 0 1-8.716-2.247m0 0A8.966 8.966 0 0 1 3 12c0-.778.099-1.533.284-2.253"/></svg>
                </div>
                <p class="service-show-audience-label">Diaspora investors</p>
                <h3 class="service-show-audience-title">Buy land from abroad</h3>
                <p class="service-show-audience-body">{{ $diasporaSummary }}</p>
                <a href="{{ route('invest') }}#diaspora" class="service-show-inline-link">Diaspora guidance →</a>
            </article>
        </div>
    </div>
</section>

<section class="service-show-process section-padding border-y border-charcoal/8 bg-forest text-cream" aria-labelledby="service-process-heading">
    <div class="container-site">
        <div class="service-show-section-header service-show-section-header--light">
            <p class="service-show-eyebrow">How it works</p>
            <h2 id="service-process-heading" class="service-show-section-title service-show-section-title--light">Your journey with Acremann</h2>
            <p class="service-show-section-lead service-show-section-lead--light">A clear, documented path from first enquiry to completion — whether you are on-ground or overseas.</p>
        </div>
        <ol class="service-show-process-list">
            @foreach($processSteps as $index => $step)
                <li @class(['service-show-process-step', 'service-show-process-step--gold' => $index % 2 === 1])>
                    <span class="service-show-process-number">{{ $step['step'] }}</span>
                    <h3 class="service-show-process-title">{{ $step['title'] }}</h3>
                    <p class="service-show-process-body">{{ $step['body'] }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>

@if(filled($service->body))
<section class="service-show-content section-padding bg-white" aria-label="Service details">
    <div class="container-site">
        <div class="service-show-content-layout">
            <aside class="service-show-sidebar" aria-label="Get in touch">
                <div class="service-show-sidebar-card">
                    <h2 class="service-show-sidebar-title">Speak to advisory</h2>
                    <p class="service-show-sidebar-lead">Questions about {{ strtolower($service->title) }}? We are here to help.</p>
                    <div class="service-show-sidebar-actions">
                        <a href="{{ route('contact') }}" class="btn-primary w-full justify-center">Contact us</a>
                        <a href="{{ $settings->whatsappUrl($waMessage) }}" target="_blank" rel="noopener noreferrer" class="btn-outline w-full justify-center inline-flex items-center gap-2" data-track="whatsapp_click">
                            <x-icon-whatsapp class="h-5 w-5 shrink-0" />
                            WhatsApp
                        </a>
                        <a href="{{ route('book-visit') }}" class="service-show-sidebar-link">Book a site visit →</a>
                    </div>
                    @if($settings->email)
                        <p class="service-show-sidebar-meta">
                            <a href="mailto:{{ $settings->email }}" class="service-show-sidebar-meta-link">{{ $settings->email }}</a>
                        </p>
                    @endif
                </div>
                <div class="service-show-sidebar-note">
                    <p class="service-show-sidebar-note-title">Clean title focus</p>
                    <p class="service-show-sidebar-note-body">Every Acremann transaction prioritises verified documentation and transparent conveyancing.</p>
                    <a href="{{ route('certifications') }}" class="service-show-inline-link">View credentials →</a>
                </div>
            </aside>
            <div class="service-show-content-main">
                <div class="service-show-prose prose prose-sm max-w-none">
                    {!! $service->body !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($featuredProperties->isNotEmpty())
<section class="service-show-properties section-padding bg-gradient-to-b from-cream/40 to-white" aria-labelledby="service-properties-heading">
    <div class="container-site">
        <div class="service-show-section-header service-show-section-header--split">
            <div>
                <p class="service-show-eyebrow-dark">Available now</p>
                <h2 id="service-properties-heading" class="service-show-section-title">Featured plots</h2>
                <p class="service-show-section-lead">Verified listings you can explore today — each with documented title status.</p>
            </div>
            <a href="{{ route('properties.index') }}" class="service-show-section-link">View all properties →</a>
        </div>
        <div class="service-show-properties-grid">
            @foreach($featuredProperties as $property)
                <x-property-card :property="$property" />
            @endforeach
        </div>
    </div>
</section>
@endif

@if($otherServices->isNotEmpty())
<section class="service-show-related section-padding border-t border-charcoal/8 bg-white" aria-labelledby="service-related-heading">
    <div class="container-site">
        <div class="service-show-section-header">
            <p class="service-show-eyebrow-dark">Explore more</p>
            <h2 id="service-related-heading" class="service-show-section-title">Other services</h2>
        </div>
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
