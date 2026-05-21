@php
    use App\Support\PublicStorage;
    use Illuminate\Support\Facades\Storage;

    $paths = PublicStorage::normalizePaths($get('hero_images') ?? []);

    if ($paths === [] && filled($get('hero_image_path'))) {
        $normalized = PublicStorage::normalizePath($get('hero_image_path'));
        if ($normalized !== null) {
            $paths = [$normalized];
        }
    }

    $urls = array_slice(array_values(array_filter(array_map(
        fn (string $path): ?string => Storage::disk('public')->exists($path)
            ? PublicStorage::url($path)
            : null,
        $paths,
    ))), 0, \App\Models\SiteSetting::HOMEPAGE_HERO_GRID_LIMIT);

    $totalUploaded = count($paths);
@endphp

<div class="acremann-hero-admin-preview">
    <p class="acremann-hero-admin-preview-label">Homepage layout preview</p>
    @if ($urls === [])
        <p class="acremann-hero-admin-preview-empty">Upload one or more images above to see how they will appear in the hero grid.</p>
    @else
        @if ($totalUploaded > count($urls))
            <p class="acremann-hero-admin-preview-note">Showing the first {{ count($urls) }} of {{ $totalUploaded }} uploaded images (homepage limit).</p>
        @endif
        <div class="acremann-hero-admin-preview-grid">
            @foreach ($urls as $i => $url)
                <div @class([
                    'acremann-hero-admin-preview-cell',
                    'acremann-hero-admin-preview-cell-featured' => $i === 0,
                ])>
                    <img src="{{ $url }}" alt="Hero image {{ $i + 1 }}" loading="lazy">
                </div>
            @endforeach
        </div>
    @endif
</div>
