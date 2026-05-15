<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-seo-meta :title="$metaTitle ?? null" :description="$metaDescription ?? null" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cormorant-garamond:400,500,600|dm-sans:400,500,600,700" rel="stylesheet" />
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
<body class="min-h-screen flex flex-col" x-data="{ mobileMenu: false }">
    <x-header :settings="$settings ?? \App\Models\SiteSetting::current()" />
    <main class="flex-1">@yield('content')</main>
    <x-footer :settings="$settings ?? \App\Models\SiteSetting::current()" />
    <x-whatsapp-fab :settings="$settings ?? \App\Models\SiteSetting::current()" :property="$property ?? null" />
    <x-chatbot :settings="$settings ?? \App\Models\SiteSetting::current()" />
    <x-cookie-banner :settings="$settings ?? \App\Models\SiteSetting::current()" />
    @stack('scripts')
</body>
</html>



