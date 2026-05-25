@php
    $booking->loadMissing('property');
    $adminUrl = url('/admin/site-visit-bookings/'.$booking->id.'/edit');
@endphp
<h2>New site visit booking</h2>
<p>A new request was submitted from <strong>/book-visit</strong>.</p>
<ul>
    <li><strong>Name:</strong> {{ $booking->name }}</li>
    <li><strong>Phone:</strong> {{ $booking->phone }}</li>
    <li><strong>Email:</strong> {{ $booking->email ?: '—' }}</li>
    @if($booking->property)
        <li><strong>Property:</strong> {{ $booking->property->title }}</li>
    @endif
    @if($booking->property_interest)
        <li><strong>Area / project:</strong> {{ $booking->property_interest }}</li>
    @endif
    @if($booking->buyer_type)
        <li><strong>Buyer type:</strong> {{ $booking->buyer_type }}</li>
    @endif
    @if($booking->budget)
        <li><strong>Budget:</strong> {{ $booking->budget }}</li>
    @endif
    @if($booking->message)
        <li><strong>Preferred date &amp; notes:</strong><br>{{ $booking->message }}</li>
    @endif
    <li><strong>Status:</strong> {{ $booking->status->label() }}</li>
</ul>
<p><a href="{{ $adminUrl }}">View and process in admin</a></p>
