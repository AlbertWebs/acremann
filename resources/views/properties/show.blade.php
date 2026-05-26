@extends('layouts.app')
@php
    $metaTitle = $property->meta_title ?? $property->title;
    $metaDescription = $property->meta_description ?? $property->summary;
    $availability = $property->availabilitySummary();
    $waMessage = "Hello Acremann, I'm interested in {$property->title} at {$property->location}.";
    $heroSummary = filled($property->summary) ? strip_tags($property->summary) : null;

    $jumpLinks = array_values(array_filter([
        $property->galleryMedia()->isNotEmpty() ? ['href' => '#photos', 'label' => 'Photos'] : null,
        filled($property->description) ? ['href' => '#overview', 'label' => 'Overview'] : null,
        $property->plots->isNotEmpty() ? ['href' => '#plots', 'label' => 'Plots'] : null,
        $property->map_embed ? ['href' => '#location', 'label' => 'Location'] : null,
        $property->faqs->isNotEmpty() ? ['href' => '#faqs', 'label' => 'FAQs'] : null,
    ]));
@endphp
@section('content')
<section class="property-show-hero">
    <div class="container-site property-show-hero-inner">
        <nav class="property-show-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('properties.index') }}">Properties</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page">{{ $property->title }}</span>
        </nav>

        <div class="property-show-hero-main">
            <div class="property-show-hero-copy">
                <div class="property-show-meta">
                    <span class="property-show-chip">{{ ucfirst($property->category) }}</span>
                    <span class="property-show-chip">{{ $property->county }}</span>
                    <span class="property-show-chip">{{ ucfirst($property->title_type) }}</span>
                    @if($property->plot_size)
                        <span class="property-show-chip property-show-chip--muted">{{ $property->plot_size }}</span>
                    @endif
                </div>
                <h1 class="property-show-title">{{ $property->title }}</h1>
                <p class="property-show-location">{{ $property->location }}</p>
                @if($heroSummary)
                    <p class="property-show-lead">{{ $heroSummary }}</p>
                @endif
            </div>

            <div class="property-show-hero-aside">
                <p class="property-show-price">{{ $property->formattedPrice() }}</p>
                <x-property-availability :property="$property" class="mt-4" />
                <div class="property-show-hero-ctas">
                    <a href="{{ route('book-visit') }}" class="btn-primary property-show-cta">Book a site visit</a>
                    <a
                        href="{{ $settings->whatsappUrl($waMessage) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn-outline property-show-cta"
                        data-track="whatsapp_click"
                    >WhatsApp us</a>
                </div>
            </div>
        </div>

        @if($jumpLinks !== [])
            <nav class="property-show-jump" aria-label="On this page">
                @foreach($jumpLinks as $link)
                    <a href="{{ $link['href'] }}" class="property-show-jump-link">{{ $link['label'] }}</a>
                @endforeach
            </nav>
        @endif
    </div>
</section>

