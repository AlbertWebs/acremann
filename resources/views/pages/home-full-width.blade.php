@extends('layouts.app')
@section('content')
    <x-home-hero-full-width :settings="$settings" />

    @include('pages.partials.home-sections')
@endsection
