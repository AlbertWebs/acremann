@extends('layouts.app')
@section('content')
<section class="section-padding" x-data="{ tab: 'title' }">
    <div class="container-site max-w-2xl">
        <h1 class="text-4xl">Client portal</h1>
        <p class="mt-4 text-muted">Check your title deed status or payment installment information.</p>
        @if(session('portal_success'))<p class="mt-4 rounded-md border border-forest/20 bg-forest/5 p-4 text-sm text-forest">{{ session('portal_success') }}</p>@endif
        @if(session('portal_error'))<p class="mt-4 rounded-md border border-red-200 bg-red-50 p-4 text-sm text-red-700">{{ session('portal_error') }}</p>@endif
        <div class="mt-8 flex gap-2 border-b border-charcoal/10">
            <button type="button" @click="tab='title'" :class="tab==='title' ? 'border-forest text-forest' : 'border-transparent text-muted'" class="border-b-2 px-4 py-2 text-sm font-medium transition">Title status</button>
            <button type="button" @click="tab='payment'" :class="tab==='payment' ? 'border-forest text-forest' : 'border-transparent text-muted'" class="border-b-2 px-4 py-2 text-sm font-medium transition">Payment status</button>
        </div>
        <form x-show="tab==='title'" x-cloak action="{{ route('client-portal.title') }}" method="POST" class="form-card mt-6 acremann-form">
            @csrf
            <x-form.input label="Reference number" name="reference" :required="true" placeholder="ACR-TITLE-001" />
            <x-form.input label="Phone (optional)" name="phone" type="tel" placeholder="+254…" />
            <x-form.input label="Email (optional)" name="email" type="email" />
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Check title status</button>
            </div>
        </form>
        <form x-show="tab==='payment'" x-cloak action="{{ route('client-portal.payment') }}" method="POST" class="form-card mt-6 acremann-form">
            @csrf
            <x-form.input label="Reference number" name="reference" :required="true" placeholder="ACR-PAY-001" />
            <x-form.input label="Phone (optional)" name="phone" type="tel" />
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Check / download statement</button>
            </div>
        </form>
        <p class="mt-4 text-xs text-muted">Demo references: ACR-TITLE-001, ACR-PAY-001.</p>
    </div>
</section>
@endsection
