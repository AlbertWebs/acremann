@props(['post'])

<a href="{{ route('posts.show', $post->slug) }}" {{ $attributes->class(['home-insight-card group']) }}>
    @if($imageUrl = $post->featuredImageUrl())
        <div class="home-insight-card-media">
            <img
                src="{{ $imageUrl }}"
                alt=""
                class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.02]"
                loading="lazy"
            >
        </div>
    @else
        <div class="home-insight-card-media home-insight-card-media-placeholder" aria-hidden="true"></div>
    @endif
    <div class="home-insight-card-body">
        <p class="home-insight-card-meta">
            {{ $post->published_at?->format('M j, Y') }}
            @if($post->author)
                <span aria-hidden="true"> · </span>{{ $post->author }}
            @endif
            <span aria-hidden="true"> · </span>{{ $post->readingTimeMinutes() }} min read
        </p>
        <h2 class="home-insight-card-title">{{ $post->title }}</h2>
        @if($post->excerpt)
            <p class="home-insight-card-excerpt">{{ $post->excerpt }}</p>
        @endif
        <span class="home-insight-card-link">
            Read article
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
            </svg>
        </span>
    </div>
</a>
