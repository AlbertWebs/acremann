@props(['member'])

<a href="{{ route('leadership.show', $member) }}" {{ $attributes->class(['leadership-card card group']) }}>
    <div class="leadership-card-media">
        @if($url = $member->photoUrl())
            <img
                src="{{ $url }}"
                alt="{{ $member->name }}"
                class="leadership-card-photo"
                loading="lazy"
                decoding="async"
            >
        @else
            <span class="leadership-card-initials" aria-hidden="true">{{ $member->initials() }}</span>
        @endif
        <span class="leadership-card-badge">Leadership</span>
    </div>
    <div class="leadership-card-body">
        <h3 class="leadership-card-name">{{ $member->name }}</h3>
        <p class="leadership-card-role">{{ $member->role }}</p>
        @if($member->plainBio())
            <p class="leadership-card-excerpt">{{ $member->plainBio() }}</p>
        @endif
        <span class="leadership-card-link">View profile →</span>
    </div>
</a>
