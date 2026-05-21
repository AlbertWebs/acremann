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
            aria-label="Open Acremann Assistant"
        >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            <span class="assistant-fab-badge" aria-hidden="true"></span>
        </button>
    </div>
    <div x-show="open" x-cloak class="absolute bottom-14 left-0 flex w-[22rem] max-w-[calc(100vw-2rem)] min-h-[32rem] max-h-[min(42rem,calc(100dvh-3rem))] flex-col rounded-sm border border-charcoal/10 bg-white shadow-xl">
        <div class="shrink-0 border-b border-charcoal/10 p-4">
            <p class="font-serif text-lg">{{ $assistantConfig['heading'] }}</p>
            <p class="text-xs text-muted">{{ $assistantConfig['subheading'] }}</p>
        </div>
        <div class="flex min-h-0 flex-1 flex-col overflow-hidden">
        <div class="min-h-0 flex-1 overflow-y-auto">
        <div class="space-y-2 p-4" x-show="step === 'menu'">
            @forelse($menuItems as $item)
                @if(in_array($item['action'], ['whatsapp', 'link'], true) && filled($item['url']))
                    <a
                        href="{{ $item['url'] }}"
                        @if($item['open_in_new_tab']) target="_blank" rel="noopener noreferrer" @endif
                        @click="track('{{ $item['action'] === 'whatsapp' ? 'whatsapp_click' : 'link_click' }}', { label: @js($item['label']) })"
                        @class([
                            'block w-full rounded-sm px-3 py-2 text-center text-sm',
                            'bg-[#25D366] text-white' => $item['action'] === 'whatsapp',
                            'border border-charcoal/10 hover:border-forest' => $item['action'] === 'link',
                        ])
                    >{{ $item['label'] }}</a>
                @else
                    <button
                        type="button"
                        @click="selectMenuItem(@js($item))"
                        class="w-full rounded-sm border border-charcoal/10 px-3 py-2 text-left text-sm hover:border-forest"
                    >{{ $item['label'] }}</button>
                @endif
            @empty
                <p class="text-sm text-muted">No menu items published. Add buttons in the admin under Acremann Assistant → Menu buttons.</p>
            @endforelse
        </div>
        <div class="p-4" x-show="step === 'faq'">
            @forelse($assistantFaqs as $faq)
                <details class="mb-2 text-sm" @toggle="onFaqToggle($event, @js($faq->question))">
                    <summary class="cursor-pointer font-medium">{{ $faq->question }}</summary>
                    <div class="mt-1 text-muted prose prose-sm max-w-none">{!! $faq->answer !!}</div>
                </details>
            @empty
                <p class="text-sm text-muted">No FAQs published for the assistant yet.</p>
            @endforelse
            <button type="button" @click="backToMenu()" class="mt-2 text-sm text-forest">← Back to menu</button>
        </div>
        <div x-show="step === 'title'" class="p-4 text-sm text-muted">
            <p>{{ $assistantConfig['title_body'] }}</p>
            @if(filled($assistantConfig['title_link_label']) && filled($assistantConfig['title_link_url']))
                <a href="{{ $assistantConfig['title_link_url'] }}" @click="track('link_click', { label: @js($assistantConfig['title_link_label']) })" class="mt-2 inline-block text-forest">{{ $assistantConfig['title_link_label'] }}</a>
            @endif
            <button type="button" @click="backToMenu()" class="mt-3 block text-sm text-forest">← Back to menu</button>
        </div>
        <div x-show="step === 'lead'" class="border-b border-charcoal/10 px-4 py-3">
            <div class="flex items-center justify-between gap-2">
                <p class="text-sm font-medium" x-text="formHeading()"></p>
                <button type="button" @click="backToMenu()" class="shrink-0 text-sm text-forest hover:underline">← Menu</button>
            </div>
        </div>
        </div>
        <div x-show="showEnquiryForm" x-cloak class="shrink-0 border-t border-charcoal/10 bg-cream/40">
            <form @submit.prevent="submitLead" class="acremann-form space-y-3 p-4" novalidate>
                <p x-show="step !== 'lead'" class="text-sm font-medium text-charcoal" x-text="formHeading()"></p>
                <p x-show="submitError" class="rounded-sm border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700" x-text="submitError"></p>
                <div x-show="!submitted" class="space-y-3">
                        <input type="text" x-model="form.name" @blur="trackField('name')" placeholder="Your name *" class="form-control" autocomplete="name">
                        <input type="tel" x-model="form.phone" @blur="trackField('phone')" placeholder="Phone *" class="form-control" autocomplete="tel">
                        <input type="email" x-model="form.email" @blur="trackField('email')" placeholder="Email (optional)" class="form-control" autocomplete="email">
                        <select x-model="form.buyer_type" @change="trackField('buyer_type')" class="form-control">
                            <option value="">I am a… (optional)</option>
                            @foreach($assistantConfig['buyer_types'] as $option)
                                <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                            @endforeach
                        </select>
                        <select x-model="form.budget" @change="trackField('budget')" class="form-control">
                            <option value="">Budget range (optional)</option>
                            @foreach($assistantConfig['budget_ranges'] as $option)
                                <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                            @endforeach
                        </select>
                        <textarea x-model="form.message" @blur="trackField('message')" placeholder="Tell us what you are looking for" class="form-control" rows="3"></textarea>
                        <label class="form-check">
                            <input type="checkbox" x-model="form.consent" @change="track('consent_toggle', { data: { consent: form.consent } })" class="form-check-input">
                            <span class="form-check-label">{{ $assistantConfig['consent_text'] }}</span>
                        </label>
                        <button type="submit" class="btn btn-primary w-full" :disabled="submitting" x-text="submitting ? 'Sending…' : 'Submit'"></button>
                </div>
                <div x-show="submitted" class="space-y-3">
                        <p class="text-sm text-forest" x-text="successMessage"></p>
                        <button type="button" @click="backToMenu()" class="w-full text-sm text-forest hover:underline">← Back to menu</button>
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
