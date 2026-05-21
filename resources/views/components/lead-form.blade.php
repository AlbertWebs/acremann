@props([
    'source' => 'contact',
    'property' => null,
    'properties' => null,
    'submitLabel' => 'Submit enquiry',
    'messageLabel' => 'Message',
    'messagePlaceholder' => 'Tell us about your interest, timeline, or questions…',
    'siteVisit' => false,
])
<form action="{{ route('leads.store') }}" method="POST" class="acremann-form">
    @csrf
    <input type="hidden" name="source" value="{{ $source }}">
    @if($property)
        <input type="hidden" name="property_id" value="{{ $property->id }}">
    @endif

    <div class="grid gap-6 md:grid-cols-2">
        <x-form.input label="Full name" name="name" :required="true" placeholder="Your full name" />
        <x-form.input label="Phone" name="phone" type="tel" :required="true" placeholder="+254 7XX XXX XXX" />
    </div>

    <x-form.input label="Email" name="email" type="email" placeholder="you@example.com" />

    @if($properties && $properties->isNotEmpty() && ! $property)
        <x-form.select label="Property to visit (optional)" name="property_id">
            <option value="">Not sure yet — advise me</option>
            @foreach($properties as $listed)
                <option value="{{ $listed->id }}" @selected(old('property_id') == $listed->id)>
                    {{ $listed->title }}@if($listed->location) — {{ $listed->location }}@endif
                </option>
            @endforeach
        </x-form.select>
    @endif

    @if($siteVisit)
        <x-form.input
            label="Property or area of interest"
            name="property_interest"
            placeholder="e.g. Nachu plots, Kiambu ½ acre, or project name"
        />
    @endif

    <div class="grid gap-6 md:grid-cols-2">
        <x-form.select label="Buyer type" name="buyer_type">
            <option value="end-user">End user</option>
            <option value="investor">Investor</option>
            <option value="diaspora">Diaspora</option>
            <option value="jv">Joint venture</option>
            <option value="seller">Seller</option>
        </x-form.select>
        <x-form.select label="Budget range" name="budget">
            <option value="under-1m">Under KES 1M</option>
            <option value="1m-3m">KES 1M – 3M</option>
            <option value="3m-5m">KES 3M – 5M</option>
            <option value="5m-plus">KES 5M+</option>
        </x-form.select>
    </div>

    @if(! $siteVisit)
        <x-form.input label="Location preference" name="location_preference" placeholder="e.g. Kiambu, Kikuyu, Nachu" />
    @endif

    <x-form.textarea
        :label="$messageLabel"
        name="message"
        :rich="! $siteVisit"
        :rows="$siteVisit ? 4 : 5"
        :placeholder="$messagePlaceholder"
    />

    <div class="space-y-3">
        <x-form.checkbox label="I consent to Acremann contacting me by phone for this enquiry." name="consent_callback" :required="true" />
        <x-form.checkbox label="I consent to WhatsApp follow-up." name="consent_whatsapp" />
        <x-form.checkbox label="I consent to email follow-up." name="consent_email" />
        <x-form.checkbox label="I consent to marketing about new projects and offers." name="consent_marketing" />
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
        <a href="{{ \App\Models\SiteSetting::current()->whatsappUrl() }}" target="_blank" class="btn btn-secondary">WhatsApp instead</a>
    </div>
</form>
