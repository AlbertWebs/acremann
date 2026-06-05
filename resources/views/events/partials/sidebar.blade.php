@php
    $eventWhatsappMessage = 'Hello Acremann, I have a question about your event: '.$event->title;

    $sidebarCompanyLinks = [
        ['route' => 'properties.index', 'label' => 'Properties', 'active' => 'properties.*'],
        ['route' => 'services', 'label' => 'Services'],
        ['route' => 'invest', 'label' => 'Invest with us'],
        ['route' => 'about', 'label' => 'About Acremann'],
        ['route' => 'leadership.index', 'label' => 'Leadership', 'active' => 'leadership.*'],
    ];

    $sidebarAdvisoryLinks = [
        ['route' => 'book-visit', 'label' => 'Book a site visit'],
        ['route' => 'contact', 'label' => 'Contact us'],
        ['route' => 'faqs', 'label' => 'FAQs'],
        ['route' => 'posts.index', 'label' => 'Insights & blog', 'active' => 'posts.*'],
        ['route' => 'events.index', 'label' => 'All events', 'active' => 'events.*'],
        ['route' => 'sustainability', 'label' => 'Sustainability'],
        ['route' => 'certifications', 'label' => 'Certifications'],
        ['route' => 'referrals', 'label' => 'Referral programme'],
        ['route' => 'client-portal', 'label' => 'Client portal'],
    ];

    $socialLinks = array_values(array_filter([
        $settings->facebook_url ? ['url' => $settings->facebook_url, 'label' => 'Facebook'] : null,
        $settings->instagram_url ? ['url' => $settings->instagram_url, 'label' => 'Instagram'] : null,
        $settings->linkedin_url ? ['url' => $settings->linkedin_url, 'label' => 'LinkedIn'] : null,
        $settings->youtube_url ? ['url' => $settings->youtube_url, 'label' => 'YouTube'] : null,
        $settings->podcast_url ? ['url' => $settings->podcast_url, 'label' => 'TikTok'] : null,
    ]));
@endphp

