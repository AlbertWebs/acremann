@props(['settings'])

@php
    $footerCompany = [
        ['route' => 'home', 'label' => 'Home'],
        ['route' => 'about', 'label' => 'About'],
        ['route' => 'leadership.index', 'label' => 'Leadership', 'active' => 'leadership.*'],
        ['route' => 'services', 'label' => 'Services'],
        ['route' => 'properties.index', 'label' => 'Properties', 'active' => 'properties.*'],
        ['route' => 'invest', 'label' => 'Invest'],
        ['route' => 'sustainability', 'label' => 'Sustainability'],
        ['route' => 'posts.index', 'label' => 'Insights', 'active' => 'posts.*'],
        ['route' => 'events.index', 'label' => 'Events', 'active' => 'events.*'],
    ];

    $footerAdvisory = [
        ['route' => 'book-visit', 'label' => 'Book a site visit', 'highlight' => true],
        ['route' => 'contact', 'label' => 'Contact us'],
        ['route' => 'faqs', 'label' => 'FAQs'],
        ['route' => 'certifications', 'label' => 'Certifications'],
        ['route' => 'referrals', 'label' => 'Referrals'],
        ['route' => 'client-portal', 'label' => 'Client portal'],
    ];

    $footerLegal = [
        ['route' => 'terms', 'label' => 'Terms and conditions'],
        ['route' => 'privacy', 'label' => 'Privacy policy'],
    ];

    $socialLinks = array_values(array_filter([
        $settings->facebook_url ? ['url' => $settings->facebook_url, 'label' => 'Facebook', 'icon' => 'facebook'] : null,
        $settings->instagram_url ? ['url' => $settings->instagram_url, 'label' => 'Instagram', 'icon' => 'instagram'] : null,
        $settings->linkedin_url ? ['url' => $settings->linkedin_url, 'label' => 'LinkedIn', 'icon' => 'linkedin'] : null,
        $settings->youtube_url ? ['url' => $settings->youtube_url, 'label' => 'YouTube', 'icon' => 'youtube'] : null,
        $settings->podcast_url ? ['url' => $settings->podcast_url, 'label' => 'TikTok', 'icon' => 'tiktok'] : null,
        $settings->whatsapp ? ['url' => $settings->whatsappUrl(), 'label' => 'WhatsApp', 'icon' => 'whatsapp'] : null,
    ]));
@endphp

