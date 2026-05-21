@props(['settings'])

@php
    $navLinks = [
        ['route' => 'about', 'label' => 'About'],
        ['route' => 'services', 'label' => 'Services'],
        ['route' => 'properties.index', 'label' => 'Properties', 'active' => 'properties.*'],
        ['route' => 'invest', 'label' => 'Invest'],
        ['route' => 'sustainability', 'label' => 'Sustainability'],
        ['route' => 'posts.index', 'label' => 'Insights', 'active' => 'posts.*'],
    ];

    $isNavActive = function (array $link): bool {
        $pattern = $link['active'] ?? $link['route'];

        return request()->routeIs($pattern);
    };
@endphp

{{-- Mobile menu backdrop --}}
<div
    x-show="mobileMenu"
    x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="mobileMenu = false"
    class="site-header-backdrop fixed inset-0 z-40 bg-charcoal/50 backdrop-blur-[2px] xl:hidden"
    aria-hidden="true"
></div>

<header class="site-header">
    {{-- Top utility bar (desktop) — clipped slot avoids layout shift on collapse --}}
    <div
        class="site-header-utility-slot hidden md:block"
        :class="{ 'site-header-utility-slot-collapsed': utilityCollapsed }"
        :aria-hidden="utilityCollapsed"
    >
        <div class="site-header-utility">
            <div class="container-site site-header-utility-inner">
            <div class="site-header-utility-group">
                @if($settings->phone)
                    <a href="tel:{{ $settings->phone }}" class="site-header-utility-item" data-track="call_click">
                        <svg class="site-header-utility-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.352.47-.98.642-1.496.383a12.04 12.04 0 01-5.801-5.801c-.259-.516-.087-1.144.383-1.496l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 6.75z"/>
                        </svg>
                        <span>{{ $settings->phone }}</span>
                    </a>
                @endif
                @if($settings->email)
                    <a href="mailto:{{ $settings->email }}" class="site-header-utility-item">
                        <svg class="site-header-utility-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                        <span class="max-w-[14rem] truncate">{{ $settings->email }}</span>
                    </a>
                @endif
            </div>
            <div class="site-header-utility-divider" aria-hidden="true"></div>
            <div class="site-header-utility-group">
                <a href="{{ route('contact') }}" class="site-header-utility-pill">Contact us</a>
                <a href="{{ route('certifications') }}" class="site-header-utility-pill">Certifications</a>
            </div>
        </div>
        </div>
    </div>

    {{-- Main navigation --}}
    <div
        class="site-header-main"
        :class="{ 'site-header-main-scrolled': headerScrolled }"
    >
        <div class="site-header-accent" aria-hidden="true"></div>
        <div class="container-site site-header-main-inner">
            <a href="{{ route('home') }}" class="site-header-brand shrink-0">
                @if($settings->themeLogoUrl())
                    <x-site-logo :settings="$settings" variant="theme" class="site-header-brand-logo" />
                @else
                    <span class="site-header-brand-name">{{ $settings->company_name }}</span>
                @endif
            </a>

            <nav class="site-header-nav hidden flex-1 items-center justify-center xl:flex" aria-label="Main">
                @foreach($navLinks as $link)
                    <a
                        href="{{ route($link['route']) }}"
                        @class([
                            'site-header-nav-link',
                            'site-header-nav-link-active' => $isNavActive($link),
                        ])
                    >{{ $link['label'] }}</a>
                @endforeach
            </nav>

            <div class="site-header-actions">
                @if($settings->whatsapp)
                    <a
                        href="{{ $settings->whatsappUrl() }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="site-header-whatsapp hidden sm:inline-flex"
                        aria-label="WhatsApp us"
                    >
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.881 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </a>
                @endif
                <a href="{{ route('book-visit') }}" class="site-header-cta hidden sm:inline-flex">Book visit</a>
                <button
                    type="button"
                    @click="mobileMenu = !mobileMenu"
                    class="site-header-menu-btn xl:hidden"
                    :aria-expanded="mobileMenu"
                    aria-controls="site-header-mobile-panel"
                    aria-label="Toggle menu"
                >
                    <svg x-show="!mobileMenu" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenu" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu panel --}}
    <div
        id="site-header-mobile-panel"
        x-show="mobileMenu"
        x-cloak
        @keydown.escape.window="mobileMenu = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="site-header-mobile xl:hidden"
    >
        @if($settings->phone || $settings->email)
            <div class="site-header-mobile-contacts container-site">
                @if($settings->phone)
                    <a href="tel:{{ $settings->phone }}" class="site-header-mobile-contact" data-track="call_click">
                        <svg class="h-4 w-4 shrink-0 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.352.47-.98.642-1.496.383a12.04 12.04 0 01-5.801-5.801c-.259-.516-.087-1.144.383-1.496l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 6.75z"/>
                        </svg>
                        {{ $settings->phone }}
                    </a>
                @endif
                @if($settings->email)
                    <a href="mailto:{{ $settings->email }}" class="site-header-mobile-contact">
                        <svg class="h-4 w-4 shrink-0 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                        <span class="truncate">{{ $settings->email }}</span>
                    </a>
                @endif
            </div>
        @endif

        <nav class="container-site site-header-mobile-nav" aria-label="Mobile">
            @foreach($navLinks as $link)
                <a
                    href="{{ route($link['route']) }}"
                    @click="mobileMenu = false"
                    @class([
                        'site-header-mobile-link',
                        'site-header-nav-link-active' => $isNavActive($link),
                    ])
                >{{ $link['label'] }}</a>
            @endforeach
            <div class="site-header-mobile-secondary">
                <a href="{{ route('contact') }}" @click="mobileMenu = false" class="site-header-mobile-link">Contact us</a>
                <a href="{{ route('certifications') }}" @click="mobileMenu = false" class="site-header-mobile-link">Certifications</a>
            </div>
            <div class="site-header-mobile-actions">
                @if($settings->whatsapp)
                    <a
                        href="{{ $settings->whatsappUrl() }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="site-header-mobile-whatsapp"
                    >
                        WhatsApp us
                    </a>
                @endif
                <a href="{{ route('book-visit') }}" @click="mobileMenu = false" class="site-header-cta site-header-cta-block">Book site visit</a>
            </div>
        </nav>
    </div>
</header>
