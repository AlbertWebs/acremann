@props([
    'eyebrow' => null,
    'title',
    'lead' => null,
    'headingId' => null,
])

<section
    {{ $attributes->class(['page-hero section-padding']) }}
    @if($headingId) aria-labelledby="{{ $headingId }}" @endif
>
    <div class="container-site">
        <div class="page-hero-inner">
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
    </div>
</section>
