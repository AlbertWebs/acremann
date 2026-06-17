@extends('layouts.app')
@php
    $metaTitle = 'Certifications & affiliations | '.$settings->company_name;
    $metaDescription = 'Professional credentials, legal standards, and industry affiliations behind Acremann Properties — trusted land sales and development across Kenya.';
@endphp
@section('content')
<section class="certifications-page-hero section-padding" aria-labelledby="certifications-page-heading">
    <div class="container-site certifications-page-hero-inner">
        <p class="certifications-eyebrow">Professional standards</p>
        <h1 id="certifications-page-heading" class="certifications-page-title">Certifications &amp; affiliations</h1>
        <p class="certifications-page-lead">
            Our credentials reflect a commitment to legal precision, professional standards, and responsible land development — so you can invest with confidence.
        </p>
    </div>
</section>

<section class="section-padding border-t border-charcoal/8 bg-white">
    <div class="container-site">
        @if($certifications->isEmpty())
            <p class="text-muted">Credentials will be published here shortly.</p>
        @else
            <div class="certifications-grid certifications-grid-page">
                @foreach($certifications as $cert)
                    @php
                        $tag = filled($cert->link) ? 'a' : 'article';
                    @endphp
                    <{{ $tag }}
                        @if(filled($cert->link))
                            href="{{ $cert->link }}"
                            target="_blank"
                            rel="noopener noreferrer"
                        @endif
                        @class([
                            'certifications-card certifications-card-page',
                            'certifications-card-link' => filled($cert->link),
                        ])
                    >
                        <div class="certifications-card-logo">
                            @if($cert->logoUrl())
                                <img
                                    src="{{ $cert->logoUrl() }}"
                                    alt=""
                                    class="certifications-card-logo-img"
                                    loading="lazy"
                                >
                            @else
                                <span class="certifications-card-initials" aria-hidden="true">{{ $cert->initials() }}</span>
                            @endif
                        </div>
                        <div class="certifications-card-body">
                            <h2 class="certifications-card-title">{{ $cert->title }}</h2>
                            @if(filled($cert->description))
                                <div class="certifications-card-desc prose prose-sm max-w-none text-muted">
                                    {!! $cert->description !!}
                                </div>
                            @endif
                            @if(filled($cert->link))
                                <span class="certifications-card-more">
                                    Visit organisation
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5M10.5 13.5L21 3m0 0h-5.25M21 3v5.25"/>
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </{{ $tag }}>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
