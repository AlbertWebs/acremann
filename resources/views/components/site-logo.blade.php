@props(['settings', 'variant' => 'theme', 'class' => ''])

@php
    $url = match ($variant) {
        'white' => $settings->whiteLogoUrl(),
        'footer' => $settings->footerLogoUrl(),
        default => $settings->themeLogoUrl(),
    };
@endphp

@if($url)
    <img
        src="{{ $url }}"
        alt="{{ $settings->company_name }}"
        {{ $attributes->class([
            'site-logo',
            'site-logo-white' => $variant === 'white',
            $class,
        ]) }}
    >
@endif
