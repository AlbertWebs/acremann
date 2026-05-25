@php
    $booking->loadMissing('property');
    $company = config('acremann.company_name', 'Acremann Properties');
    $phone = config('acremann.phone');
    $email = config('acremann.email');
@endphp
<h2>Thank you, {{ $booking->name }}</h2>
<p>We have received your site visit request with {{ $company }}.</p>
<p>Our team will review your preferred timing and contact you within <strong>one business day</strong> to confirm your visit.</p>
@if($booking->message)
    <p><strong>Your notes:</strong><br>{{ $booking->message }}</p>
@endif
@if($booking->property)
    <p><strong>Property:</strong> {{ $booking->property->title }}</p>
@elseif($booking->property_interest)
    <p><strong>Interest:</strong> {{ $booking->property_interest }}</p>
@endif
<p>If you need to reach us sooner:</p>
<ul>
    <li>Phone: {{ $phone }}</li>
    <li>Email: {{ $email }}</li>
</ul>
<p>We look forward to welcoming you on site.</p>
<p>— {{ $company }}</p>
