@props(['title' => null, 'description' => null])
@php
    $siteName = 'Acremann Properties';
    $fullTitle = $title ? "{$title} | {$siteName}" : "{$siteName} | Trusted Real Estate Kenya";
    $desc = $description ?? 'Clean title deeds, verified plots, and transparent land buying in Kenya. Land for sale in Nairobi, Kiambu, Kikuyu & Nachu. Diaspora-friendly investment advisory.';
@endphp
<title>{{ $fullTitle }}</title>
<meta name="description" content="{{ $desc }}">
<meta property="og:title" content="{{ $fullTitle }}">
<meta property="og:description" content="{{ $desc }}">
<meta property="og:type" content="website">
<link rel="canonical" href="{{ url()->current() }}">



