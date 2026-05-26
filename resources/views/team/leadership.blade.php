@extends('layouts.app')
@php
    $metaTitle = 'Leadership | '.$settings->company_name;
    $metaDescription = 'Meet the Acremann leadership team — experienced advisors guiding verified land investment, conveyancing, and diaspora property support across Kenya.';
@endphp
@section('content')
<section class="leadership-hero section-padding" aria-labelledby="leadership-hero-heading">
    <div class="container-site">
        <nav class="leadership-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('about') }}">About</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page">Leadership</span>
        </nav>
        <p class="leadership-eyebrow">Our leadership</p>
        <h1 id="leadership-hero-heading" class="leadership-hero-title">People guiding every verified plot</h1>
        <p class="leadership-hero-lead">
            The directors and senior advisors behind Acremann — combining title discipline, transparent conveyancing, and client-first advisory across Nairobi, Kiambu, Kikuyu and Nachu.
        </p>
    </div>
</section>

<section class="section-padding pt-0">
    <div class="container-site">
        @if($leadership->isEmpty())
            <div class="leadership-empty card">
                <p class="text-muted">Leadership profiles will appear here once published from the CMS.</p>
            </div>
        @else
            <div class="leadership-grid">
                @foreach($leadership as $member)
                    <x-leadership-profile-card :member="$member" />
                @endforeach
            </div>
        @endif

        <div class="leadership-footer-cta">
            <p class="leadership-footer-text">Want to speak with our advisory team?</p>
            <a href="{{ route('contact') }}" class="btn-primary">Contact us</a>
        </div>
    </div>
</section>
@endsection
