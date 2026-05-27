@php
    $insightWhatsappMessage = 'Hello Acremann, I read your insight “'.$post->title.'” and would like to speak with your team.';
@endphp

<aside class="insight-show-sidebar" aria-label="Related resources">
    <div class="insight-show-sidebar-card insight-show-sidebar-card--cta">
        <p class="insight-show-sidebar-eyebrow">Diaspora &amp; local buyers</p>
        <h2 class="insight-show-sidebar-title">Ready to take the next step?</h2>
        <p class="insight-show-sidebar-lead">Book a site visit or speak with our team about verified plots, title checks, and remote purchase support.</p>
        <div class="insight-show-sidebar-actions">
            <a href="{{ route('book-visit') }}" class="btn-primary w-full">Book a site visit</a>
            <a
                href="{{ $settings->whatsappUrl($insightWhatsappMessage) }}"
                target="_blank"
                rel="noopener noreferrer"
                class="btn-outline w-full inline-flex items-center justify-center gap-2"
                data-track="whatsapp_click"
            >
                <x-icon-whatsapp class="h-5 w-5 shrink-0" />
                WhatsApp us
            </a>
        </div>
    </div>

    <div class="insight-show-sidebar-card">
        <h2 class="insight-show-sidebar-title">Explore Acremann</h2>
        <ul class="insight-show-sidebar-links">
            <li><a href="{{ route('properties.index') }}">View properties</a></li>
            <li><a href="{{ route('services') }}">Our services</a></li>
            <li><a href="{{ route('invest') }}">Invest with us</a></li>
            <li><a href="{{ route('contact') }}">Contact us</a></li>
        </ul>
    </div>

    @if($recent->isNotEmpty())
        <div class="insight-show-sidebar-card">
            <h2 class="insight-show-sidebar-title">More insights</h2>
            <ul class="insight-show-sidebar-posts">
                @foreach($recent as $recentPost)
                    <li>
                        <a href="{{ route('posts.show', $recentPost->slug) }}" class="insight-show-sidebar-post">
                            @if($recentPost->featuredImageUrl())
                                <img
                                    src="{{ $recentPost->featuredImageUrl() }}"
                                    alt=""
                                    class="insight-show-sidebar-post-image"
                                    loading="lazy"
                                >
                            @endif
                            <span class="insight-show-sidebar-post-body">
                                <span class="insight-show-sidebar-post-date">{{ $recentPost->published_at?->format('M j, Y') }}</span>
                                <span class="insight-show-sidebar-post-title">{{ $recentPost->title }}</span>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <a href="{{ route('posts.index') }}" class="insight-show-sidebar-footer-link">Browse all insights →</a>
        </div>
    @endif
</aside>
