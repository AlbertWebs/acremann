<section class="legal-page section-padding" aria-labelledby="legal-page-heading">
    <div class="container-site">
        <div class="legal-page-inner">
            <p class="legal-page-eyebrow">Legal</p>
            <h1 id="legal-page-heading" class="legal-page-title">{{ $page?->title ?? $fallbackTitle }}</h1>
            <div class="legal-page-body prose prose-sm max-w-none">
                {!! $page?->content ?? $fallbackContent !!}
            </div>
            <p class="legal-page-updated">
                Questions? <a href="{{ route('contact') }}" class="legal-page-inline-link">Contact us</a>
                @if($settings->email)
                    or email <a href="mailto:{{ $settings->email }}" class="legal-page-inline-link">{{ $settings->email }}</a>
                @endif.
            </p>
        </div>
    </div>
</section>
