@extends('layouts.app')
@php
    $metaTitle = 'FAQs | Buying land in Kenya — title deeds, diaspora & plots';
    $metaDescription = 'Answers on clean title deeds, plot purchase steps, diaspora buying, payment plans, and conveyancing for Acremann properties in Nairobi, Kiambu, Kikuyu and Nachu.';
    $allFaqs = $faqs->flatten();
@endphp
@push('schema')
@if($faqSchema = \App\Support\Seo::faqPageSchema($allFaqs))
<script type="application/ld+json">{!! \App\Support\Seo::jsonLd($faqSchema) !!}</script>
@endif
@endpush
@section('content')
<section class="section-padding">
    <div class="container-site max-w-3xl">
        <h1 class="text-4xl">Frequently asked questions</h1>
        @foreach($faqs as $category => $items)
            <h2 class="mt-10 text-xl capitalize text-forest">{{ $category }}</h2>
            <div class="mt-4 space-y-3" x-data>
                @foreach($items as $faq)
                    <details class="card"><summary class="cursor-pointer font-medium">{{ $faq->question }}</summary><p class="mt-3 text-sm text-muted">{{ $faq->answer }}</p></details>
                @endforeach
            </div>
        @endforeach
    </div>
</section>
@endsection
