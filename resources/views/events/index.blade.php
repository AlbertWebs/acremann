@extends('layouts.app')
@php
    $metaTitle = 'Events | '.$settings->company_name;
    $metaDescription = 'Photo galleries from Acremann open days, site visits, and community events across Nairobi, Kiambu, Kikuyu and Nachu.';
@endphp
@section('content')
<section class="events-index-hero section-padding">
    <div class="container-site">
        <p class="events-eyebrow">Insights &amp; events</p>
        <h1 class="events-index-title">Events</h1>
        <p class="events-index-lead">Browse photo galleries from site visits, launches, and community moments with Acremann.</p>
    </div>
</section>

<section class="events-list-section section-padding" aria-label="Event galleries">
    <div class="container-site">
        @if($events->isEmpty())
            <div class="events-empty card">
                <p class="text-muted">Event galleries will appear here once published from the CMS.</p>
            </div>
        @else
            <div class="events-grid">
                @foreach($events as $event)
                    <a href="{{ route('events.show', $event->slug) }}" class="events-card card group">
                        <div class="events-card-media">
                            @if($event->coverUrl())
                                <img
                                    src="{{ $event->coverUrl() }}"
                                    alt="{{ $event->title }}"
                                    class="events-card-image"
                                    loading="lazy"
                                >
                            @elseif($galleryMedia = $event->getFirstMedia('gallery'))
                                <img
                                    src="{{ $event->mediaUrl($galleryMedia) }}"
                                    alt="{{ $event->title }}"
                                    class="events-card-image"
                                    loading="lazy"
                                >
                            @else
                                <div class="events-card-placeholder" aria-hidden="true">
                                    <svg class="h-10 w-10 text-muted/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0021.75 18.75V5.25A2.25 2.25 0 0019.5 3H4.5A2.25 2.25 0 002.25 5.25v13.5A2.25 2.25 0 004.5 21z"/>
                                    </svg>
                                </div>
                            @endif
                            @if($event->getMedia('gallery')->count() > 0)
                                <span class="events-card-count">{{ $event->getMedia('gallery')->count() }} photos</span>
                            @endif
                        </div>
                        <div class="events-card-body">
                            @if($event->event_date)
                                <p class="events-card-date">{{ $event->event_date->format('M d, Y') }}</p>
                            @endif
                            <h2 class="events-card-title">{{ $event->title }}</h2>
                            @if($event->location)
                                <p class="events-card-location">{{ $event->location }}</p>
                            @endif
                            @if($event->excerpt)
                                <p class="events-card-excerpt">{{ $event->excerpt }}</p>
                            @endif
                            <span class="events-card-link">View gallery →</span>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="acremann-pagination mt-10">{{ $events->links() }}</div>
        @endif
    </div>
</section>
@endsection
