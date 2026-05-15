@props(['settings'])
<footer class="border-t border-charcoal/10 bg-white section-padding">
    <div class="container-site grid gap-12 md:grid-cols-4">
        <div class="md:col-span-2">
            @if($settings->themeLogoUrl())
                <x-site-logo :settings="$settings" variant="theme" class="site-footer-brand-logo" />
            @else
                <p class="font-serif text-2xl text-forest">{{ $settings->company_name }}</p>
            @endif
            <p class="mt-3 max-w-md text-sm text-muted">{{ $settings->tagline }}</p>
            <p class="mt-4 text-xs text-muted">Land for sale in Nairobi · Plots for sale in Kiambu · Clean title deeds Kenya · Diaspora property investment Kenya</p>
        </div>
        <div>
            <p class="text-sm font-medium">Explore</p>
            <ul class="mt-3 space-y-2 text-sm text-muted">
                <li><a href="{{ route('properties.index') }}" class="hover:text-forest">Properties</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-forest">About</a></li>
                <li><a href="{{ route('certifications') }}" class="hover:text-forest">Certifications</a></li>
                <li><a href="{{ route('client-portal') }}" class="hover:text-forest">Client Portal</a></li>
                <li><a href="{{ route('referrals') }}" class="hover:text-forest">Referrals</a></li>
                <li><a href="{{ route('privacy') }}" class="hover:text-forest">Privacy</a></li>
            </ul>
        </div>
        <div>
            <p class="text-sm font-medium">Stay informed</p>
            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="acremann-form mt-3 space-y-4">
                @csrf
                <x-form.input label="Email address" name="email" type="email" :required="true" placeholder="you@example.com" />
                <x-form.checkbox label="I agree to receive project updates and marketing from Acremann." name="consent_marketing" :required="true" />
                <button type="submit" class="btn btn-primary w-full">Subscribe</button>
            </form>
        </div>
    </div>
    <div class="container-site mt-12 border-t border-charcoal/10 pt-8">
        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div class="flex flex-wrap gap-4">
                @if($settings->youtube_url)
                    <a href="{{ $settings->youtube_url }}" target="_blank" rel="noopener noreferrer" class="text-sm text-muted transition hover:text-forest">YouTube</a>
                @endif
                @if($settings->podcast_url)
                    <a href="{{ $settings->podcast_url }}" target="_blank" rel="noopener noreferrer" class="text-sm text-muted transition hover:text-forest">Podcast</a>
                @endif
                @if($settings->linkedin_url)
                    <a href="{{ $settings->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="text-sm text-muted transition hover:text-forest">LinkedIn</a>
                @endif
            </div>
            <nav class="flex flex-wrap gap-x-5 gap-y-2 text-xs text-muted" aria-label="Legal">
                <a href="{{ route('privacy') }}" class="transition hover:text-forest">Privacy Policy</a>
                <a href="{{ route('contact') }}" class="transition hover:text-forest">Contact</a>
            </nav>
        </div>
        <div class="mt-6 flex flex-col items-center gap-3 border-t border-charcoal/5 pt-6 text-center sm:flex-row sm:justify-between sm:text-left">
            <p class="text-xs text-muted">
                &copy; {{ date('Y') }}
                <a href="{{ config('acremann.url') }}" class="transition hover:text-forest">{{ $settings->company_name }}</a>.
                All rights reserved.
            </p>
            <p class="text-xs text-muted">
                Powered by
                <a href="http://designekta.com/" target="_blank" rel="noopener noreferrer" class="font-medium text-forest transition hover:text-gold">
                    Designekta Studios
                </a>
            </p>
        </div>
    </div>
</footer>
