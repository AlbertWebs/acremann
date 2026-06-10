<section class="featured-projects-section section-padding" aria-labelledby="featured-properties-heading">
    <div class="container-site">
        <div class="featured-projects-header">
            <div class="featured-projects-intro">
                <p class="featured-projects-eyebrow">Current projects</p>
                <h2 id="featured-properties-heading" class="featured-projects-title">Featured properties</h2>
                <p class="featured-projects-lead">
                    Verified plots across Nairobi, Kiambu, Kikuyu and Nachu — clean title deeds, transparent pricing, and advisory support from enquiry to handover.
                </p>
                @if($featuredProperties->isNotEmpty())
                    <p class="featured-projects-count">{{ $featuredProperties->count() }} {{ Str::plural('listing', $featuredProperties->count()) }} shown</p>
                @endif
            </div>
            <a href="{{ route('properties.index') }}" class="featured-projects-cta hidden shrink-0 md:inline-flex">
                View all properties
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>

        @if($featuredProperties->isNotEmpty())
            <div class="featured-projects-grid">
                @foreach($featuredProperties as $property)
                    <x-property-card :property="$property" />
                @endforeach
            </div>
            <div class="featured-projects-footer">
                <a href="{{ route('properties.index') }}" class="featured-projects-cta featured-projects-cta-full">
                    Browse all properties
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>
        @else
            <div class="featured-projects-empty card text-center">
                <p class="font-serif text-xl text-forest">Listings coming soon</p>
                <p class="mt-2 text-sm text-muted">Contact us to hear about upcoming plots and off-market opportunities.</p>
                <a href="{{ route('book-visit') }}" class="btn-primary mt-6 inline-flex">Book a site visit</a>
            </div>
        @endif
    </div>
</section>

@php
    $valuePillars = [
        [
            'title' => 'Clean title promise',
            'body' => 'Verified land for sale with transparent conveyancing and legal precision at every step.',
            'href' => route('certifications'),
            'link' => 'Our credentials',
            'icon' => 'document',
        ],
        [
            'title' => 'Advisory-led',
            'body' => 'Professional property advisory in Kenya — from site visits and due diligence to financing guidance.',
            'href' => route('services'),
            'link' => 'Our services',
            'icon' => 'advisory',
        ],
        [
            'title' => 'Diaspora ready',
            'body' => 'Buy land in Kenya from abroad with secure, documented remote purchase support and clear milestones.',
            'href' => route('invest'),
            'link' => 'Invest with us',
            'icon' => 'globe',
        ],
    ];
@endphp

<section class="value-pillars-section section-padding" aria-labelledby="value-pillars-heading">
    <div class="container-site">
        <div class="value-pillars-header">
            <p class="value-pillars-eyebrow">Why Acremann</p>
            <h2 id="value-pillars-heading" class="value-pillars-title">Trust, titles, and advice you can rely on</h2>
            <p class="value-pillars-lead">Three commitments behind every plot we list — for local buyers, investors, and diaspora purchasers alike.</p>
        </div>

        <div class="value-pillars-grid">
            @foreach($valuePillars as $pillar)
                <article class="value-pillar-card">
                    <div class="value-pillar-icon" aria-hidden="true">
                        @if($pillar['icon'] === 'document')
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.375 3.375 0 11-6.75 0 3.375 3.375 0 01-6.75 0 3.375 3.375 0 01-3.068-1.593A11.97 11.97 0 013 12c0-1.268.63-2.39 1.593-3.068a3.375 3.375 0 116.75 0 3.375 3.375 0 016.75 0 3.375 3.375 0 013.068 1.593A11.97 11.97 0 0121 12z"/>
                            </svg>
                        @elseif($pillar['icon'] === 'advisory')
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                            </svg>
                        @else
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5a17.92 17.92 0 01-8.716-2.247m0 0A8.966 8.966 0 013 12c0-.778.099-1.533.284-2.253"/>
                            </svg>
                        @endif
                    </div>
                    <h3 class="value-pillar-title">{{ $pillar['title'] }}</h3>
                    <p class="value-pillar-body">{{ $pillar['body'] }}</p>
                    <a href="{{ $pillar['href'] }}" class="value-pillar-link">
                        {{ $pillar['link'] }}
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                        </svg>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>

@if($testimonials->isNotEmpty())
    <x-testimonials-carousel :testimonials="$testimonials" />
@endif

@if($certifications->isNotEmpty())
    <x-certifications-section :certifications="$certifications" />
@endif

<section class="section-padding">
    <div class="container-site grid gap-12 lg:grid-cols-2">
        <div>
            <p class="text-sm text-gold">Sustainability</p>
            <h2 class="mt-2 text-3xl">Land investment for future generations</h2>
            <p class="mt-4 text-muted">{{ Str::limit($settings->sustainabilityIntro(), 300) }}</p>
            <a href="{{ route('sustainability') }}" class="mt-6 inline-block text-forest">Our sustainability story →</a>
        </div>
        @if($team->isNotEmpty())
        <div class="home-team-preview">
            <p class="home-team-eyebrow">Our team</p>
            <h2 class="home-team-title">People you can trust</h2>
            <p class="home-team-lead">Advisors who guide you from first enquiry through title handover.</p>
            <div class="home-team-grid">
                @foreach($team as $member)
                    <x-team-member-card :member="$member" variant="compact" />
                @endforeach
            </div>
            <a href="{{ route('about') }}" class="home-team-link">
                Meet the full team
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>
        @endif
    </div>
</section>

@if($posts->isNotEmpty())
<section class="home-insights-section section-padding" aria-labelledby="home-insights-heading">
    <div class="container-site">
        <div class="home-insights-header">
            <div class="home-insights-intro">
                <p class="home-insights-eyebrow">Land &amp; Legacy Fridays</p>
                <h2 id="home-insights-heading" class="home-insights-title">Insights</h2>
                <p class="home-insights-lead">
                    Practical guides on buying land in Kenya, title diligence, diaspora purchases, and investment perspective from the Acremann team.
                </p>
            </div>
            <a href="{{ route('posts.index') }}" class="home-insights-cta hidden shrink-0 md:inline-flex">
                View all insights
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>

        <div class="home-insights-grid">
            @foreach($posts as $post)
                <a href="{{ route('posts.show', $post->slug) }}" class="home-insight-card group">
                    @if($imageUrl = $post->featuredImageUrl())
                        <div class="home-insight-card-media">
                            <img src="{{ $imageUrl }}" alt="" class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.02]">
                        </div>
                    @else
                        <div class="home-insight-card-media home-insight-card-media-placeholder" aria-hidden="true"></div>
                    @endif
                    <div class="home-insight-card-body">
                        <p class="home-insight-card-meta">
                            {{ $post->published_at?->format('M j, Y') }}
                            @if($post->author)
                                <span aria-hidden="true"> · </span>{{ $post->author }}
                            @endif
                        </p>
                        <h3 class="home-insight-card-title">{{ $post->title }}</h3>
                        @if($post->excerpt)
                            <p class="home-insight-card-excerpt">{{ $post->excerpt }}</p>
                        @endif
                        <span class="home-insight-card-link">
                            Read article
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                            </svg>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="home-insights-footer">
            <a href="{{ route('posts.index') }}" class="home-insights-cta home-insights-cta-full">
                Browse all insights
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif
