@php($preloaderSettings = $settings ?? \App\Models\SiteSetting::current())
<div id="site-preloader" class="site-preloader" role="status" aria-live="polite" aria-label="Loading page">
    <div class="site-preloader-inner">
        @if($logoUrl = $preloaderSettings->themeLogoUrl())
            <img
                src="{{ $logoUrl }}"
                alt="{{ $preloaderSettings->company_name ?: 'Acremann Properties' }}"
                class="site-preloader-logo"
                width="180"
                height="48"
            >
        @else
            <p class="site-preloader-name">{{ $preloaderSettings->company_name ?: 'Acremann Properties' }}</p>
        @endif
        <div class="site-preloader-bar" aria-hidden="true">
            <span class="site-preloader-bar-fill"></span>
        </div>
    </div>
</div>
