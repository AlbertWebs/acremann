@extends('layouts.app')
@section('content')
<section class="section-padding bg-white">
    <div class="container-site max-w-3xl">
        <p class="text-sm text-gold">About Acremann</p>
        <h1 class="mt-2 text-4xl">Legacy-minded real estate advisory</h1>
        <p class="mt-6 text-muted">{{ $settings->about_summary }}</p>
        <div class="mt-8 grid gap-6 md:grid-cols-2">
            <div class="card"><h3 class="font-serif text-xl">Mission</h3><p class="mt-2 text-sm text-muted">{{ $settings->mission }}</p></div>
            <div class="card"><h3 class="font-serif text-xl">Vision</h3><p class="mt-2 text-sm text-muted">{{ $settings->vision }}</p></div>
        </div>
    </div>
</section>
<section class="section-padding">
    <div class="container-site">
        <h2 class="text-3xl">Leadership</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            @foreach($leadership as $member)
                <div class="card text-center"><p class="font-medium">{{ $member->name }}</p><p class="text-sm text-gold">{{ $member->role }}</p><p class="mt-2 text-xs text-muted">{{ $member->bio }}</p></div>
            @endforeach
        </div>
        <h2 class="mt-16 text-3xl">Our team</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            @foreach($team as $member)
                <div class="card text-center"><p class="font-medium">{{ $member->name }}</p><p class="text-sm text-muted">{{ $member->role }}</p></div>
            @endforeach
        </div>
    </div>
</section>
@endsection
