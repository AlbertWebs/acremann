@php
    $settings = \App\Models\SiteSetting::current();
@endphp

<aside class="acremann-auth-brand" aria-hidden="false">
    <div class="acremann-auth-brand-inner">
        <a href="{{ config('acremann.url') }}" class="acremann-auth-brand-home" target="_blank" rel="noopener noreferrer">
            @if ($settings->whiteLogoUrl())
                <x-site-logo
                    :settings="$settings"
                    variant="white"
                    class="acremann-auth-brand-logo"
                />
            @else
                <span class="acremann-auth-brand-name">{{ $settings->company_name }}</span>
            @endif
        </a>

        <p class="acremann-auth-brand-tagline">
            {{ $settings->tagline ?? 'Trusted guidance. Transparent process. Sustainable value.' }}
        </p>

        <ul class="acremann-auth-brand-features">
            <li>Manage listings &amp; property media</li>
            <li>Review leads &amp; assistant conversations</li>
            <li>Update site settings &amp; content</li>
        </ul>

        <a href="{{ config('acremann.url') }}" class="acremann-auth-brand-link" target="_blank" rel="noopener noreferrer">
            View public website
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5M10.5 13.5L21 3m0 0h-5.25M21 3v5.25"/>
            </svg>
        </a>
    </div>
</aside>
