@extends('layouts.app')
@section('content')
<section class="section-padding">
    <div class="container-site max-w-3xl">
        <p class="text-sm text-gold">Sustainability</p>
        <h1 class="mt-2 text-4xl">Sustainable real estate Kenya</h1>
        <p class="mt-6 text-muted">{{ $settings->sustainability_intro }}</p>
        <div class="mt-10 grid gap-6 md:grid-cols-2">
            @foreach(['Responsible land use', 'Green & open spaces', 'Solar-ready infrastructure', 'Water-conscious design', 'Community amenities', 'Ethical compliance'] as $marker)
                <div class="card flex items-start gap-3"><span class="text-gold">✓</span><p>{{ $marker }}</p></div>
            @endforeach
        </div>
        @if($settings->csr_statement)
        <div class="card mt-10"><h2 class="font-serif text-xl">CSR commitment</h2><p class="mt-3 text-muted">{{ $settings->csr_statement }}</p></div>
        @endif
    </div>
</section>
@endsection
