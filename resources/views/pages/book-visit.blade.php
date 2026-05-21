@extends('layouts.app')
@section('content')
<section class="section-padding bg-white">
    <div class="container-site">
        <div class="mx-auto max-w-3xl text-center">
            <p class="text-sm uppercase tracking-widest text-gold">Schedule a visit</p>
            <h1 class="mt-3 text-4xl md:text-5xl">Book a site visit</h1>
            <p class="mt-4 text-muted">
                Walk the plot, verify access roads and beacons, and speak with our team on the ground.
                We serve Nairobi, Kiambu, Kikuyu, Nachu and diaspora buyers remotely when needed.
            </p>
        </div>

        <div class="mx-auto mt-12 grid max-w-5xl gap-10 lg:grid-cols-5 lg:gap-12">
            <div class="lg:col-span-2">
                <div class="card space-y-6">
                    <div>
                        <h2 class="font-serif text-xl text-forest">What to expect</h2>
                        <ul class="mt-3 space-y-2 text-sm text-muted">
                            <li class="flex gap-2">
                                <span class="text-gold" aria-hidden="true">—</span>
                                Guided tour of the plot and surroundings
                            </li>
                            <li class="flex gap-2">
                                <span class="text-gold" aria-hidden="true">—</span>
                                Review of title, pricing and payment plan
                            </li>
                            <li class="flex gap-2">
                                <span class="text-gold" aria-hidden="true">—</span>
                                No obligation — advisory-first approach
                            </li>
                        </ul>
                    </div>
                    <div class="border-t border-charcoal/10 pt-6 text-sm">
                        <p class="font-medium text-charcoal">Prefer to talk first?</p>
                        <div class="mt-3 space-y-2 text-muted">
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
                </div>
            </div>

            <div class="form-card lg:col-span-3">
                @if(session('success'))
                    <p class="mb-6 rounded-sm border border-forest/20 bg-forest/5 px-4 py-3 text-sm text-forest">{{ session('success') }}</p>
                @endif

                <h2 class="font-serif text-xl text-forest">Request your visit</h2>
                <p class="mt-1 text-sm text-muted">We typically confirm within one business day.</p>

                <div class="mt-6">
                    <x-lead-form
                        source="site_visit"
                        :properties="$properties"
                        submit-label="Request site visit"
                        message-label="Preferred date, time & notes"
                        message-placeholder="e.g. Saturday morning, 15 June, or virtual walkthrough from abroad…"
                        :site-visit="true"
                    />
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
