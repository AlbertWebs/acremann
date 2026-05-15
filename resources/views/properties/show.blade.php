@extends('layouts.app')
@php
    $metaTitle = $property->meta_title ?? $property->title;
    $metaDescription = $property->meta_description ?? $property->summary;
    $counts = $property->availabilityCounts();
    $waMessage = "Hello Acremann, I'm interested in {$property->title} at {$property->location}.";
@endphp
@section('content')
<section class="bg-charcoal/5">
    <div class="container-site py-8">
        <p class="text-sm text-gold">{{ ucfirst($property->category) }} · {{ $property->county }} · {{ ucfirst($property->title_type) }}</p>
        <h1 class="mt-2 text-4xl">{{ $property->title }}</h1>
        <p class="mt-2 text-muted">{{ $property->location }}</p>
        <p class="mt-4 text-2xl font-medium text-forest">{{ $property->formattedPrice() }}</p>
    </div>
</section>
<section class="section-padding pb-32">
    <div class="container-site grid gap-12 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-10">
            <div class="grid gap-2 md:grid-cols-2">
                @forelse($property->getMedia('gallery') as $media)
                    <img src="{{ $media->getUrl() }}" alt="{{ $property->title }}" class="rounded-sm object-cover aspect-[4/3] w-full">
                @empty
                    <div class="col-span-2 flex aspect-video items-center justify-center rounded-sm bg-charcoal/5 text-muted">Gallery images coming soon</div>
                @endforelse
            </div>
            @if($property->tour_embed_url)
            <div><h2 class="text-2xl">Virtual tour</h2>
                <div class="mt-4 aspect-video overflow-hidden rounded-sm"><iframe src="{{ $property->tour_embed_url }}" class="h-full w-full" allowfullscreen></iframe></div>
            </div>
            @endif
            <div><h2 class="text-2xl">Overview</h2><p class="mt-4 text-muted">{{ $property->description }}</p></div>
            @if($property->amenities)
            <div><h2 class="text-2xl">Amenities</h2><ul class="mt-4 grid gap-2 md:grid-cols-2">@foreach($property->amenities as $a)<li class="flex gap-2 text-sm"><span class="text-gold">✓</span>{{ $a }}</li>@endforeach</ul></div>
            @endif
            @if($property->title_process)
            <div class="card border-forest/20"><h2 class="text-2xl">Clean title & process</h2><p class="mt-4 text-sm text-muted">{{ $property->title_process }}</p></div>
            @endif
            @if($property->plots->isNotEmpty())
            <div><h2 class="text-2xl">Availability</h2>
                <div class="mt-4 flex gap-4 text-sm"><span class="text-forest">{{ $counts['available'] }} available</span><span class="text-gold">{{ $counts['reserved'] }} reserved</span><span class="text-muted">{{ $counts['sold'] }} sold</span></div>
                <div class="table-wrap mt-4">
                    <table class="acremann-table">
                        <thead><tr><th>Plot</th><th>Size</th><th>Price</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach($property->plots as $plot)
                            <tr>
                                <td>{{ $plot->plot_number }}</td>
                                <td>{{ $plot->size }}</td>
                                <td>{{ $plot->price ? 'KES '.number_format($plot->price, 0) : '—' }}</td>
                                <td>
                                    <span @class([
                                        'table-badge',
                                        'table-badge-available' => $plot->status === 'available',
                                        'table-badge-reserved' => $plot->status === 'reserved',
                                        'table-badge-sold' => $plot->status === 'sold',
                                    ])>{{ $plot->status }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @if($property->map_embed)
            <div><h2 class="text-2xl">Location</h2><div class="mt-4 overflow-hidden rounded-sm">{!! $property->map_embed !!}</div>@if($property->distance_notes)<ul class="mt-4 space-y-1 text-sm text-muted">@foreach(explode("\n", $property->distance_notes) as $note)<li>{{ trim($note) }}</li>@endforeach</ul>@endif</div>
            @endif
            @if($property->faqs->isNotEmpty())
            <div><h2 class="text-2xl">Project FAQs</h2><div class="mt-4 space-y-2">@foreach($property->faqs as $faq)<details class="card"><summary class="cursor-pointer font-medium">{{ $faq->question }}</summary><p class="mt-2 text-sm text-muted">{{ $faq->answer }}</p></details>@endforeach</div></div>
            @endif
            @if($property->investor_angle)
            <div class="card bg-forest/5"><h2 class="text-2xl">Investor perspective</h2><p class="mt-4 text-muted">{{ $property->investor_angle }}</p></div>
            @endif
        </div>
        <aside class="space-y-6">
            <div class="card sticky top-24 hidden lg:block">
                <h3 class="font-serif text-xl">Enquire about this property</h3>
                <div class="mt-4"><x-lead-form source="property_enquiry" :property="$property" /></div>
            </div>
            <form action="{{ route('properties.brochure', $property) }}" method="POST" class="form-card acremann-form">
                @csrf
                <h3 class="font-medium">Download brochure</h3>
                <div class="mt-4 space-y-4">
                    <x-form.input label="Name" name="name" :required="true" placeholder="Your name" />
                    <x-form.input label="Email" name="email" type="email" :required="true" placeholder="you@example.com" />
                    <x-form.input label="Phone" name="phone" type="tel" :required="true" placeholder="+254…" />
                    <x-form.checkbox label="I consent to email follow-up." name="consent_email" :required="true" />
                    <button type="submit" class="btn btn-secondary w-full" data-track="brochure_download">Download brochure</button>
                </div>
            </form>
        </aside>
    </div>
    @if($related->isNotEmpty())
    <div class="container-site mt-16"><h2 class="text-2xl">Related properties</h2><div class="mt-6 grid gap-6 md:grid-cols-3">@foreach($related as $p)<x-property-card :property="$p" />@endforeach</div></div>
    @endif
</section>
<x-sticky-lead-bar :settings="$settings" :property="$property" />
@endsection
