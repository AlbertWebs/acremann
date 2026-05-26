@props(['property'])
<a href="{{ route('properties.show', $property->slug) }}" class="group block overflow-hidden rounded-sm border border-charcoal/10 bg-white transition hover:shadow-md">
    <div class="aspect-[4/3] bg-charcoal/5">
        @if($media = $property->getFirstMediaUrl('hero', 'preview'))
            <img src="{{ $media }}" alt="{{ $property->title }}" class="h-full w-full object-cover transition group-hover:scale-105">
        @else
            <div class="flex h-full items-center justify-center text-muted text-sm">Acremann Property</div>
        @endif
    </div>
    <div class="p-5">
        <p class="text-xs uppercase tracking-wider text-gold">{{ ucfirst($property->category) }} · {{ $property->county }}</p>
        <h3 class="mt-1 font-serif text-xl">{{ $property->title }}</h3>
        <p class="mt-1 text-sm text-muted">{{ $property->location }}</p>
        <p class="mt-3 font-medium text-forest">{{ $property->formattedPrice() }}</p>
        <x-property-availability :property="$property" variant="compact" class="mt-3" />
    </div>
</a>


