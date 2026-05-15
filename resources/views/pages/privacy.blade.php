@extends('layouts.app')
@section('content')
<section class="section-padding">
    <div class="container-site max-w-3xl prose prose-sm">
        <h1>{{ $page->title ?? 'Privacy Notice' }}</h1>
        {!! $page->content ?? '<p>Privacy policy content managed in CMS.</p>' !!}
    </div>
</section>
@endsection
