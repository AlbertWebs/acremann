@extends('layouts.app')
@section('content')
<section class="section-padding">
    <div class="container-site">
        <p class="text-sm text-gold">What we offer</p>
        <h1 class="mt-2 text-4xl">Professional property services</h1>
        <p class="mt-4 max-w-2xl text-muted">From land sales and investment advisory to conveyancing and diaspora support — Acremann delivers transparent, legally-grounded real estate solutions.</p>
        <div class="mt-12 grid gap-6 md:grid-cols-2">
            @foreach($services as $service)
                <div class="card">
                    <h3 class="font-serif text-xl">{{ $service->title }}</h3>
                    <p class="mt-2 text-muted">{{ $service->summary }}</p>
                    @if($service->body)<p class="mt-3 text-sm text-muted">{{ $service->body }}</p>@endif
                </div>
            @endforeach
        </div>
        <a href="{{ route('contact') }}" class="btn-primary mt-10 inline-flex">Enquire about our services</a>
    </div>
</section>
@endsection
