@props([
    'testimonials',
    'title' => 'What our clients say',
    'headingId' => 'home-testimonials-heading',
])

@php
    $slides = $testimonials->chunk(3)->values();
    $slideCount = $slides->count();
@endphp

<section
    class="testimonials-carousel-section section-padding"
    aria-labelledby="{{ $headingId }}"
    x-data="testimonialsCarousel({{ $slideCount }})"
>
    <div class="container-site">
        <div class="testimonials-carousel-header">
            <h2 id="{{ $headingId }}" class="text-3xl md:text-4xl">{{ $title }}</h2>

            @if($slideCount > 1)
                <div class="testimonials-carousel-controls">
                    <button
                        type="button"
                        class="testimonials-carousel-btn"
                        @click="prev()"
                        :disabled="slideCount <= 1"
                        aria-label="Previous testimonials"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button
                        type="button"
                        class="testimonials-carousel-btn"
                        @click="next()"
                        :disabled="slideCount <= 1"
                        aria-label="Next testimonials"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            @endif
        </div>

        <div class="testimonials-carousel-viewport mt-10">
            <div
                class="testimonials-carousel-track"
                :style="`transform: translateX(-${active * 100}%)`"
                role="group"
                aria-roledescription="carousel"
                :aria-label="`Testimonials, slide ${active + 1} of ${slideCount}`"
            >
                @foreach($slides as $slide)
                    <div class="testimonials-carousel-slide">
                        <div class="testimonials-carousel-grid">
                            @foreach($slide as $testimonial)
                                <blockquote class="testimonials-carousel-card card">
                                    <p class="testimonials-carousel-quote">"{{ $testimonial->quote }}"</p>
                                    <footer class="testimonials-carousel-author">
                                        <cite class="not-italic font-medium text-charcoal">— {{ $testimonial->client_name }}</cite>
                                        @if($testimonial->client_detail)
                                            <span class="mt-1 block text-xs text-muted">{{ $testimonial->client_detail }}</span>
                                        @endif
                                    </footer>
                                </blockquote>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if($slideCount > 1)
            <div class="testimonials-carousel-dots" role="tablist" aria-label="Testimonial slides">
                @foreach($slides as $index => $slide)
                    <button
                        type="button"
                        role="tab"
                        class="testimonials-carousel-dot"
                        :class="{ 'is-active': active === {{ $index }} }"
                        @click="goTo({{ $index }})"
                        :aria-selected="active === {{ $index }} ? 'true' : 'false'"
                        aria-label="Go to slide {{ $index + 1 }}"
                    ></button>
                @endforeach
            </div>
        @endif
    </div>
</section>
