@extends('layouts.app')
@section('content')
<section class="section-padding">
    <div class="container-site">
        <h1 class="text-4xl">Certifications & affiliations</h1>
        <p class="mt-4 max-w-2xl text-muted">Our credentials reflect our commitment to legal precision, professional standards, and sustainable development.</p>
        <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($certifications as $cert)
                <div class="card">
                    <h3 class="font-serif text-xl">{{ $cert->title }}</h3>
                    <p class="mt-2 text-sm text-muted">{{ $cert->description }}</p>
                    @if($cert->link)<a href="{{ $cert->link }}" class="mt-3 inline-block text-sm text-forest" target="_blank">Learn more →</a>@endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
