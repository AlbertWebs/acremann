@extends('layouts.app')
@php
    $metaTitle = ($settings->company_name ?: 'Acremann Properties').' | Full-width hero';
@endphp
@section('content')
    <x-home-hero-full-width :settings="$settings" />

    @include('pages.partials.home-sections')
@endsection
