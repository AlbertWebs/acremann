@php
    $websiteUrl = config('acremann.url');
    $collapsible = filament()->isSidebarCollapsibleOnDesktop();
@endphp

<div class="acremann-sidebar-hero">
    <div
        class="acremann-sidebar-hero-expanded"
        @if ($collapsible)
            x-show="$store.sidebar.isOpen"
            x-cloak
        @endif
    >
        <span class="acremann-sidebar-hero-badge">CMS</span>
        <a
            href="{{ $websiteUrl }}"
            target="_blank"
            rel="noopener noreferrer"
            class="acremann-sidebar-hero-link"
        >
            <x-filament::icon icon="heroicon-o-arrow-top-right-on-square" class="h-4 w-4 shrink-0" />
            View website
        </a>
    </div>

    @if ($collapsible)
        <a
            href="{{ $websiteUrl }}"
            target="_blank"
            rel="noopener noreferrer"
            class="acremann-sidebar-hero-collapsed"
            x-show="! $store.sidebar.isOpen"
            x-cloak
            title="View website"
        >
            <x-filament::icon icon="heroicon-o-globe-alt" class="h-5 w-5 shrink-0" />
        </a>
    @endif
</div>
