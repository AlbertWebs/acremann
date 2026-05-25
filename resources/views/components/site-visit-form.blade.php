@props([
    'properties' => collect(),
    'submitUrl' => null,
])
@php
    $submitUrl = $submitUrl ?? route('book-visit.store');
    $whatsappUrl = \App\Models\SiteSetting::current()->whatsappUrl('Hello Acremann, I would like to book a site visit.');
@endphp
<div
    x-data="bookVisitForm({
        url: @js($submitUrl),
        genericError: @js('Something went wrong. Please check the form and try again, or contact us directly.'),
    })"
    class="book-visit-form-wrap"
>
    <div
        x-show="successMessage"
        x-cloak
        class="book-visit-alert book-visit-alert-success"
        role="status"
        x-transition
    >
        <p class="book-visit-alert-title">Request received</p>
        <p x-text="successMessage"></p>
        <p class="mt-2 text-sm opacity-90">A confirmation email will be sent if you provided an address.</p>
    </div>

    <div
        x-show="errorMessage && ! successMessage"
        x-cloak
        class="book-visit-alert book-visit-alert-error"
        role="alert"
        x-transition
    >
        <p x-text="errorMessage"></p>
    </div>

    <form
        x-show="! submitted"
        x-cloak
        @submit.prevent="submit($event)"
        class="acremann-form book-visit-form"
        novalidate
    >
        @csrf

        <fieldset class="book-visit-fieldset">
            <legend class="book-visit-legend">Your details</legend>
            <div class="grid gap-5 sm:grid-cols-2">
                <div class="form-group" :class="fieldErrors.name ? 'form-group-error' : ''">
                    <label for="book_name" class="form-label form-label-required">Full name</label>
                    <input type="text" name="name" id="book_name" required class="form-control" placeholder="Your full name" autocomplete="name">
                    <p x-show="fieldErrors.name" x-text="fieldErrors.name" class="form-error" x-cloak></p>
                </div>
                <div class="form-group" :class="fieldErrors.phone ? 'form-group-error' : ''">
                    <label for="book_phone" class="form-label form-label-required">Phone</label>
                    <input type="tel" name="phone" id="book_phone" required class="form-control" placeholder="07XX XXX XXX" autocomplete="tel">
                    <p x-show="fieldErrors.phone" x-text="fieldErrors.phone" class="form-error" x-cloak></p>
                </div>
            </div>
            <div class="form-group" :class="fieldErrors.email ? 'form-group-error' : ''">
                <label for="book_email" class="form-label">Email</label>
                <input type="email" name="email" id="book_email" class="form-control" placeholder="you@example.com" autocomplete="email">
                <p class="form-hint">Recommended — we send a confirmation and visit details by email.</p>
                <p x-show="fieldErrors.email" x-text="fieldErrors.email" class="form-error" x-cloak></p>
            </div>
        </fieldset>

        <fieldset class="book-visit-fieldset">
            <legend class="book-visit-legend">Visit preferences</legend>

            <div class="form-group">
                <span class="form-label">Visit type</span>
                <div class="book-visit-format-options" role="radiogroup" aria-label="Visit type">
                    <label class="book-visit-format-option">
                        <input type="radio" name="visit_format" value="on_site" class="sr-only" checked>
                        <span class="book-visit-format-label">On-site</span>
                        <span class="book-visit-format-hint">Walk the plot in person</span>
                    </label>
                    <label class="book-visit-format-option">
                        <input type="radio" name="visit_format" value="virtual" class="sr-only">
                        <span class="book-visit-format-label">Virtual</span>
                        <span class="book-visit-format-hint">Video tour from abroad</span>
                    </label>
                </div>
            </div>

            @if($properties->isNotEmpty())
                <div class="form-group" :class="fieldErrors.property_id ? 'form-group-error' : ''">
                    <label for="book_property_id" class="form-label">Property to visit</label>
                    <select name="property_id" id="book_property_id" class="form-control">
                        <option value="">Not sure yet — advise me</option>
                        @foreach($properties as $listed)
                            <option value="{{ $listed->id }}">
                                {{ $listed->title }}@if($listed->location) — {{ $listed->location }}@endif
                            </option>
                        @endforeach
                    </select>
                    <p x-show="fieldErrors.property_id" x-text="fieldErrors.property_id" class="form-error" x-cloak></p>
                </div>
            @endif

            <div class="form-group" :class="fieldErrors.property_interest ? 'form-group-error' : ''">
                <label for="book_property_interest" class="form-label">Area or project</label>
                <input type="text" name="property_interest" id="book_property_interest" class="form-control" placeholder="e.g. Nachu plots, Kiambu ½ acre">
                <p x-show="fieldErrors.property_interest" x-text="fieldErrors.property_interest" class="form-error" x-cloak></p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div class="form-group">
                    <label for="book_buyer_type" class="form-label">Buyer type</label>
                    <select name="buyer_type" id="book_buyer_type" class="form-control">
                        <option value="end-user">End user</option>
                        <option value="investor">Investor</option>
                        <option value="diaspora">Diaspora</option>
                        <option value="jv">Joint venture</option>
                        <option value="seller">Seller</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="book_budget" class="form-label">Budget range</label>
                    <select name="budget" id="book_budget" class="form-control">
                        <option value="under-1m">Under KES 1M</option>
                        <option value="1m-3m">KES 1M – 3M</option>
                        <option value="3m-5m">KES 3M – 5M</option>
                        <option value="5m-plus">KES 5M+</option>
                    </select>
                </div>
            </div>

            <div class="form-group" :class="fieldErrors.message ? 'form-group-error' : ''">
                <label for="book_message" class="form-label">Preferred date, time &amp; notes</label>
                <textarea name="message" id="book_message" rows="4" class="form-control" placeholder="e.g. Saturday 15 June, morning preferred, travelling from UK…"></textarea>
                <p x-show="fieldErrors.message" x-text="fieldErrors.message" class="form-error" x-cloak></p>
            </div>
        </fieldset>

        <fieldset class="book-visit-fieldset book-visit-fieldset-consent">
            <legend class="book-visit-legend">Consent</legend>
            <div class="space-y-3">
                <label class="form-check" :class="fieldErrors.consent_callback ? 'form-check-error' : ''">
                    <input type="checkbox" name="consent_callback" value="1" required class="form-check-input">
                    <span class="form-check-label">I consent to Acremann contacting me by phone about this visit.</span>
                </label>
                <p x-show="fieldErrors.consent_callback" x-text="fieldErrors.consent_callback" class="form-error" x-cloak></p>
                <label class="form-check">
                    <input type="checkbox" name="consent_whatsapp" value="1" class="form-check-input">
                    <span class="form-check-label">I consent to WhatsApp follow-up.</span>
                </label>
                <label class="form-check">
                    <input type="checkbox" name="consent_email" value="1" class="form-check-input">
                    <span class="form-check-label">I consent to email follow-up.</span>
                </label>
                <label class="form-check">
                    <input type="checkbox" name="consent_marketing" value="1" class="form-check-input">
                    <span class="form-check-label">I consent to marketing about new projects and offers.</span>
                </label>
            </div>
        </fieldset>

        <div class="book-visit-form-actions">
            <button type="submit" class="btn btn-primary w-full sm:w-auto" :disabled="loading">
                <span x-show="!loading">Request site visit</span>
                <span x-show="loading" x-cloak>Sending request…</span>
            </button>
            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-secondary w-full sm:w-auto">WhatsApp instead</a>
        </div>
    </form>

    <div x-show="submitted" x-cloak class="book-visit-form-actions mt-4">
        <button type="button" class="btn btn-secondary" @click="resetForm()">Submit another request</button>
    </div>
</div>
