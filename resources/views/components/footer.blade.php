@props(['settings'])

@php
    $footerCompany = [
        ['route' => 'home', 'label' => 'Home'],
        ['route' => 'about', 'label' => 'About'],
        ['route' => 'services', 'label' => 'Services'],
        ['route' => 'properties.index', 'label' => 'Properties', 'active' => 'properties.*'],
        ['route' => 'invest', 'label' => 'Invest'],
        ['route' => 'sustainability', 'label' => 'Sustainability'],
        ['route' => 'posts.index', 'label' => 'Insights', 'active' => 'posts.*'],
    ];

    $footerAdvisory = [
        ['route' => 'book-visit', 'label' => 'Book a site visit'],
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
        $settings->podcast_url ? ['url' => $settings->podcast_url, 'label' => 'Podcast', 'icon' => 'podcast'] : null,
        $settings->whatsapp ? ['url' => $settings->whatsappUrl(), 'label' => 'WhatsApp', 'icon' => 'whatsapp'] : null,
    ]));
@endphp

<footer class="site-footer border-t border-charcoal/10 bg-white">
    <div class="site-footer-main section-padding pb-10 md:pb-12">
        <div class="container-site site-footer-grid">
            {{-- Brand, contact & social --}}
            <div class="site-footer-brand">
                <p class="site-footer-brand-name">{{ $settings->company_name }}</p>
                @if($settings->themeLogoUrl())
                    <a href="{{ route('home') }}" class="site-footer-brand-logo-link mt-3 inline-block">
                        <x-site-logo :settings="$settings" variant="theme" class="site-footer-brand-logo" />
                    </a>
                @endif
                @if($settings->tagline)
                    <p class="site-footer-tagline">{{ $settings->tagline }}</p>
                @endif

                <ul class="site-footer-contact">
                    @if($settings->phone)
                        <li>
                            <a href="tel:{{ $settings->phone }}" class="site-footer-link" data-track="call_click">{{ $settings->phone }}</a>
                        </li>
                    @endif
                    @if($settings->email)
                        <li>
                            <a href="mailto:{{ $settings->email }}" class="site-footer-link">{{ $settings->email }}</a>
                        </li>
                    @endif
                    @if($settings->address)
                        <li class="site-footer-address">{{ $settings->address }}</li>
                    @endif
                </ul>

                @if(count($socialLinks) > 0)
                    <p class="site-footer-heading site-footer-heading-social">Follow us</p>
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
                @endif

                <p class="site-footer-seo">Land for sale in Nairobi · Plots in Kiambu · Clean title deeds · Diaspora investment Kenya</p>
            </div>

            {{-- Company --}}
            <div class="site-footer-col">
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

            {{-- Advisory --}}
            <div class="site-footer-col">
                <p class="site-footer-heading">Advisory</p>
                <ul class="site-footer-links">
                    @foreach($footerAdvisory as $link)
                        <li>
                            <a href="{{ route($link['route']) }}" @class(['site-footer-link', 'site-footer-link-active' => request()->routeIs($link['route'])])>
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Newsletter --}}
            <div class="site-footer-col site-footer-newsletter">
                <p class="site-footer-heading">Stay informed</p>
                <p class="site-footer-newsletter-lead">Project updates, new listings, and investment insights.</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="acremann-form site-footer-form mt-4 space-y-4">
                    @csrf
                    <x-form.input label="Email address" name="email" type="email" :required="true" placeholder="you@example.com" />
                    <x-form.checkbox label="I agree to receive project updates and marketing from Acremann." name="consent_marketing" :required="true" />
                    <button type="submit" class="btn btn-primary w-full">Subscribe</button>
                </form>
            </div>
        </div>
    </div>

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
