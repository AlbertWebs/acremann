@extends('layouts.app')
@php
    $metaTitle = $page?->meta_title ?? ($page?->title ?? 'Privacy Notice');
    $metaDescription = $page?->meta_description;
    $fallbackTitle = 'Privacy Notice';
    $fallbackContent = '<p>Privacy policy content is managed in the admin under Legal pages.</p>';
@endphp
@section('content')
    @include('pages.partials.legal-body')
@endsection
