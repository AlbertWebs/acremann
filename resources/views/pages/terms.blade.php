@extends('layouts.app')
@php
    $metaTitle = $page?->meta_title ?? ($page?->title ?? 'Terms and Conditions');
    $metaDescription = $page?->meta_description;
    $fallbackTitle = 'Terms and Conditions';
    $fallbackContent = '<p>Terms and conditions content is managed in the admin under Legal pages.</p>';
@endphp
@section('content')
    @include('pages.partials.legal-body')
@endsection
