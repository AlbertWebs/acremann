@props([
    'certifications',
    'headingId' => 'home-certifications-heading',
])

<section
    class="certifications-section section-padding"
    aria-labelledby="{{ $headingId }}"
>
    <div class="container-site">
        <div class="certifications-section-header">
            <div class="certifications-section-intro">
                <p class="certifications-eyebrow">Professional standards</p>
                <h2 id="{{ $headingId }}" class="certifications-title">Certifications &amp; affiliations</h2>
                <p class="certifications-lead">
                    Credentials and memberships that underpin our commitment to legal precision, ethical practice, and sustainable development.
                </p>
            </div>
            <div class="certifications-trust-badge" aria-hidden="true">
                <svg class="h-8 w-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                </svg>
            </div>
        </div>

        <div class="certifications-grid">
            @foreach($certifications as $cert)
                @php
                    $tag = filled($cert->link) ? 'a' : 'article';
                @endphp
                <{{ $tag }}
                    @if(filled($cert->link))
                        href="{{ $cert->link }}"
                        target="_blank"
                        rel="noopener noreferrer"
                    @endif
                    @class([
                        'certifications-card',
                        'certifications-card-link' => filled($cert->link),
                    ])
                >
                    <div class="certifications-card-logo">
                        @if($cert->logoUrl())
                            <img
                                src="{{ $cert->logoUrl() }}"
                                alt=""
                                class="certifications-card-logo-img"
                                loading="lazy"
                            >
                        @else
                            <span class="certifications-card-initials" aria-hidden="true">{{ $cert->initials() }}</span>
                        @endif
                    </div>
                    <div class="certifications-card-body">
                        <h3 class="certifications-card-title">{{ $cert->title }}</h3>
                        @if(filled($cert->description))
                            <p class="certifications-card-desc">{{ Str::limit(strip_tags($cert->description), 120) }}</p>
                        @endif
                        @if(filled($cert->link))
                            <span class="certifications-card-more">
                                Learn more
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5M10.5 13.5L21 3m0 0h-5.25M21 3v5.25"/>
                                </svg>
                            </span>
                        @endif
                    </div>
                </{{ $tag }}>
            @endforeach
        </div>
    </div>
</section>
