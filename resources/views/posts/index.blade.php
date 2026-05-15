@extends('layouts.app')
@section('content')
<section class="section-padding">
    <div class="container-site">
        <p class="text-sm text-gold">Land & Legacy Fridays</p>
        <h1 class="mt-2 text-4xl">Insights & blog</h1>
        <div class="mt-10 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach($posts as $post)
                <a href="{{ route('posts.show', $post->slug) }}" class="card block hover:shadow-md">
                    <p class="text-xs text-muted">{{ $post->published_at?->format('M d, Y') }}</p>
                    <h2 class="mt-2 font-serif text-xl">{{ $post->title }}</h2>
                    <p class="mt-2 text-sm text-muted">{{ $post->excerpt }}</p>
                    <span class="mt-4 inline-block text-sm text-forest">Read more →</span>
                </a>
            @endforeach
        </div>
        <div class="acremann-pagination mt-8">{{ $posts->links() }}</div>
    </div>
</section>
@endsection
