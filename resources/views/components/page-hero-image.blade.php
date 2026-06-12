@props([
    'image' => 'bg/APL105.jpg',
    'eyebrow' => null,
    'title',
    'lead' => null,
    'headingId' => null,
    'asideLabel' => null,
])

<section
    {{ $attributes->class(['page-hero-image section-padding']) }}
    @if($headingId) aria-labelledby="{{ $headingId }}" @endif
>
    <div class="page-hero-image-media" aria-hidden="true">
        <img src="{{ asset($image) }}" alt="" class="page-hero-image-photo" fetchpriority="high">
        <div class="page-hero-image-overlay"></div>
    </div>
    <div class="page-hero-image-glow" aria-hidden="true"></div>
    <div class="container-site page-hero-image-inner">
        <div @class([
            'page-hero-image-layout',
            'page-hero-image-layout--with-aside' => isset($aside) && trim($aside) !== '',
        ])>
            <div class="page-hero-image-copy">
                @if(filled($eyebrow))
                    <p class="page-hero-eyebrow">{{ $eyebrow }}</p>
                @endif
                <h1 @if($headingId) id="{{ $headingId }}" @endif class="page-hero-title">{{ $title }}</h1>
                @if(filled($lead))
                    <p class="page-hero-lead">{{ $lead }}</p>
                @endif
                @if(trim($slot) !== '')
                    <div class="page-hero-slot">
                        {{ $slot }}
                    </div>
                @endif
            </div>
            @if(isset($aside) && trim($aside) !== '')
                <div
                    class="page-hero-image-aside"
                    @if(filled($asideLabel)) aria-label="{{ $asideLabel }}" @endif
                >
                    {{ $aside }}
                </div>
            @endif
        </div>
    </div>
</section>
