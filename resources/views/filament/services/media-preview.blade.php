@php
    use App\Support\PublicStorage;
    use Illuminate\Support\Facades\Storage;

    $headerPath = PublicStorage::normalizePath($get('header_image') ?? null);
    $featuredPath = PublicStorage::normalizePath($get('featured_image') ?? null);

    $headerUrl = $headerPath && Storage::disk('public')->exists($headerPath)
        ? PublicStorage::url($headerPath)
        : null;

    $featuredUrl = $featuredPath && Storage::disk('public')->exists($featuredPath)
        ? PublicStorage::url($featuredPath)
        : null;
@endphp

<div class="acremann-service-media-preview">
    <p class="acremann-service-media-preview-label">Public page preview</p>

    <div class="acremann-service-media-preview-grid">
        <div class="acremann-service-media-preview-block">
            <p class="acremann-service-media-preview-sublabel">Service page hero</p>
            <div @class(['acremann-service-media-preview-hero', 'acremann-service-media-preview-hero--has-image' => filled($headerUrl)])>
                @if ($headerUrl)
                    <img src="{{ $headerUrl }}" alt="" class="acremann-service-media-preview-hero-image">
                @endif
                <div class="acremann-service-media-preview-hero-overlay" aria-hidden="true"></div>
                <div class="acremann-service-media-preview-hero-copy">
                    <p class="acremann-service-media-preview-hero-title">{{ $get('title') ?: 'Service title' }}</p>
                    <p class="acremann-service-media-preview-hero-lead">{{ $get('summary') ?: 'Card summary appears here on the live page.' }}</p>
                </div>
            </div>
        </div>

        <div class="acremann-service-media-preview-block">
            <p class="acremann-service-media-preview-sublabel">Services listing card</p>
            <article class="acremann-service-media-preview-card">
                <div class="acremann-service-media-preview-card-media">
                    @if ($featuredUrl)
                        <img src="{{ $featuredUrl }}" alt="">
                    @else
                        <span class="acremann-service-media-preview-empty">Featured image or icon</span>
                    @endif
                </div>
                <div class="acremann-service-media-preview-card-body">
                    <p class="acremann-service-media-preview-card-title">{{ $get('title') ?: 'Service title' }}</p>
                    <p class="acremann-service-media-preview-card-summary">{{ $get('summary') ?: 'Summary shown on /services grid.' }}</p>
                </div>
            </article>
        </div>
    </div>
</div>
