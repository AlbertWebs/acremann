@extends('layouts.app')
@php
    $metaTitle = 'Client portal | ' . config('acremann.company_name');
    $metaDescription = 'Securely check your title deed status or payment information with your Acremann reference number.';
@endphp
@section('content')
<section class="client-portal-hero section-padding" aria-labelledby="client-portal-heading">
    <div class="container-site client-portal-shell">
        <p class="client-portal-eyebrow">Secure client area</p>
        <h1 id="client-portal-heading" class="client-portal-title">Client portal</h1>
        <p class="client-portal-lead">
            Enter the reference number we gave you, plus the phone or email on your file, to view title progress or payment status.
        </p>

        <div
            x-data="clientPortalLookup({
                titleUrl: @js(route('client-portal.title')),
                paymentUrl: @js(route('client-portal.payment')),
                genericError: @js(\App\Services\ClientPortalService::GENERIC_FAILURE_MESSAGE),
                initialTab: @js(old('portal_tab', 'title')),
            })"
        >
            <div
                x-show="successMessage"
                x-cloak
                class="client-portal-alert client-portal-alert-success"
                role="status"
                x-transition
            >
                <p class="client-portal-alert-title">Status update</p>
                <p x-text="successMessage"></p>
            </div>

            <div
                x-show="errorMessage"
                x-cloak
                class="client-portal-alert client-portal-alert-error"
                role="alert"
                x-transition
            >
                <p x-text="errorMessage"></p>
            </div>

            <div class="client-portal-card">
            <div class="client-portal-tabs" role="tablist" aria-label="Lookup type">
                <button
                    type="button"
                    role="tab"
                    :aria-selected="tab === 'title'"
                    @click="tab = 'title'; clearMessages()"
                    :class="tab === 'title' ? 'client-portal-tab client-portal-tab-active' : 'client-portal-tab'"
                >
                    Title status
                </button>
                <button
                    type="button"
                    role="tab"
                    :aria-selected="tab === 'payment'"
                    @click="tab = 'payment'; clearMessages()"
                    :class="tab === 'payment' ? 'client-portal-tab client-portal-tab-active' : 'client-portal-tab'"
                >
                    Payment status
                </button>
            </div>

            <form
                x-show="tab === 'title'"
                x-cloak
                @submit.prevent="submit('title', $event)"
                class="client-portal-form acremann-form"
                aria-label="Title status lookup"
            >
                @csrf
                @include('honeypot::honeypotFormFields')
                <x-form.input label="Reference number" name="reference" :required="true" placeholder="ACR-TITLE-001" hint="As shown on your Acremann documents." />
                <x-form.input label="Phone number" name="phone" type="tel" placeholder="07XX XXX XXX" hint="Required if we registered your phone on file." />
                <x-form.input label="Email address" name="email" type="email" placeholder="you@example.com" hint="Required when we have your email on file." />
                <div class="client-portal-form-actions">
                    <button type="submit" class="btn btn-primary w-full sm:w-auto" :disabled="loading">
                        <span x-show="!loading">Check title status</span>
                        <span x-show="loading" x-cloak>Checking…</span>
                    </button>
                </div>
            </form>

            <form
                x-show="tab === 'payment'"
                x-cloak
                @submit.prevent="submit('payment', $event)"
                class="client-portal-form acremann-form"
                aria-label="Payment status lookup"
            >
                @csrf
                @include('honeypot::honeypotFormFields')
                <x-form.input label="Reference number" name="reference" :required="true" placeholder="ACR-PAY-001" />
                <x-form.input label="Phone number" name="phone" type="tel" placeholder="07XX XXX XXX" hint="Required if we registered your phone on file." />
                <x-form.input label="Email address" name="email" type="email" placeholder="you@example.com" hint="Required if we registered your email on file." />
                <div class="client-portal-form-actions">
                    <button type="submit" class="btn btn-primary w-full sm:w-auto" :disabled="loading">
                        <span x-show="!loading">Check payment status</span>
                        <span x-show="loading" x-cloak>Checking…</span>
                    </button>
                </div>
                <p class="client-portal-form-note">If a PDF statement is available for your account, it will download after verification.</p>
            </form>
            </div>
        </div>

        <p class="client-portal-security-note">
            For your security, we do not confirm whether a reference exists. Failed lookups look the same whether the reference or contact details are wrong.
            Need help? <a href="mailto:{{ $settings->email ?: config('acremann.email') }}">Contact {{ $settings->email ?: config('acremann.email') }}</a>.
        </p>
    </div>
</section>
@endsection
