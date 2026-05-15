@props(['settings'])

@php
    $navLinks = [
        ['route' => 'about', 'label' => 'About'],
        ['route' => 'services', 'label' => 'Services'],
        ['route' => 'properties.index', 'label' => 'Properties'],
        ['route' => 'invest', 'label' => 'Invest'],
        ['route' => 'sustainability', 'label' => 'Sustainability'],
        ['route' => 'posts.index', 'label' => 'Insights'],
    ];
@endphp

<header class="site-header">
    <div class="site-header-utility hidden border-b border-charcoal/5 bg-forest/[0.03] md:block">
        <div class="container-site flex h-9 items-center justify-between text-xs text-muted">
            <div class="flex items-center gap-5">
                @if($settings->phone)
                    <a href="tel:{{ $settings->phone }}" class="transition hover:text-forest" data-track="call_click">{{ $settings->phone }}</a>
                @endif
                @if($settings->email)
                    <a href="mailto:{{ $settings->email }}" class="transition hover:text-forest">{{ $settings->email }}</a>
                @endif
            </div>
            <div class="flex items-center gap-5">
                <a href="{{ route('client-portal') }}" class="transition hover:text-forest">Client portal</a>
                <a href="{{ route('certifications') }}" class="transition hover:text-forest">Certifications</a>
            </div>
        </div>
    </div>

    <div class="site-header-main border-b border-charcoal/10 bg-cream/95 backdrop-blur-md">
        <div class="container-site flex h-16 items-center gap-6 md:h-[4.5rem]">
            <a href="{{ route('home') }}" class="site-header-brand shrink-0">
                <span class="site-header-brand-name">{{ $settings->company_name }}</span>
                @if($settings->tagline)
                    <span class="site-header-brand-tagline hidden lg:block">{{ $settings->tagline }}</span>
                @endif
            </a>

            <nav class="site-header-nav hidden flex-1 items-center justify-center gap-1 lg:gap-2 xl:flex" aria-label="Main">
                @foreach($navLinks as $link)
                    <a
                        href="{{ route($link['route']) }}"
                        @class([
                            'site-header-nav-link',
                            'site-header-nav-link-active' => request()->routeIs($link['route']),
                        ])
                    >{{ $link['label'] }}</a>
                @endforeach
            </nav>

            <div class="ml-auto flex items-center gap-2 sm:gap-3">
                <x-admin-menu />
                <a href="{{ route('contact') }}" class="btn-primary hidden sm:inline-flex text-sm !px-4 !py-2">Book visit</a>
                <button
                    type="button"
                    @click="mobileMenu = !mobileMenu"
                    class="site-header-menu-btn xl:hidden"
                    :aria-expanded="mobileMenu"
                    aria-label="Toggle menu"
                >
                    <svg x-show="!mobileMenu" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenu" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div
        x-show="mobileMenu"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="site-header-mobile border-b border-charcoal/10 bg-white xl:hidden"
    >
        <nav class="container-site flex flex-col gap-1 py-4" aria-label="Mobile">
            @foreach($navLinks as $link)
                <a
                    href="{{ route($link['route']) }}"
                    @class([
                        'site-header-mobile-link',
                        'site-header-nav-link-active' => request()->routeIs($link['route']),
                    ])
                >{{ $link['label'] }}</a>
            @endforeach
            <a href="{{ route('client-portal') }}" class="site-header-mobile-link">Client portal</a>
            @auth
                @if(auth()->user()->canAccessPanel(\Filament\Facades\Filament::getPanel('admin')))
                    <div class="mt-3 border-t border-charcoal/10 pt-3">
                        <p class="px-3 pb-1 text-[0.65rem] font-semibold uppercase tracking-wider text-muted">Admin</p>
                        <a href="{{ url('/admin') }}" class="site-header-mobile-link">Dashboard</a>
                        <a href="{{ url('/admin/profile') }}" class="site-header-mobile-link">Edit profile</a>
                    </div>
                @endif
            @endauth
            <a href="{{ route('contact') }}" class="btn-primary mt-3 text-center">Book site visit</a>
        </nav>
    </div>
</header>
