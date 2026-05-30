@props(['settings', 'property' => null])
@php
    $assistantContent = app(\App\Services\AssistantContentService::class);
    $assistantConfig = $assistantContent->config($settings, $property);
    $menuItems = $assistantContent->menuItemsForFrontend($settings, $property);
    $assistantFaqs = $assistantContent->faqs();
@endphp
<div
    x-data="chatbot({
        trackUrl: @js(route('assistant.track')),
        submitUrl: @js(route('chatbot.store')),
        csrf: @js(csrf_token()),
        propertyId: @js($property?->id),
        leadTitles: @js($assistantConfig['lead_titles']),
        successMessage: @js($assistantConfig['success_message']),
    })"
    class="assistant-widget fixed bottom-4 left-4 z-50 md:bottom-8"
>
    <div
        x-show="showTeaser"
        x-cloak
        class="assistant-teaser"
        role="status"
    >
        <span class="assistant-teaser-accent" aria-hidden="true"></span>
        <p class="assistant-teaser-text">{{ $assistantConfig['subheading'] }}</p>
        <button
            type="button"
            @click.stop="dismissTeaser()"
            class="assistant-teaser-dismiss"
            aria-label="Dismiss"
        >&times;</button>
    </div>

    <div class="assistant-fab-wrap" :class="{ 'assistant-fab-wrap--idle': !open }">
        <span class="assistant-fab-pulse" aria-hidden="true"></span>
        <span class="assistant-fab-pulse assistant-fab-pulse--delayed" aria-hidden="true"></span>
        <button
            type="button"
            @click="toggleOpen()"
            class="assistant-fab"
            :class="{ 'assistant-fab--open': open }"
            :aria-expanded="open"
            :aria-label="open ? 'Close Acremann Assistant' : 'Open Acremann Assistant'"
        >
            <svg x-show="!open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            <svg x-show="open" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/></svg>
            <span class="assistant-fab-badge" aria-hidden="true"></span>
        </button>
    </div>

    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2 scale-[0.98]"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-2 scale-[0.98]"
        class="assistant-panel"
        role="dialog"
        aria-modal="true"
        aria-labelledby="assistant-panel-heading"
    >
        <div class="assistant-panel-header">
            <div class="assistant-panel-header-glow" aria-hidden="true"></div>
            <div class="assistant-panel-brand">
                <span class="assistant-panel-icon" aria-hidden="true">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </span>
                <div>
                    <p id="assistant-panel-heading" class="assistant-panel-title">{{ $assistantConfig['heading'] }}</p>
                    <p class="assistant-panel-subtitle">{{ $assistantConfig['subheading'] }}</p>
                </div>
            </div>
            <button type="button" @click="toggleOpen()" class="assistant-panel-close" aria-label="Close assistant">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="h-4 w-4" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="assistant-panel-body">
            <div class="assistant-panel-scroll">
                <div class="assistant-panel-section" x-show="step === 'menu'">
                    <p class="assistant-panel-section-label">How can we help?</p>
                    <div class="assistant-menu">
                        @forelse($menuItems as $item)
                            @if(in_array($item['action'], ['whatsapp', 'link'], true) && filled($item['url']))
                                <a
                                    href="{{ $item['url'] }}"
                                    @if($item['open_in_new_tab']) target="_blank" rel="noopener noreferrer" @endif
                                    @click="track('{{ $item['action'] === 'whatsapp' ? 'whatsapp_click' : 'link_click' }}', { label: @js($item['label']) })"
                                    @class([
                                        'assistant-menu-btn group',
                                        'assistant-menu-btn--whatsapp' => $item['action'] === 'whatsapp',
                                        'assistant-menu-btn--link' => $item['action'] === 'link',
                                    ])
                                >
                                    <span>{{ $item['label'] }}</span>
                                    <svg class="assistant-menu-btn-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                                </a>
                            @else
                                <button
                                    type="button"
                                    @click="selectMenuItem(@js($item))"
                                    class="assistant-menu-btn assistant-menu-btn--action group"
                                >
                                    <span>{{ $item['label'] }}</span>
                                    <svg class="assistant-menu-btn-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                                </button>
                            @endif
                        @empty
                            <p class="assistant-panel-empty">No menu items published. Add buttons in the admin under Acremann Assistant → Menu buttons.</p>
                        @endforelse
                    </div>
                </div>

                <div class="assistant-panel-section" x-show="step === 'faq'" x-cloak>
                    <p class="assistant-panel-section-label">Common questions</p>
                    <div class="assistant-faq-list">
                        @forelse($assistantFaqs as $faq)
                            <details class="assistant-faq-item" @toggle="onFaqToggle($event, @js($faq->question))">
                                <summary class="assistant-faq-question">{{ $faq->question }}</summary>
                                <div class="assistant-faq-answer prose prose-sm max-w-none">{!! $faq->answer !!}</div>
                            </details>
                        @empty
                            <p class="assistant-panel-empty">No FAQs published for the assistant yet.</p>
                        @endforelse
                    </div>
                    <button type="button" @click="backToMenu()" class="assistant-back-link">← Back to menu</button>
                </div>

                <div class="assistant-panel-section" x-show="step === 'title'" x-cloak>
                    <p class="assistant-panel-section-label">Title &amp; process</p>
                    <div class="assistant-info-card">
                        <p>{{ $assistantConfig['title_body'] }}</p>
                        @if(filled($assistantConfig['title_link_label']) && filled($assistantConfig['title_link_url']))
                            <a href="{{ $assistantConfig['title_link_url'] }}" @click="track('link_click', { label: @js($assistantConfig['title_link_label']) })" class="assistant-inline-link">{{ $assistantConfig['title_link_label'] }}</a>
                        @endif
                    </div>
                    <button type="button" @click="backToMenu()" class="assistant-back-link">← Back to menu</button>
                </div>

                <div class="assistant-panel-section assistant-panel-section--compact" x-show="step === 'lead'" x-cloak>
                    <div class="assistant-step-header">
                        <p class="assistant-step-title" x-text="formHeading()"></p>
                        <button type="button" @click="backToMenu()" class="assistant-back-link assistant-back-link--inline">← Menu</button>
                    </div>
                </div>
            </div>

            <div x-show="showEnquiryForm" x-cloak class="assistant-panel-footer">
                <form @submit.prevent="submitLead" class="assistant-form acremann-form" novalidate>
                    <p x-show="step !== 'lead'" class="assistant-form-heading" x-text="formHeading()"></p>
                    <p x-show="submitError" class="assistant-form-error" x-text="submitError"></p>
                    <div x-show="!submitted" class="assistant-form-fields">
                        <input type="text" x-model="form.name" @blur="trackField('name')" placeholder="Your name *" class="form-control assistant-form-control" autocomplete="name">
                        <input type="tel" x-model="form.phone" @blur="trackField('phone')" placeholder="Phone *" class="form-control assistant-form-control" autocomplete="tel">
                        <input type="email" x-model="form.email" @blur="trackField('email')" placeholder="Email (optional)" class="form-control assistant-form-control" autocomplete="email">
                        <select x-model="form.buyer_type" @change="trackField('buyer_type')" class="form-control assistant-form-control">
                            <option value="">I am a… (optional)</option>
                            @foreach($assistantConfig['buyer_types'] as $option)
                                <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                            @endforeach
                        </select>
                        <select x-model="form.budget" @change="trackField('budget')" class="form-control assistant-form-control">
                            <option value="">Budget range (optional)</option>
                            @foreach($assistantConfig['budget_ranges'] as $option)
                                <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                            @endforeach
                        </select>
                        <textarea x-model="form.message" @blur="trackField('message')" placeholder="Tell us what you are looking for" class="form-control assistant-form-control" rows="3"></textarea>
                        <label class="form-check assistant-form-check">
                            <input type="checkbox" x-model="form.consent" @change="track('consent_toggle', { data: { consent: form.consent } })" class="form-check-input">
                            <span class="form-check-label">{{ $assistantConfig['consent_text'] }}</span>
                        </label>
                        <button type="submit" class="assistant-submit-btn" :disabled="submitting" x-text="submitting ? 'Sending…' : 'Submit enquiry'"></button>
                    </div>
                    <div x-show="submitted" class="assistant-form-success">
                        <p class="assistant-form-success-text" x-text="successMessage"></p>
                        <button type="button" @click="backToMenu()" class="assistant-back-link">← Back to menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
