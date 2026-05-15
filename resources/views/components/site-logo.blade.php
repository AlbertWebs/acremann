@props(['settings', 'variant' => 'theme', 'class' => ''])

@php
    $url = $variant === 'white'
        ? $settings->whiteLogoUrl()
        : $settings->themeLogoUrl();
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
