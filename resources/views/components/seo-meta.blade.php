@props(['title' => null, 'description' => null, 'image' => null, 'type' => 'website'])
@php
    $settings = \App\Models\SiteSetting::current();
    $siteName = $settings->company_name ?: 'Acremann Properties';
    $fullTitle = $title ? "{$title} | {$siteName}" : "{$siteName} | Trusted Real Estate Kenya";
    $desc = $description ?? 'Clean title deeds, verified plots, and transparent land buying in Kenya. Land for sale in Nairobi, Kiambu, Kikuyu & Nachu. Diaspora-friendly investment advisory.';
    $pageUrl = url()->current();
    $ogImage = $image ? (str_starts_with($image, 'http') ? $image : url($image)) : null;
@endphp
<title>{{ $fullTitle }}</title>
@if($settings->faviconUrl())
    <link rel="icon" href="{{ $settings->faviconUrl() }}">
@endif
<meta name="description" content="{{ $desc }}">
<meta property="og:title" content="{{ $fullTitle }}">
<meta property="og:description" content="{{ $desc }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $pageUrl }}">
<meta property="og:site_name" content="{{ $siteName }}">
@if($ogImage)
    <meta property="og:image" content="{{ $ogImage }}">
@endif
<link rel="canonical" href="{{ $pageUrl }}">