<section class="property-show-body section-padding pb-32">
    <div class="container-site property-show-layout grid gap-12 lg:grid-cols-3">
        <div class="property-show-content space-y-12 lg:col-span-2">
            @if($property->galleryMedia()->isNotEmpty())
                <x-property-gallery :property="$property" id="photos" />
            @endif

            @if($property->tour_embed_url)
                <x-property-show-section title="Virtual tour" eyebrow="Explore">
                    <div class="property-show-embed">
                        <iframe src="{{ $property->tour_embed_url }}" title="Virtual tour — {{ $property->title }}" class="h-full w-full" allowfullscreen loading="lazy"></iframe>
                    </div>
                </x-property-show-section>
            @endif

            @if(filled($property->description))
                <x-property-show-section id="overview" title="Overview" eyebrow="About this project">
                    <div class="property-show-prose">
                        {!! $property->description !!}
                    </div>
                </x-property-show-section>
            @endif

            @if($property->amenities)
                <x-property-show-section title="Amenities &amp; infrastructure" eyebrow="What you get">
                    <ul class="property-show-amenities">
                        @foreach($property->amenities as $amenity)
                            <li class="property-show-amenity">
                                <span class="property-show-amenity-icon" aria-hidden="true">✓</span>
                                <span>{{ $amenity }}</span>
                            </li>
                        @endforeach
                    </ul>
                </x-property-show-section>
            @endif

            @if(filled($property->title_process))
                <x-property-show-section title="Clean title &amp; process" eyebrow="Peace of mind">
                    <div class="property-show-callout property-show-callout--trust">
                        <div class="property-show-prose text-sm">
                            {!! $property->title_process !!}
                        </div>
                    </div>
                </x-property-show-section>
            @endif

            @if($property->plots->isNotEmpty())
                <x-property-show-section id="plots" title="Plot availability" eyebrow="Inventory">
                    <x-property-availability :property="$property" variant="compact" />
                    <div class="table-wrap mt-6">
                        <table class="acremann-table">
                            <thead>
                                <tr>
                                    <th>Plot</th>
                                    <th>Size</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($property->plots as $plot)
                                    <tr>
                                        <td>{{ $plot->plot_number }}</td>
                                        <td>{{ $plot->size ?: '—' }}</td>
                                        <td>{{ $plot->price ? 'KES '.number_format($plot->price, 0) : '—' }}</td>
                                        <td>
                                            <span @class([
                                                'table-badge',
                                                'table-badge-available' => $plot->status === 'available',
                                                'table-badge-reserved' => $plot->status === 'reserved',
                                                'table-badge-sold' => $plot->status === 'sold',
                                            ])>{{ ucfirst($plot->status) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-property-show-section>
            @endif

            @if($property->map_embed)
                <x-property-show-section id="location" title="Location" eyebrow="Getting there">
                    <div class="property-show-embed property-show-embed--map">
                        {!! $property->map_embed !!}
                    </div>
                    @if($property->distance_notes)
                        <ul class="property-show-distances">
                            @foreach(explode("\n", $property->distance_notes) as $note)
                                @if(filled(trim($note)))
                                    <li>{{ trim($note) }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </x-property-show-section>
            @endif

            @if($property->faqs->isNotEmpty())
                <x-property-show-section id="faqs" title="Project FAQs" eyebrow="Questions">
                    <div class="property-show-faqs">
                        @foreach($property->faqs as $faq)
                            <details class="property-show-faq">
                                <summary class="property-show-faq-question">{{ $faq->question }}</summary>
                                <div class="property-show-faq-answer">
                                    <p>{{ $faq->answer }}</p>
                                </div>
                            </details>
                        @endforeach
                    </div>
                </x-property-show-section>
            @endif

            @if(filled($property->investor_angle))
                <x-property-show-section title="Investor perspective" eyebrow="Why invest here">
                    <div class="property-show-callout property-show-callout--invest">
                        <div class="property-show-prose">
                            {!! $property->investor_angle !!}
                        </div>
                    </div>
                </x-property-show-section>
            @endif
        </div>

        <aside class="property-show-sidebar lg:col-span-1">
            <div class="property-show-sidebar-card property-show-sidebar-card--enquire hidden lg:block">
                <p class="property-show-sidebar-eyebrow">Interested?</p>
                <h3 class="property-show-sidebar-title">Enquire about this property</h3>
                <p class="property-show-sidebar-lead">Share your details and our team will follow up with pricing, availability, and site visit options.</p>
                <div class="mt-5">
                    <x-lead-form source="property_enquiry" :property="$property" />
                </div>
            </div>

            <div class="property-show-sidebar-card">
                <h3 class="property-show-sidebar-title">Quick actions</h3>
                <div class="property-show-sidebar-actions">
                    <a href="{{ route('book-visit') }}" class="btn-primary w-full justify-center">Book a site visit</a>
                    <a
                        href="{{ $settings->whatsappUrl($waMessage) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn-outline w-full justify-center"
                        data-track="whatsapp_click"
                    >Chat on WhatsApp</a>
                    @if($settings->phone)
                        <a href="tel:{{ $settings->phone }}" class="property-show-sidebar-link" data-track="call_click">{{ $settings->phone }}</a>
                    @endif
                </div>
            </div>

            <form action="{{ route('properties.brochure', $property) }}" method="POST" class="property-show-sidebar-card acremann-form">
                @csrf
                <h3 class="property-show-sidebar-title">Download brochure</h3>
                <p class="property-show-sidebar-lead">Get project details sent to your inbox.</p>
                <div class="mt-4 space-y-4">
                    <x-form.input label="Name" name="name" :required="true" placeholder="Your name" />
                    <x-form.input label="Email" name="email" type="email" :required="true" placeholder="you@example.com" />
                    <x-form.input label="Phone" name="phone" type="tel" :required="true" placeholder="+254…" />
                    <x-form.checkbox label="I consent to email follow-up." name="consent_email" :required="true" />
                    <button type="submit" class="btn btn-secondary w-full" data-track="brochure_download">Download brochure</button>
                </div>
            </form>

            <div class="property-show-sidebar-card property-show-sidebar-card--muted">
                <h3 class="property-show-sidebar-title">Why Acremann</h3>
                <ul class="property-show-trust-list">
                    <li>Verified titles &amp; transparent process</li>
                    <li>On-ground site visits in Kiambu &amp; beyond</li>
                    <li>Diaspora-friendly remote purchase support</li>
                </ul>
                <a href="{{ route('contact') }}" class="property-show-sidebar-link mt-4 inline-block">General contact →</a>
            </div>
        </aside>
    </div>

    @if($related->isNotEmpty())
        <div class="container-site property-show-related mt-16 pt-12">
            <p class="property-show-eyebrow">More from Acremann</p>
            <h2 class="property-show-section-title">Related properties</h2>
            <div class="mt-8 grid gap-6 md:grid-cols-3">
                @foreach($related as $p)
                    <x-property-card :property="$p" />
                @endforeach
            </div>
        </div>
    @endif
</section>
<x-sticky-lead-bar :settings="$settings" :property="$property" />
@endsection
