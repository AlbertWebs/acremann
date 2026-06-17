@extends('layouts.app')
@php
    $metaTitle = $settings->company_name.' | Verified plots & land for sale in Kenya';
    $metaDescription = 'Acremann Properties — clean title deeds, verified plots in Nairobi, Kiambu, Kikuyu & Nachu. Diaspora-friendly land investment with transparent conveyancing.';
    $metaType = 'website';
@endphp
@section('content')
    <x-home-hero-full-width :settings="$settings" />

    @include('pages.partials.home-sections')
@endsection
