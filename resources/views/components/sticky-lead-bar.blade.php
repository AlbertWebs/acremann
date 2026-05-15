@props(['settings', 'property' => null])
@php
    $waMsg = $property ? "Hello Acremann, I'm interested in {$property->title}." : null;
@endphp
<div class="fixed inset-x-0 bottom-0 z-40 border-t border-charcoal/10 bg-white p-3 shadow-lg lg:hidden">
    <div class="flex gap-2 overflow-x-auto">
        <a href="tel:{{ preg_replace('/\D/', '', $settings->phone ?? '') }}" class="btn-outline shrink-0 text-xs" data-track="call_click">Call</a>
        <a href="{{ $settings->whatsappUrl($waMsg) }}" target="_blank" class="btn-outline shrink-0 text-xs" data-track="whatsapp_click">WhatsApp</a>
        <a href="{{ route('contact') }}" class="btn-primary shrink-0 text-xs">Site visit</a>
        <a href="{{ route('contact') }}" class="btn-outline shrink-0 text-xs">Callback</a>
    </div>
</div>
