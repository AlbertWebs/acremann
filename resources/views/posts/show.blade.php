@extends('layouts.app')
@php
    $metaTitle = $post->seoTitle().' | Insights | '.$settings->company_name;
    $metaDescription = $post->seoDescription();
    $metaImage = $post->featuredImageUrl();
    $heroImageUrl = $post->featuredImageUrl();
    $postUrl = route('posts.show', $post);
    $metaType = 'article';
@endphp
@push('schema')
<script type="application/ld+json">{!! \App\Support\Seo::jsonLd(\App\Support\Seo::articleSchema($post, $postUrl)) !!}</script>
@endpush
@section('content')
<article>
    <header @class(['insight-show-hero section-padding', 'insight-show-hero--has-image' => filled($heroImageUrl)])>
        @if($heroImageUrl)
            <div class="insight-show-hero-media" aria-hidden="true">
                <img src="{{ $heroImageUrl }}" alt="" class="insight-show-hero-image" fetchpriority="high">
                <div class="insight-show-hero-overlay"></div>
            </div>
        @endif
        <div class="container-site insight-show-hero-inner">
            <nav class="insight-show-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('posts.index') }}">Insights</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">{{ $post->title }}</span>
            </nav>
            <div class="insight-show-header">
                <p class="insight-show-eyebrow">Land &amp; Legacy Fridays</p>
                <h1 class="insight-show-title">{{ $post->title }}</h1>
                @if($post->excerpt)
                    <p class="insight-show-lead">{{ $post->excerpt }}</p>
                @endif
                <ul class="insight-show-meta-list">
                    @if($post->published_at)
                        <li>{{ $post->published_at->format('F j, Y') }}</li>
                    @endif
                    @if($post->author)
                        <li>{{ $post->author }}</li>
                    @endif
                    <li>{{ $post->readingTimeMinutes() }} min read</li>
                </ul>
            </div>
        </div>
    </header>

    <section class="insight-show-content section-padding">
        <div class="container-site">
            <div class="insight-show-layout">
                <div class="insight-show-main">
                    <div class="insight-show-article">
                        <div class="insight-show-prose" aria-label="Article content">
                            {!! $post->renderedBody() !!}
                        </div>
                    </div>

                    <footer class="insight-show-article-footer">
                        <a href="{{ route('posts.index') }}" class="insight-show-back-link">← Back to all insights</a>
                    </footer>
                </div>

                @include('posts.partials.sidebar')
            </div>
        </div>
    </section>

    <section class="insight-show-cta section-padding" aria-label="Get in touch">
        <div class="container-site">
            <div class="insight-show-cta-inner">
                <div>
                    <p class="insight-show-cta-eyebrow">Trusted guidance. Transparent process.</p>
                    <h2 class="insight-show-cta-title">Buying land from abroad or in Kenya?</h2>
                    <p class="insight-show-cta-lead">Speak with Acremann about verified titles, site visits, and diaspora-friendly purchase support.</p>
                </div>
                <div class="insight-show-cta-actions">
                    <a href="{{ route('book-visit') }}" class="btn-primary">Book a site visit</a>
                    <a href="{{ route('properties.index') }}" class="btn-outline">View properties</a>
                </div>
            </div>
        </div>
    </section>
</article>
@endsection
