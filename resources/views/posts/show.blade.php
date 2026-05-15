@extends('layouts.app')
@section('content')
<article class="section-padding">
    <div class="container-site max-w-3xl">
        <p class="text-sm text-muted">{{ $post->published_at?->format('F j, Y') }} · {{ $post->author }}</p>
        <h1 class="mt-2 text-4xl">{{ $post->title }}</h1>
        <div class="prose prose-sm mt-8 max-w-none">{!! $post->body !!}</div>
    </div>
</article>
@endsection
