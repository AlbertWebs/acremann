@extends('layouts.app')
@section('content')
<section class="section-padding bg-forest text-white">
    <div class="container-site max-w-3xl">
        @if($settings->whiteLogoUrl())
            <x-site-logo :settings="$settings" variant="white" class="mb-6" />
        @endif
        <p class="text-sm text-gold">Investment advisory</p>
        <h1 class="mt-2 text-4xl">{{ $page->title ?? 'Why Invest With Acremann' }}</h1>
        <p class="mt-6 text-white/85">{{ $settings->investment_intro }}</p>
    </div>
</section>
<section class="section-padding">
    <div class="container-site max-w-3xl prose prose-sm">
        {!! $page->content ?? '<p>Land investment opportunities Kenya with verified titles and professional advisory.</p>' !!}
        <div class="mt-8 grid gap-4 md:grid-cols-2 not-prose">
            <div class="card"><h3 class="font-serif text-lg">End users</h3><p class="text-sm text-muted">Build your home on clean-title land with full process transparency.</p></div>
            <div class="card"><h3 class="font-serif text-lg">Investors</h3><p class="text-sm text-muted">Capital appreciation in growth corridors near Nairobi and Kiambu.</p></div>
            <div class="card"><h3 class="font-serif text-lg">Diaspora</h3><p class="text-sm text-muted">Kenya land investment for diaspora with remote purchase support.</p></div>
            <div class="card"><h3 class="font-serif text-lg">Joint ventures</h3><p class="text-sm text-muted">Partner with Acremann on strategic land development opportunities.</p></div>
        </div>
        <a href="{{ route('properties.index') }}" class="btn-primary mt-8 inline-flex">Explore investment properties</a>
    </div>
</section>
@endsection
