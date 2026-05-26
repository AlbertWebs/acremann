@props([
    'member',
    'variant' => 'default',
])

@php
    $isLeadership = $variant === 'leadership';
    $isCompact = $variant === 'compact';
@endphp

<article @class([
    'team-card group',
    'team-card-leadership' => $isLeadership,
    'team-card-compact' => $isCompact,
])>
    <div @class([
        'team-card-media',
        'team-card-media-leadership' => $isLeadership,
        'team-card-media-compact' => $isCompact,
    ])>
        @if($url = $member->photoUrl())
            <img
                src="{{ $url }}"
                alt=""
                class="team-card-photo"
                loading="lazy"
                decoding="async"
            >
        @else
            <span class="team-card-initials" aria-hidden="true">{{ $member->initials() }}</span>
        @endif
        @if($isLeadership)
            <span class="team-card-badge">Leadership</span>
        @endif
    </div>

    <div class="team-card-body">
        <h3 @class([
            'team-card-name',
            'team-card-name-compact' => $isCompact,
        ])>{{ $member->name }}</h3>
        <p @class([
            'team-card-role',
            'team-card-role-leadership' => $isLeadership,
            'team-card-role-compact' => $isCompact,
        ])>{{ $member->role }}</p>
        @if($member->plainBio() && ! $isCompact)
            <p class="team-card-bio">{{ $member->plainBio() }}</p>
        @endif
        @if($isLeadership && $member->slug)
            <a href="{{ route('leadership.show', $member) }}" class="team-card-profile-link">View profile →</a>
        @endif
    </div>
</article>
