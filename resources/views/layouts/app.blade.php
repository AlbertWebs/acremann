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
        :keywords="$metaKeywords ?? null"
        :robots="$metaRobots ?? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1'"
    />
    <x-seo-schema
        :page-title="\App\Support\Seo::pageTitle($metaTitle ?? null)"
        :page-description="\App\Support\Seo::description($metaDescription ?? null)"
    />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cormorant-garamond:400,500,600|dm-sans:400,500,600,700" rel="stylesheet" />
    <script>
        if (window.location.hash && 'scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('schema')
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