function chatbot(config) {
    return {
        open: false,
        step: 'menu',
        journey: 'general',
        submitted: false,
        submitting: false,
        submitError: null,
        sessionId: null,
        teaserDismissed: localStorage.getItem('acremann_assistant_teaser_dismissed') === '1',
        successMessage: config.successMessage || "Thank you! We'll be in touch.",
        get showTeaser() {
            return !this.open && !this.teaserDismissed;
        },
        get showEnquiryForm() {
            return ['lead', 'faq', 'title'].includes(this.step);
        },
        form: { name: '', phone: '', email: '', message: '', buyer_type: '', budget: '', consent: false },
        init() {
            const key = 'acremann_assistant_session';
            let id = localStorage.getItem(key);
            if (!id) {
                id = crypto.randomUUID();
                localStorage.setItem(key, id);
            }
            this.sessionId = id;
            this.track('session_start', { label: 'Assistant opened on site' });
        },
        dismissTeaser() {
            this.teaserDismissed = true;
            localStorage.setItem('acremann_assistant_teaser_dismissed', '1');
        },
        toggleOpen() {
            this.open = !this.open;
            if (this.open) {
                this.dismissTeaser();
            }
            this.track(this.open ? 'widget_open' : 'widget_close');
        },
        selectMenuItem(item) {
            this.goTo(item.step, item.journey, item.label);
        },
        goTo(step, journey, label) {
            if (this.step !== step) {
                this.submitted = false;
                this.submitError = null;
            }
            this.step = step;
            if (step === 'menu') {
                this.journey = 'general';
            } else if (journey) {
                this.journey = journey;
            }
            this.track('menu_select', { step, journey: this.activeJourney(), label });
        },
        backToMenu() {
            this.submitted = false;
            this.submitError = null;
            this.goTo('menu', 'general', 'Back to menu');
        },
        activeJourney() {
            if (this.step === 'faq') return 'faq';
            if (this.step === 'title') return 'title';
            return this.journey || 'general';
        },
        formHeading() {
            const titles = config.leadTitles || {};
            if (this.step === 'faq') return 'Ask us a question';
            if (this.step === 'title') return 'Title & process enquiry';
            return titles[this.journey] || 'Get in touch';
        },
        onFaqToggle(event, question) {
            if (event.target.open) {
                this.track('faq_expand', { label: question, step: 'faq', journey: 'faq' });
            }
        },
        trackField(field) {
            const value = this.form[field];
            if (!value) return;
            this.track('form_field', { step: 'lead', journey: this.journey, data: { [field]: value } });
        },
        payload(extra = {}) {
            return {
                session_id: this.sessionId,
                page_url: window.location.href,
                property_id: config.propertyId,
                ...extra,
            };
        },
        async track(event, extra = {}) {
            try {
                await fetch(config.trackUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': config.csrf,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(this.payload({
                        event,
                        step: extra.step ?? this.step,
                        journey: extra.journey ?? this.journey,
                        label: extra.label ?? null,
                        data: extra.data ?? null,
                    })),
                });
            } catch (e) { /* non-blocking */ }
        },
        validateForm() {
            if (!this.form.name?.trim()) return 'Please enter your name.';
            if (!this.form.phone?.trim()) return 'Please enter your phone number.';
            if (!this.form.consent) return 'Please confirm we may contact you.';
            return null;
        },
        async submitLead() {
            this.submitError = this.validateForm();
            if (this.submitError) return;

            this.submitting = true;
            this.submitError = null;

            try {
                const response = await fetch(config.submitUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': config.csrf,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        name: this.form.name.trim(),
                        phone: this.form.phone.trim(),
                        email: this.form.email?.trim() || null,
                        message: this.form.message?.trim() || null,
                        buyer_type: this.form.buyer_type || null,
                        budget: this.form.budget || null,
                        session_id: this.sessionId,
                        journey: this.activeJourney(),
                        page_url: window.location.href,
                        property_id: config.propertyId,
                        consent_callback: '1',
                    }),
                });

                if (!response.ok) {
                    const data = await response.json().catch(() => ({}));
                    const firstError = data.errors
                        ? Object.values(data.errors).flat()[0]
                        : null;
                    this.submitError = firstError || 'Something went wrong. Please try again.';
                    return;
                }

                this.submitted = true;
                this.track('lead_submit', { label: 'Contact form submitted', data: { ...this.form, consent: true } });
            } catch (e) {
                this.submitError = 'Unable to send right now. Check your connection and try again.';
            } finally {
                this.submitting = false;
            }
        },
    };
}
</script>
@endpush