<aside class="events-show-sidebar" aria-label="Event information and resources">
    <div class="events-show-sidebar-card events-show-sidebar-card--cta">
        <p class="events-show-sidebar-cta-eyebrow">{{ $settings->company_name }}</p>
        @if($settings->tagline)
            <p class="events-show-sidebar-cta-tagline">{{ $settings->tagline }}</p>
        @endif
        <div class="events-show-sidebar-cta-actions">
            <a href="{{ route('book-visit') }}" class="btn-primary events-show-sidebar-cta-btn">Book a site visit</a>
            <a
                href="{{ $settings->whatsappUrl($eventWhatsappMessage) }}"
                target="_blank"
                rel="noopener noreferrer"
                class="btn-outline events-show-sidebar-cta-btn events-show-sidebar-cta-btn-outline"
                data-track="whatsapp_click"
            >WhatsApp us</a>
        </div>
    </div>

    <div class="events-show-sidebar-card">
        <h2 class="events-show-sidebar-title">Event details</h2>
        <dl class="events-show-sidebar-meta">
            @if($event->event_date)
                <div>
                    <dt>Date</dt>
                    <dd>{{ $event->event_date->format('l, F j, Y') }}</dd>
                </div>
            @endif
            @if($event->location)
                <div>
                    <dt>Location</dt>
                    <dd>{{ $event->location }}</dd>
                </div>
            @endif
            @if($event->published_at)
                <div>
                    <dt>Published</dt>
                    <dd>{{ $event->published_at->format('M j, Y') }}</dd>
                </div>
            @endif
            @if($gallery->isNotEmpty())
                <div>
                    <dt>Gallery</dt>
                    <dd>
                        <a href="#event-gallery" class="events-show-sidebar-link">
                            View {{ $gallery->count() }} {{ $gallery->count() === 1 ? 'photo' : 'photos' }}
                        </a>
                    </dd>
                </div>
            @endif
        </dl>
        @if($event->excerpt)
            <p class="events-show-sidebar-excerpt">{{ $event->excerpt }}</p>
        @endif
    </div>

    @if($settings->phone || $settings->email || $settings->address)
        <div class="events-show-sidebar-card">
            <h2 class="events-show-sidebar-title">Get in touch</h2>
            <ul class="events-show-sidebar-contact">
                @if($settings->phone)
                    <li>
                        <span class="events-show-sidebar-contact-label">Phone</span>
                        <a href="tel:{{ $settings->phone }}" class="events-show-sidebar-link" data-track="call_click">{{ $settings->phone }}</a>
                    </li>
                @endif
                @if($settings->email)
                    <li>
                        <span class="events-show-sidebar-contact-label">Email</span>
                        <a href="mailto:{{ $settings->email }}" class="events-show-sidebar-link">{{ $settings->email }}</a>
                    </li>
                @endif
                @if($settings->address)
                    <li>
                        <span class="events-show-sidebar-contact-label">Office</span>
                        <span class="events-show-sidebar-contact-value">{{ $settings->address }}</span>
                    </li>
                @endif
            </ul>
        </div>
    @endif

    @if($sidebarProperties->isNotEmpty())
        <div class="events-show-sidebar-card">
            <h2 class="events-show-sidebar-title">
                @if(filled($event->location))
                    Properties in this area
                @else
                    Featured properties
                @endif
            </h2>
            <ul class="events-show-sidebar-properties">
                @foreach($sidebarProperties as $property)
                    <li>
                        <a href="{{ route('properties.show', $property->slug) }}" class="events-show-sidebar-property">
                            <span class="events-show-sidebar-property-media">
                                @if($media = $property->getFirstMediaUrl('hero', 'preview'))
                                    <img src="{{ $media }}" alt="" class="events-show-sidebar-property-image">
                                @endif
                            </span>
                            <span class="events-show-sidebar-property-body">
                                <span class="events-show-sidebar-property-meta">{{ ucfirst($property->category) }} · {{ $property->county }}</span>
                                <span class="events-show-sidebar-property-name">{{ $property->title }}</span>
                                <span class="events-show-sidebar-property-price">{{ $property->formattedPrice() }}</span>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <a href="{{ route('properties.index') }}" class="events-show-sidebar-footer-link">View all properties →</a>
        </div>
    @endif

    @if($recentPosts->isNotEmpty())
        <div class="events-show-sidebar-card">
            <h2 class="events-show-sidebar-title">Latest insights</h2>
            <ul class="events-show-sidebar-posts">
                @foreach($recentPosts as $post)
                    <li>
                        <a href="{{ route('posts.show', $post->slug) }}" class="events-show-sidebar-post">
                            @if($post->featuredImageUrl())
                                <img src="{{ $post->featuredImageUrl() }}" alt="" class="events-show-sidebar-post-image">
                            @endif
                            <span class="events-show-sidebar-post-body">
                                @if($post->published_at)
                                    <span class="events-show-sidebar-post-date">{{ $post->published_at->format('M d, Y') }}</span>
                                @endif
                                <span class="events-show-sidebar-post-title">{{ $post->title }}</span>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <a href="{{ route('posts.index') }}" class="events-show-sidebar-footer-link">Read all insights →</a>
        </div>
    @endif

    <div class="events-show-sidebar-card">
        <h2 class="events-show-sidebar-title">Explore Acremann</h2>
        <p class="events-show-sidebar-nav-label">Company</p>
        <ul class="events-show-sidebar-links">
            @foreach($sidebarCompanyLinks as $link)
                <li>
                    <a
                        href="{{ route($link['route']) }}"
                        @class(['events-show-sidebar-link', 'events-show-sidebar-link-active' => request()->routeIs($link['active'] ?? $link['route'])])
                    >{{ $link['label'] }}</a>
                </li>
            @endforeach
        </ul>
        <p class="events-show-sidebar-nav-label">Advisory</p>
        <ul class="events-show-sidebar-links">
            @foreach($sidebarAdvisoryLinks as $link)
                <li>
                    <a
                        href="{{ route($link['route']) }}"
                        @class(['events-show-sidebar-link', 'events-show-sidebar-link-active' => request()->routeIs($link['active'] ?? $link['route'])])
                    >{{ $link['label'] }}</a>
                </li>
            @endforeach
        </ul>
    </div>

    @if($otherEvents->isNotEmpty())
        <div class="events-show-sidebar-card">
            <h2 class="events-show-sidebar-title">More events</h2>
            <ul class="events-show-sidebar-events">
                @foreach($otherEvents as $other)
                    <li>
                        <a href="{{ route('events.show', $other->slug) }}" class="events-show-sidebar-event">
                            @if($other->coverUrl())
                                <img src="{{ $other->coverUrl() }}" alt="" class="events-show-sidebar-event-image">
                            @endif
                            <span class="events-show-sidebar-event-text">
                                @if($other->event_date)
                                    <span class="events-show-sidebar-event-date">{{ $other->event_date->format('M d, Y') }}</span>
                                @endif
                                <span class="events-show-sidebar-event-name">{{ $other->title }}</span>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($socialLinks !== [])
        <div class="events-show-sidebar-card events-show-sidebar-card--compact">
            <h2 class="events-show-sidebar-title">Follow us</h2>
            <ul class="events-show-sidebar-social">
                @foreach($socialLinks as $link)
                    <li>
                        <a
                            href="{{ $link['url'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="events-show-sidebar-social-link"
                        >{{ $link['label'] }}</a>
                    </li>
                @endforeach
            </ul>
            @if($settings->whatsapp)
                <a
                    href="{{ $settings->whatsappUrl() }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="events-show-sidebar-footer-link mt-3 inline-block"
                    data-track="whatsapp_click"
                >Chat on WhatsApp →</a>
            @endif
        </div>
    @endif
</aside>
