@extends('layouts.app')
@php
    $metaTitle = 'Book a site visit | ' . config('acremann.company_name', 'Acremann Properties');
    $metaDescription = 'Schedule an on-site or virtual visit to explore Acremann properties with our team.';
@endphp
@section('content')
<section class="book-visit-hero section-padding" aria-labelledby="book-visit-heading">
    <div class="container-site">
        <div class="book-visit-intro">
            <p class="book-visit-eyebrow">Schedule a visit</p>
            <h1 id="book-visit-heading" class="book-visit-title">Book a site visit</h1>
            <p class="book-visit-lead">
                Walk the plot, verify access roads and beacons, or join a virtual tour with our team.
                We serve Nairobi, Kiambu, Kikuyu, Nachu and diaspora buyers.
            </p>
        </div>

        <div class="book-visit-grid">
            <aside class="book-visit-sidebar" aria-label="Visit information">
                <div class="book-visit-sidebar-card">
                    <h2 class="book-visit-sidebar-title">What to expect</h2>
                    <ul class="book-visit-checklist">
                        <li>Guided tour of the plot and surroundings</li>
                        <li>Review of title, pricing and payment plan</li>
                        <li>No obligation — advisory-first approach</li>
                    </ul>
                </div>
                <div class="book-visit-sidebar-card">
                    <h2 class="book-visit-sidebar-title">Typical timeline</h2>
                    <ol class="book-visit-steps">
                        <li><span>1</span> You submit this form</li>
                        <li><span>2</span> We confirm within 1 business day</li>
                        <li><span>3</span> Visit on your preferred date</li>
                    </ol>
                </div>
                <div class="book-visit-sidebar-card book-visit-sidebar-contact">
                    <p class="font-medium text-charcoal">Prefer to talk first?</p>
                    <div class="mt-3 space-y-2 text-sm text-muted">
                        @if($settings->phone)
                            <p>
                                <a href="tel:{{ $settings->phone }}" class="text-forest hover:underline" data-track="call_click">{{ $settings->phone }}</a>
                            </p>
                        @endif
                        <p>
                            <a href="{{ $settings->whatsappUrl('Hello Acremann, I would like to book a site visit.') }}" target="_blank" rel="noopener noreferrer" class="text-forest hover:underline" data-track="whatsapp_click">WhatsApp us</a>
                        </p>
                        <p>
                            <a href="{{ route('contact') }}" class="text-forest hover:underline">General contact form</a>
                        </p>
                    </div>
                </div>
            </aside>

            <div class="book-visit-form-card">
                <h2 class="book-visit-form-heading">Request your visit</h2>
                <p class="book-visit-form-subheading">Fields marked with * are required. We typically confirm within one business day.</p>
                <x-site-visit-form :properties="$properties" />
            </div>
        </div>
    </div>
</section>
@endsection
