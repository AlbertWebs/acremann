@extends('layouts.app')
@section('content')
<section class="section-padding">
    <div class="container-site grid gap-12 lg:grid-cols-2">
        <div>
            <h1 class="text-4xl">Contact us</h1>
            <p class="mt-4 text-muted">Speak with our team about plots, investment advisory, or diaspora purchases.</p>
            <p class="mt-4 text-sm">
                <a href="{{ route('book-visit') }}" class="font-medium text-forest hover:underline">Book a site visit →</a>
            </p>
            <div class="mt-8 space-y-3 text-sm">
                <p><strong>Phone:</strong> <a href="tel:{{ $settings->phone }}" data-track="call_click">{{ $settings->phone }}</a></p>
                <p><strong>Email:</strong> <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></p>
                <p><strong>WhatsApp:</strong> <a href="{{ $settings->whatsappUrl() }}" target="_blank" data-track="whatsapp_click">Message us</a></p>
            </div>
            @if(session('success'))<p class="mt-4 text-forest">{{ session('success') }}</p>@endif
        </div>
        <div class="form-card">
            <x-lead-form source="contact" />
        </div>
    </div>
</section>
@endsection
