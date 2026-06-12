@extends('layouts.app')
@php
    $metaTitle = 'Insights & blog | Land & Legacy Fridays | '.$settings->company_name;
    $metaDescription = 'Practical guides on buying land in Kenya, clean title deeds, diaspora purchases, and investment perspective from the Acremann team.';
@endphp
@section('content')
<x-page-hero-image
    eyebrow="Land &amp; Legacy Fridays"
    title="Insights &amp; blog"
    lead="Practical guides on buying land in Kenya, title diligence, diaspora purchases, and investment perspective from the Acremann team."
    heading-id="insights-hero-heading"
>
    <nav class="insights-index-nav" aria-label="Insights and events">
        <a href="{{ route('posts.index') }}" class="insights-index-nav-link insights-index-nav-link--active" aria-current="page">Insights</a>
        <a href="{{ route('events.index') }}" class="insights-index-nav-link">Events</a>
    </nav>
</x-page-hero-image>

<section class="insights-index-list section-padding" aria-label="Articles">
    <div class="container-site">
        @if($posts->isEmpty())
            <div class="insights-index-empty card">
                <p class="insights-index-empty-title">Articles coming soon</p>
                <p class="text-muted">New insights will appear here once published from the CMS.</p>
                <a href="{{ route('events.index') }}" class="insights-index-empty-link">Browse event galleries →</a>
            </div>
        @else
            @if($posts->onFirstPage())
                @php($featured = $posts->first())
                <a href="{{ route('posts.show', $featured->slug) }}" class="insights-index-featured group">
                    @if($featuredImage = $featured->featuredImageUrl())
                        <div class="insights-index-featured-media">
                            <img
                                src="{{ $featuredImage }}"
                                alt=""
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02]"
                                fetchpriority="high"
                            >
                        </div>
                    @else
                        <div class="insights-index-featured-media insights-index-featured-media--placeholder" aria-hidden="true"></div>
                    @endif
                    <div class="insights-index-featured-body">
                        <p class="insights-index-featured-label">Latest insight</p>
                        <p class="insights-index-featured-meta">
                            {{ $featured->published_at?->format('F j, Y') }}
                            @if($featured->author)
                                · {{ $featured->author }}
                            @endif
                            · {{ $featured->readingTimeMinutes() }} min read
                        </p>
                        <h2 class="insights-index-featured-title">{{ $featured->title }}</h2>
                        @if($featured->excerpt)
                            <p class="insights-index-featured-excerpt">{{ $featured->excerpt }}</p>
                        @endif
                        <span class="insights-index-featured-link">
                            Read article
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                            </svg>
                        </span>
                    </div>
                </a>
            @endif

            <div @class(['home-insights-grid', 'insights-index-grid' => true, 'insights-index-grid--with-featured' => $posts->onFirstPage()])>
                @foreach($posts as $index => $post)
                    @if(! ($posts->onFirstPage() && $index === 0))
                        @include('posts.partials.card', ['post' => $post])
                    @endif
                @endforeach
            </div>

            <div class="acremann-pagination insights-index-pagination">{{ $posts->links() }}</div>
        @endif
    </div>
</section>

<section class="insight-show-cta section-padding" aria-label="Get in touch">
    <div class="container-site">
        <div class="insight-show-cta-inner">
            <div>
                <p class="insight-show-cta-eyebrow">Trusted guidance. Transparent process.</p>
                <h2 class="insight-show-cta-title">Questions about buying land in Kenya?</h2>
                <p class="insight-show-cta-lead">Book a site visit or explore verified plots with clean title documentation.</p>
            </div>
            <div class="insight-show-cta-actions">
                <a href="{{ route('book-visit') }}" class="btn-primary">Book a site visit</a>
                <a href="{{ route('properties.index') }}" class="btn-outline">View properties</a>
            </div>
        </div>
    </div>
</section>
@endsection
