@php
    use App\Support\PublicStorage;
    use Illuminate\Support\Facades\Storage;

    $featuredPath = PublicStorage::normalizePath($get('hero_image') ?? null);
    $galleryPaths = PublicStorage::normalizePaths($get('gallery_images') ?? []);

    $featuredUrl = $featuredPath && Storage::disk('public')->exists($featuredPath)
        ? PublicStorage::url($featuredPath)
        : null;

    $galleryUrls = array_values(array_filter(array_map(
        fn (string $path): ?string => Storage::disk('public')->exists($path)
            ? PublicStorage::url($path)
            : null,
        array_slice($galleryPaths, 0, 4),
    )));
@endphp

<div class="acremann-property-media-preview">
    <p class="acremann-property-media-preview-label">Listing preview</p>
    <div class="acremann-property-media-preview-card">
        <div class="acremann-property-media-preview-featured">
            @if ($featuredUrl)
                <img src="{{ $featuredUrl }}" alt="Featured preview">
            @else
                <span class="acremann-property-media-preview-empty">Featured image</span>
            @endif
        </div>
        <div class="acremann-property-media-preview-body">
            <p class="acremann-property-media-preview-meta">
                {{ ucfirst($get('category') ?: 'property') }}
                @if (filled($get('county')))
                    · {{ $get('county') }}
                @endif
            </p>
            <p class="acremann-property-media-preview-title">
                {{ $get('title') ?: 'Property title' }}
            </p>
            <p class="acremann-property-media-preview-location">
                {{ $get('location') ?: 'Location' }}
            </p>
            <p class="acremann-property-media-preview-price">
                {{ filled($get('price_label')) ? $get('price_label') : (filled($get('price_from')) ? 'KES '.number_format((float) $get('price_from'), 0) : 'Contact for pricing') }}
            </p>
        </div>
    </div>
    @if (count($galleryUrls) > 0)
        <p class="acremann-property-media-preview-gallery-label">Gallery (first {{ count($galleryUrls) }}{{ count($galleryPaths) > count($galleryUrls) ? ' of '.count($galleryPaths) : '' }})</p>
        <div class="acremann-property-media-preview-gallery">
            @foreach ($galleryUrls as $url)
                <img src="{{ $url }}" alt="">
            @endforeach
        </div>
    @endif
</div>
