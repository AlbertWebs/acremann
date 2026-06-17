@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'type' => 'website',
    'keywords' => null,
    'robots' => 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
])
@php
    use App\Support\Seo;

    $settings = \App\Models\SiteSetting::current();
    $siteName = Seo::siteName();
    $fullTitle = Seo::pageTitle($title, $siteName);
    $desc = Seo::description($description);
    $pageUrl = url()->current();
    $ogImage = Seo::imageUrl($image);
    $keywordText = filled($keywords) ? $keywords : Seo::defaultKeywords();
    $local = config('acremann.local_business');
    $latitude = $local['latitude'] ?? null;
    $longitude = $local['longitude'] ?? null;
    $mapsUrl = $local['google_maps_url'] ?? null;
@endphp
<title>{{ $fullTitle }}</title>
@if($settings->faviconUrl())
    <link rel="icon" href="{{ $settings->faviconUrl() }}">
@endif
<meta name="description" content="{{ $desc }}">
<meta name="keywords" content="{{ $keywordText }}">
<meta name="author" content="{{ $siteName }}">
<meta name="robots" content="{{ $robots }}">
<meta name="application-name" content="{{ $siteName }}">
<meta name="theme-color" content="#1a3d2e">
<link rel="canonical" href="{{ $pageUrl }}">
<link rel="alternate" hreflang="en-ke" href="{{ $pageUrl }}">
<link rel="alternate" hreflang="x-default" href="{{ $pageUrl }}">

@if(filled($latitude) && filled($longitude))
    <meta name="geo.region" content="{{ $local['country'] ?? 'KE' }}-{{ $local['region'] ?? 'Nairobi County' }}">
    <meta name="geo.placename" content="{{ ($local['locality'] ?? 'Nairobi').', Kenya' }}">
    <meta name="geo.position" content="{{ $latitude }};{{ $longitude }}">
    <meta name="ICBM" content="{{ $latitude }}, {{ $longitude }}">
@endif

<meta property="og:locale" content="en_KE">
<meta property="og:title" content="{{ $fullTitle }}">
<meta property="og:description" content="{{ $desc }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $pageUrl }}">
<meta property="og:site_name" content="{{ $siteName }}">
@if($ogImage)
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:alt" content="{{ $fullTitle }}">
@endif
@if($mapsUrl)
    <meta property="business:contact_data:street_address" content="{{ $local['street_address'] ?? ($settings->address ?: '') }}">
    <meta property="business:contact_data:locality" content="{{ $local['locality'] ?? 'Nairobi' }}">
    <meta property="business:contact_data:region" content="{{ $local['region'] ?? 'Nairobi County' }}">
    <meta property="business:contact_data:country_name" content="Kenya">
@endif

<meta name="twitter:card" content="{{ $ogImage ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $fullTitle }}">
<meta name="twitter:description" content="{{ $desc }}">
@if($ogImage)
    <meta name="twitter:image" content="{{ $ogImage }}">
    <meta name="twitter:image:alt" content="{{ $fullTitle }}">
@endif
