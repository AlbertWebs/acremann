@props(['property', 'variant' => 'default'])

@php
    $availability = $property->availabilitySummary();
@endphp

<div {{ $attributes->class([
    'property-availability',
    'property-availability--compact' => $variant === 'compact',
    'property-availability--sold-out' => $availability['is_sold_out'],
]) }}>
    @if($availability['is_sold_out'])
        <span class="property-availability-badge property-availability-badge--sold-out">Sold out</span>
    @elseif($availability['has_plots'])
        <div class="property-availability-stats">
            <span class="property-availability-stat property-availability-stat--remaining">
                <span class="property-availability-stat-value">{{ $availability['remaining'] }}</span>
                <span class="property-availability-stat-label">{{ str('plot')->plural($availability['remaining']) }} remaining</span>
            </span>
            <span class="property-availability-stat property-availability-stat--sold">
                <span class="property-availability-stat-value">{{ $availability['sold'] }}</span>
                <span class="property-availability-stat-label">sold</span>
            </span>
            @if($availability['reserved'] > 0)
                <span class="property-availability-stat property-availability-stat--reserved">
                    <span class="property-availability-stat-value">{{ $availability['reserved'] }}</span>
                    <span class="property-availability-stat-label">reserved</span>
                </span>
            @endif
        </div>
        @if($variant === 'default')
            <p class="property-availability-summary">{{ $availability['total'] }} plots in this development</p>
        @endif
    @else
        <span class="property-availability-badge property-availability-badge--status">{{ $availability['label'] }}</span>
    @endif
</div>
