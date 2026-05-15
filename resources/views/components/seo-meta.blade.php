@props(['title' => null, 'description' => null])
@php
    $settings = \App\Models\SiteSetting::current();
    $siteName = $settings->company_name ?: 'Acremann Properties';
    $fullTitle = $title ? "{$title} | {$siteName}" : "{$siteName} | Trusted Real Estate Kenya";
    $desc = $description ?? 'Clean title deeds, verified plots, and transparent land buying in Kenya. Land for sale in Nairobi, Kiambu, Kikuyu & Nachu. Diaspora-friendly investment advisory.';
@endphp
<title>{{ $fullTitle }}</title>
@if($settings->faviconUrl())
    <link rel="icon" href="{{ $settings->faviconUrl() }}">
@endif
<meta name="description" content="{{ $desc }}">
<meta property="og:title" content="{{ $fullTitle }}">
<meta property="og:description" content="{{ $desc }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:site_name" content="{{ $siteName }}">
<link rel="canonical" href="{{ url()->current() }}">



