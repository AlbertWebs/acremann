@props([
    'testimonials',
    'title' => 'What our clients say',
    'headingId' => 'home-testimonials-heading',
])

@php
    $slideCount = $testimonials->count();
@endphp

<section
    class="testimonials-showcase section-padding"
    aria-labelledby="{{ $headingId }}"
    x-data="testimonialsCarousel({{ $slideCount }})"
>
    <div class="container-site">
        <div class="testimonials-showcase-header">
            <div class="testimonials-showcase-intro">
                <p class="testimonials-showcase-eyebrow">Client stories</p>
                <h2 id="{{ $headingId }}" class="testimonials-showcase-title">{{ $title }}</h2>
                <p class="testimonials-showcase-lead">
                    Real buyers and investors share their experience — from site visit to title in hand.
                </p>
            </div>

            @if($slideCount > 1)
                <div class="testimonials-showcase-controls">
                    <button
                        type="button"
                        class="testimonials-showcase-btn"
                        @click="prev()"
                        aria-label="Previous testimonial"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button
                        type="button"
                        class="testimonials-showcase-btn"
                        @click="next()"
                        aria-label="Next testimonial"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            @endif
        </div>

        <div class="testimonials-showcase-body">
            <div
                class="testimonials-showcase-viewport"
                role="group"
                aria-roledescription="carousel"
                :aria-label="`Testimonials, slide ${active + 1} of ${slideCount}`"
            >
                <div
                    class="testimonials-showcase-track"
                    :style="`transform: translateX(-${active * 100}%)`"
                >
                    @foreach($testimonials as $testimonial)
                        <article class="testimonials-showcase-slide">
                            <div class="testimonials-showcase-media">
                                @if($photoUrl = $testimonial->photoUrl())
                                    <img
                                        src="{{ $photoUrl }}"
                                        alt="{{ $testimonial->client_name }} — Acremann client"
                                        class="testimonials-showcase-photo"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="testimonials-showcase-photo-placeholder" aria-hidden="true">
                                        <svg class="h-12 w-12 text-cream/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-3.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z"/>
                                        </svg>
                                        <span class="testimonials-showcase-photo-placeholder-text">Add client photo in admin</span>
                                    </div>
                                @endif
                            </div>

                            <div class="testimonials-showcase-content">
                                <blockquote class="testimonials-showcase-quote">
                                    <p>"{{ $testimonial->plainQuote() }}"</p>
                                </blockquote>
                                <footer class="testimonials-showcase-author">
                                    <cite class="testimonials-showcase-name">{{ $testimonial->client_name }}</cite>
                                    @if($testimonial->client_detail)
                                        <span class="testimonials-showcase-detail">{{ $testimonial->client_detail }}</span>
                                    @endif
                                    @if($testimonial->property)
                                        <span class="testimonials-showcase-property">{{ $testimonial->property->title }}</span>
                                    @endif
                                </footer>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            @if($slideCount > 1)
                <div class="testimonials-showcase-dots" role="tablist" aria-label="Testimonial slides">
                    @foreach($testimonials as $index => $testimonial)
                        <button
                            type="button"
                            role="tab"
                            class="testimonials-showcase-dot"
                            :class="{ 'is-active': active === {{ $index }} }"
                            @click="goTo({{ $index }})"
                            :aria-selected="active === {{ $index }} ? 'true' : 'false'"
                            aria-label="View testimonial from {{ $testimonial->client_name }}"
                        ></button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
