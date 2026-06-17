@extends('layouts.app')
@php
    $metaTitle = 'Plots & land for sale Kenya | Nairobi, Kiambu, Kikuyu, Nachu';
    $metaDescription = 'Browse verified Acremann properties — clean freehold title deeds, transparent pricing, and diaspora-friendly purchase support across Kenya.';
@endphp
@push('schema')
<script type="application/ld+json">{!! \App\Support\Seo::jsonLd(\App\Support\Seo::breadcrumbSchema([
    ['name' => 'Home', 'url' => route('home')],
    ['name' => 'Properties', 'url' => route('properties.index')],
])) !!}</script>
@endpush
@section('content')
<section class="section-padding">
    <div class="container-site">
        <h1 class="text-4xl">Current properties</h1>
        <p class="mt-2 text-muted">Land for sale in Nairobi, Kiambu, Kikuyu and beyond — filter by county, category, and title type.</p>
        <form method="GET" class="form-card acremann-form properties-filter-form mt-8 grid items-center gap-4 md:grid-cols-6">
            <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search properties…" class="form-control md:col-span-2">
            <select name="county" class="form-control">
                <option value="">All counties</option>
                @foreach($counties as $county)
                    <option value="{{ $county }}" @selected(($filters['county'] ?? '') === $county)>{{ $county }}</option>
                @endforeach
            </select>
            <select name="category" class="form-control">
                <option value="">All types</option>
                <option value="residential" @selected(($filters['category'] ?? '') === 'residential')>Residential</option>
                <option value="commercial" @selected(($filters['category'] ?? '') === 'commercial')>Commercial</option>
            </select>
            <select name="title_type" class="form-control">
                <option value="">Title type</option>
                <option value="freehold" @selected(($filters['title_type'] ?? '') === 'freehold')>Freehold</option>
                <option value="leasehold" @selected(($filters['title_type'] ?? '') === 'leasehold')>Leasehold</option>
            </select>
            <button type="submit" class="btn btn-primary properties-filter-submit">Filter</button>
        </form>
        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($properties as $property)
                <x-property-card :property="$property" />
            @empty
                <p class="text-muted md:col-span-3">No properties match your filters.</p>
            @endforelse
        </div>
        <div class="acremann-pagination mt-8">{{ $properties->links() }}</div>
    </div>
</section>
@endsection
