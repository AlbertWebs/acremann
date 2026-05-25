@php
    $booking->loadMissing('property');
    $company = config('acremann.company_name', 'Acremann Properties');
@endphp
<h2>Hello {{ $booking->name }}</h2>
@if($booking->status->value === 'confirmed')
    <p>Your site visit with {{ $company }} is <strong>confirmed</strong>.</p>
    @if($booking->admin_notes)
        <p><strong>From our team:</strong><br>{{ $booking->admin_notes }}</p>
    @endif
    @if($booking->message)
        <p><strong>Your requested timing:</strong><br>{{ $booking->message }}</p>
    @endif
    <p>Please bring a valid ID. If you need to reschedule, reply to this email or call {{ config('acremann.phone') }}.</p>
@elseif($booking->status->value === 'cancelled')
    <p>We are unable to proceed with your site visit request at this time.</p>
    @if($booking->admin_notes)
        <p><strong>Note from our team:</strong><br>{{ $booking->admin_notes }}</p>
    @endif
    <p>Please contact us on {{ config('acremann.phone') }} or {{ config('acremann.email') }} if you would like to arrange another time.</p>
@else
    <p>There is an update on your site visit request (status: {{ $booking->status->label() }}).</p>
    @if($booking->admin_notes)
        <p>{{ $booking->admin_notes }}</p>
    @endif
@endif
<p>— {{ $company }}</p>
