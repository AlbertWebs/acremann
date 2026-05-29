<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-seo-meta
        :title="$metaTitle ?? null"
        :description="$metaDescription ?? null"
        :image="$metaImage ?? null"
        :type="$metaType ?? 'website'"
    />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cormorant-garamond:400,500,600|dm-sans:400,500,600,700" rel="stylesheet" />
    <script>
        if (window.location.hash && 'scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php($schemaSettings = $settings ?? \App\Models\SiteSetting::current())
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "RealEstateAgent",
        "name": {{ Js::from($schemaSettings->company_name ?: 'Acremann Properties') }},
        "url": {{ Js::from(config('acremann.url')) }},
        "email": {{ Js::from($schemaSettings->email ?: config('acremann.email')) }},
        "telephone": {{ Js::from($schemaSettings->phone ?: config('acremann.phone')) }},
        "description": "Trusted real estate company Kenya — clean title deeds, verified plots, diaspora-friendly land investment."
    }
    </script>
    @stack('head')
</head>
<body
    class="min-h-screen flex flex-col preloader-active"
    x-data="{ mobileMenu: false, utilityCollapsed: false, headerScrolled: false, showScrollTop: false }"
    x-init="
        let scrollTicking = false;
        const syncScroll = () => {
            const y = window.scrollY;
            if (y > 72) {
                utilityCollapsed = true;
            } else if (y < 20) {
                utilityCollapsed = false;
            }
            headerScrolled = y > 48;
            showScrollTop = y > 320;
            scrollTicking = false;
        };
        const onScroll = () => {
            if (! scrollTicking) {
                scrollTicking = true;
                requestAnimationFrame(syncScroll);
            }
        };
        syncScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    "
    :class="{ 'overflow-hidden': mobileMenu }"
>
    <x-site-preloader :settings="$settings ?? \App\Models\SiteSetting::current()" />
    <x-header :settings="$settings ?? \App\Models\SiteSetting::current()" />
    <main class="relative z-0 flex-1">@yield('content')</main>
    <x-footer :settings="$settings ?? \App\Models\SiteSetting::current()" />
    <x-chatbot
        :settings="$settings ?? \App\Models\SiteSetting::current()"
        :property="$property ?? null"
    />
    <x-cookie-banner :settings="$settings ?? \App\Models\SiteSetting::current()" />
    <x-scroll-to-top />
    @stack('scripts')
</body>
</html>