<footer class="site-footer">
    <div class="site-footer-main section-padding pb-10 md:pb-12">
        <div class="container-site">
            <div class="site-footer-header">
                <div class="site-footer-intro">
                    <p class="about-eyebrow-dark">Get in touch</p>
                    <h2 class="about-section-title site-footer-title">Ready to explore verified land?</h2>
                    @if($settings->tagline)
                        <p class="about-section-lead about-section-lead-left">{{ $settings->tagline }}</p>
                    @endif
                </div>
                <div class="about-team-cta-group about-team-cta-desktop">
                    <a href="{{ route('book-visit') }}" class="about-team-cta">
                        Book a site visit
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                        </svg>
                    </a>
                    <a href="{{ route('contact') }}" class="about-team-cta about-team-cta-secondary">
                        Contact us
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="site-footer-grid">
            {{-- Brand & contact --}}
            <div class="site-footer-brand">
                <div class="site-footer-brand-card site-footer-col-card site-footer-col-card--forest">
                <a href="{{ route('home') }}" class="site-footer-brand-lockup" aria-label="{{ $settings->company_name }}">
                    @if($settings->footerLogoUrl())
                        <x-site-logo :settings="$settings" variant="footer" class="site-footer-brand-logo" />
                    @endif
                </a>

                <ul class="site-footer-contact">
                    @if($settings->phone)
                        <li class="site-footer-contact-item">
                            <span class="site-footer-contact-icon" aria-hidden="true">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.352.469-.906.713-1.473.513a12.04 12.04 0 01-7.09-7.09c-.2-.567.044-1.121.513-1.473l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 6.75z"/></svg>
                            </span>
                            <a href="tel:{{ $settings->phone }}" class="site-footer-link" data-track="call_click">{{ $settings->phone }}</a>
                        </li>
                    @endif
                    @if($settings->email)
                        <li class="site-footer-contact-item">
                            <span class="site-footer-contact-icon" aria-hidden="true">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            </span>
                            <a href="mailto:{{ $settings->email }}" class="site-footer-link">{{ $settings->email }}</a>
                        </li>
                    @endif
                    @if($settings->address)
                        <li class="site-footer-contact-item">
                            <span class="site-footer-contact-icon" aria-hidden="true">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                            </span>
                            <span class="site-footer-address">{{ $settings->address }}</span>
                        </li>
                    @endif
                </ul>

                <p class="site-footer-seo">Land for sale in Nairobi · Plots in Kiambu · Clean title deeds · Diaspora investment Kenya</p>
                </div>
            </div>

            {{-- Company --}}
            <div class="site-footer-col">
                <div class="site-footer-col-card site-footer-col-card--forest">
                <p class="site-footer-heading">Company</p>
                <ul class="site-footer-links">
                    @foreach($footerCompany as $link)
                        <li>
                            <a href="{{ route($link['route']) }}" @class(['site-footer-link', 'site-footer-link-active' => request()->routeIs($link['active'] ?? $link['route'])])>
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                </div>
            </div>

            {{-- Advisory --}}
            <div class="site-footer-col">
                <div class="site-footer-col-card site-footer-col-card--gold">
                <p class="site-footer-heading">Advisory</p>
                <ul class="site-footer-links">
                    @foreach($footerAdvisory as $link)
                        <li>
                            <a
                                href="{{ route($link['route']) }}"
                                @class([
                                    'site-footer-link',
                                    'site-footer-link-highlight' => ! empty($link['highlight']),
                                    'site-footer-link-active' => request()->routeIs($link['route']),
                                ])
                            >{{ $link['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
                </div>
            </div>

            {{-- Newsletter --}}
            <div class="site-footer-col site-footer-newsletter">
                <div class="site-footer-newsletter-card site-footer-col-card site-footer-col-card--forest">
                    <p class="site-footer-heading">Stay informed</p>
                    <p class="site-footer-newsletter-lead">Project updates, new listings, and investment insights delivered to your inbox.</p>

                    @if(session('success') && str_contains(session('success'), 'subscribed'))
                        <p class="site-footer-newsletter-success" role="status">{{ session('success') }}</p>
                    @endif

                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="acremann-form site-footer-form space-y-4">
                        @csrf
                        <x-form.input label="Email address" name="email" type="email" :required="true" placeholder="you@acremannproperties.com" />
                        <x-form.checkbox label="I agree to receive project updates and marketing from Acremann." name="consent_marketing" :required="true" />
                        <button type="submit" class="btn btn-primary w-full">Subscribe</button>
                    </form>
                </div>
            </div>
            </div>

            <div class="about-team-footer site-footer-cta-mobile">
                <a href="{{ route('book-visit') }}" class="about-team-cta about-team-cta-full">
                    Book a site visit
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
                @if($settings->whatsapp)
                    <a
                        href="{{ $settings->whatsappUrl() }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="about-team-cta about-team-cta-secondary about-team-cta-full"
                        data-track="whatsapp_click"
                    >
                        WhatsApp us
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </div>

    @if(count($socialLinks) > 0)
        <div class="site-footer-social-bar">
            <div class="container-site site-footer-social-bar-inner">
                <p class="site-footer-social-label">Follow us</p>
                <ul class="site-footer-social" role="list">
                    @foreach($socialLinks as $social)
                        <li>
                            <a
                                href="{{ $social['url'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="site-footer-social-link"
                                aria-label="{{ $social['label'] }}"
                                @if($social['icon'] === 'whatsapp') data-track="whatsapp_click" @endif
                            >
                                <x-icons.social-icon :icon="$social['icon']" class="h-5 w-5" />
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="site-footer-bar">
        <div class="container-site site-footer-bar-inner">
            <p class="site-footer-copyright">
                &copy; {{ date('Y') }}
                <a href="{{ config('acremann.url') }}" class="site-footer-link">{{ $settings->company_name }}</a>.
                All rights reserved.
            </p>
            <nav class="site-footer-legal" aria-label="Legal">
                @foreach($footerLegal as $link)
                    @if(! $loop->first)
                        <span class="site-footer-legal-divider" aria-hidden="true"></span>
                    @endif
                    <a href="{{ route($link['route']) }}" @class(['site-footer-legal-link', 'site-footer-legal-link-active' => request()->routeIs($link['route'])])>{{ $link['label'] }}</a>
                @endforeach
            </nav>
            <p class="site-footer-credit">
                Powered by
                <a href="http://designekta.com/" target="_blank" rel="noopener noreferrer" class="site-footer-credit-link">Designekta Studios</a>
            </p>
        </div>
    </div>
</footer>
