@php($preloaderSettings = $settings ?? \App\Models\SiteSetting::current())
<div id="site-preloader" class="site-preloader" role="status" aria-live="polite" aria-label="Loading page">
    <div class="site-preloader-inner">
        @if($preloaderSettings->whiteLogoUrl())
            <x-site-logo
                :settings="$preloaderSettings"
                variant="white"
                class="site-preloader-logo"
            />
        @else
            <p class="site-preloader-name">{{ $preloaderSettings->company_name ?: 'Acremann Properties' }}</p>
        @endif
        <div class="site-preloader-bar" aria-hidden="true">
            <span class="site-preloader-bar-fill"></span>
        </div>
    </div>
</div>
