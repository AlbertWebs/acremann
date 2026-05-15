<h2>New lead: {{ $lead->source }}</h2>
<p><strong>Name:</strong> {{ $lead->name }}</p>
<p><strong>Phone:</strong> {{ $lead->phone }}</p>
<p><strong>Email:</strong> {{ $lead->email }}</p>
@if($lead->property)<p><strong>Property ID:</strong> {{ $lead->property_id }}</p>@endif
<p><strong>Message:</strong> {{ $lead->message }}</p>
