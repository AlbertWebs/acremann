@extends('layouts.app')
@section('content')
<section class="section-padding bg-white">
    <div class="container-site grid items-center gap-12 lg:grid-cols-2">
        <div>
            <p class="text-sm uppercase tracking-widest text-gold">Trusted real estate company Kenya</p>
            <h1 class="mt-4 text-4xl leading-tight md:text-5xl lg:text-6xl">{{ $settings->tagline ?? 'Trusted guidance. Transparent process. Sustainable value.' }}</h1>
            <p class="mt-6 max-w-xl text-muted">Clean title deeds, verified plots, and professional property advisory across Nairobi, Kiambu, Kikuyu and Nachu. Buy land in Kenya with confidence — including diaspora-friendly remote purchase support.</p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('properties.index') }}" class="btn-primary">View properties</a>
                <a href="{{ route('contact') }}" class="btn-outline">Book a site visit</a>
                <a href="{{ $settings->whatsappUrl() }}" target="_blank" class="btn-outline">WhatsApp us</a>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-3">
            @foreach($featuredProperties->take(4) as $i => $property)
                <a href="{{ route('properties.show', $property->slug) }}" class="block overflow-hidden rounded-sm {{ $i === 0 ? 'col-span-2 aspect-[2/1]' : 'aspect-square' }} bg-charcoal/5">
                    @if($url = $property->getFirstMediaUrl('hero'))
                        <img src="{{ $url }}" alt="{{ $property->title }}" class="h-full w-full object-cover">
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding">
    <div class="container-site">
        <div class="flex items-end justify-between">
            <div><p class="text-sm text-gold">Current projects</p><h2 class="mt-2 text-3xl md:text-4xl">Featured properties</h2></div>
            <a href="{{ route('properties.index') }}" class="hidden text-sm text-forest md:block">View all →</a>
        </div>
        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($featuredProperties as $property)
                <x-property-card :property="$property" />
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-forest text-white">
    <div class="container-site grid gap-8 md:grid-cols-3">
        <div><h3 class="text-xl">Clean title promise</h3><p class="mt-2 text-sm text-white/80">Verified land for sale with transparent conveyancing and legal precision at every step.</p></div>
        <div><h3 class="text-xl">Advisory-led</h3><p class="mt-2 text-sm text-white/80">Professional property advisory Kenya — from site visits to financing guidance.</p></div>
        <div><h3 class="text-xl">Diaspora ready</h3><p class="mt-2 text-sm text-white/80">Buy land in Kenya from abroad with secure, documented remote purchase support.</p></div>
    </div>
</section>

@if($testimonials->isNotEmpty())
<section class="section-padding">
    <div class="container-site">
        <h2 class="text-3xl">What our clients say</h2>
        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @foreach($testimonials as $t)
                <blockquote class="card"><p class="font-serif text-lg italic">"{{ $t->quote }}"</p><footer class="mt-4 text-sm text-muted">— {{ $t->client_name }}</footer></blockquote>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($certifications->isNotEmpty())
<section class="section-padding border-y border-charcoal/10 bg-white">
    <div class="container-site text-center">
        <h2 class="text-2xl">Certifications & affiliations</h2>
        <div class="mt-8 flex flex-wrap justify-center gap-8">
            @foreach($certifications as $cert)
                <div class="text-sm text-muted">{{ $cert->title }}</div>
            @endforeach
        </div>
        <a href="{{ route('certifications') }}" class="mt-6 inline-block text-sm text-forest">View all →</a>
    </div>
</section>
@endif

<section class="section-padding">
    <div class="container-site grid gap-12 lg:grid-cols-2">
        <div>
            <p class="text-sm text-gold">Sustainability</p>
            <h2 class="mt-2 text-3xl">Land investment for future generations</h2>
            <p class="mt-4 text-muted">{{ Str::limit($settings->sustainability_intro ?? 'Responsible land use, green open spaces, and ethical advisory for long-term community value.', 300) }}</p>
            <a href="{{ route('sustainability') }}" class="mt-6 inline-block text-forest">Our sustainability story →</a>
        </div>
        @if($team->isNotEmpty())
        <div>
            <p class="text-sm text-gold">Our team</p>
            <h2 class="mt-2 text-3xl">People you can trust</h2>
            <div class="mt-6 grid grid-cols-2 gap-4">
                @foreach($team as $member)
                    <div class="card text-center"><p class="font-medium">{{ $member->name }}</p><p class="text-xs text-muted">{{ $member->role }}</p></div>
                @endforeach
            </div>
            <a href="{{ route('about') }}" class="mt-4 inline-block text-sm text-forest">Meet the team →</a>
        </div>
        @endif
    </div>
</section>
@endsection

